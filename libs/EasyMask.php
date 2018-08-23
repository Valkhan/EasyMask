<?php

namespace Valkhan\EasyTools;

/**
 * A unique file for most commom masks.
 * Easy PHP mask class for: Phone Numbers, Dates, Documents and more...
 * @version 1.0
 * @author Paulo Lima <pvcomercial@gmail.com>
 */
class EasyMask {

    /**
     * Mask a number.
     * @param string|int|float $number Number to be masked
     * @param int $dec Decimals (Default = 0)
     * @param string $ds Decimal separator (Default '.')
     * @param string $ts Thousand separator (Default '')
     * @param string $prefix Prefix (Useful for Currency symbol)
     * @param string $suffix Suffix (Useful for percentage, degrees)
     * @return string
     */
    public function number($number, $dec = 0, $ds = '.', $ts = '', $prefix = '', $suffix = '') {
        $newNumber = $this->sanitize($number, $dec == 0 ? 'number' : 'float');
        $tplNumber = "%s%s%s";
        $prefix = trim($prefix) !== '' ? $prefix . ' ' : '';
        $suffix = trim($suffix) !== '' ? ' ' . $suffix : '';
        return sprintf($tplNumber, $prefix, number_format($newNumber, $dec, $ds, $ts), $suffix);
    }

    /**
     * Applies phone mask for:
     * (8-9) digits phone + (2-3) digits area code + country code
     * @param string $phone Phone number to be masked
     * @return string
     */
    public function phone($phone) {
        //-- Standardize phone length for proper cutting
        $number = (int) $this->sanitize($phone, 'number');
        $phoneNumber = $this->fill($this->sanitize($number, 'number'), '0', 15);
        $lenNumber = (int) strlen($number);
        //-- Phone complexity controls
        $showCountry = false;
        $showArea = false;
        $noZeroArea = false;
        //-- Mount the phone mask
        $CountryCode = $AreaCode = $FirstBlock = $LastBlock = '';
        $LastBlock = substr($phoneNumber, -4);
        if ($lenNumber < 8 || $lenNumber > 14) {
            return $phone;
        } elseif ($lenNumber == 8) {
            //-- Simple 8 digits phone
            $FirstBlock = substr($phoneNumber, -8, 4);
        } elseif ($lenNumber == 9) {
            //-- Simple 9 digits phone
            $FirstBlock = substr($phoneNumber, -9, 5);
        } elseif ($lenNumber == 10) {
            //-- Area Code + Phone 8 digits
            $FirstBlock = substr($phoneNumber, -8, 4);
            $showArea = true;
            $AreaCode = substr($phoneNumber, -11, 3);
        } elseif ($lenNumber == 11) {
            //-- Area Code + Phone 9 digits
            $FirstBlock = substr($phoneNumber, -9, 5);
            $showArea = true;
            $AreaCode = substr($phoneNumber, -12, 3);
        } elseif ($lenNumber == 12) {
            //-- Country Code + Area Code + Phone 8 digits
            $FirstBlock = substr($phoneNumber, -8, 4);
            $showArea = true;
            $AreaCode = '0' . substr($phoneNumber, -10, 2);
            $showCountry = true;
            $CountryCode = substr($phoneNumber, -13, 3);
        } elseif ($lenNumber == 13) {
            $showArea = true;
            if ($phoneNumber[4] == '0') {
                //-- Country Code + Area Code + Phone 8 digits
                $FirstBlock = substr($phoneNumber, -8, 4);
                $AreaCode = substr($phoneNumber, -11, 3);
            } else {
                //-- Country Code + Area Code + Phone 9 digits
                $FirstBlock = substr($phoneNumber, -9, 5);
                $AreaCode = '0' . substr($phoneNumber, -11, 2);
            }
            $showCountry = true;
            $CountryCode = substr($phoneNumber, -14, 3);
        } elseif ($lenNumber == 14) {
            //-- Country Code + Area Code + Phone 9 digits
            $FirstBlock = substr($phoneNumber, -9, 5);
            $showArea = true;
            $AreaCode = substr($phoneNumber, -12, 3);
            $showCountry = true;
            $CountryCode = substr($phoneNumber, 0, 3);
        }
        $newNumber = ($showCountry ? "+$CountryCode" : '');
        $newNumber .= ($showArea ? "($AreaCode)" : '');
        $newNumber .= "{$FirstBlock}-{$LastBlock}";
        return $newNumber;
    }

    /**
     * Masks a given string for a given document type as:
     * CNPJ: 99.999.999/9999-99
     * CPJ/CNH: 999.999.999-99
     * RG: 99.999.999-A Note: valid digits for A: '0-9' and 'X' or 'Y'
     * IE/IM: 999.999.999.999
     * @param type $doc
     */
    public function document($document, $type = 'cpf') {
        switch (strtolower($type)) {
            case 'cnpj':
                $document = $this->fill($this->sanitize($document, 'number'), '0', 14, 'L');
                return preg_replace('/^(\d{2})(\d{3}){1}(\d{3}){1}(\d{4}){1}(\d{2})$/', '${1}.${2}.${3}/${4}-${5}', $document);
                break;
            case 'cnh';
            case 'cpf':
                $document = $this->fill($this->sanitize($document, 'number'), '0', 11, 'L');
                return preg_replace('/^(\d{1,3})(\d{3}){1}(\d{3}){1}(\d{2})$/', '${1}.${2}.${3}-${4}', $document);
                break;
            case 'rg':
                $document = trim(strtoupper($document));
                $lastDigit = substr($document, -1);
                $lastDigit = !in_array($lastDigit, array('X', 'Y')) ? intval($lastDigit) : $lastDigit;
                $document = $this->sanitize(substr($document, 0, -1), 'number') . $lastDigit;
                $document = $this->fill($document, '0', 9, 'L');
                return preg_replace('/^(\d{2})(\d{3})(\d{3})(\w{1})$/', '${1}.${2}.${3}-${4}', $document);
                break;
            case 'ie':
            case 'im':
                $document = $this->fill($this->sanitize($document, 'number'), '0', 12, 'L');
                return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{3})$/', '${1}.${2}.${3}.${4}', $document);
                break;
            case 'cep':
            case 'zipcode':
                $document = $this->fill($this->sanitize($document, 'number'), '0', 8, 'R');
                return preg_replace('/^(\d{5})(\d{3})$/', '${1}-${2}', $document);
                break;
            default:
                return $document;
                break;
        }
    }

    /**
     * Zip Code or CEP (Brazil)
     * @param string $zipcode 
     * @return string
     */
    public function zipCode($zipcode) {
        $zipcode = $this->sanitize($zipcode, 'number');
        $zipcode = strlen($zipcode) == 8 ? $zipcode : $this->fill($zipcode, '0', 8, 'R');
        return substr($zipcode, 0, 5) . '-' . substr($zipcode, -3);
    }

    /**
     * Format a date to a given output format.
     * @param string $date Date to be Masked
     * @param string $output_format Desired format, any valid format for date().
     * @param string $input_format Informed format, MUST HAVE 'd', 'm' and 'y' OR 'Y' like: d/m/Y or y-m-d
     * @return string
     */
    public function date($date, $output_format, $input_format) {
        $newDate = date($output_format, $this->getTimeFromDate($date, $input_format));
        return $newDate;
    }

    /**
     * Helper to translate $input_format so it can be correctly converted date to time.
     * @param string $date Date to be Masked.
     * @param string $input_format 
     * @return int
     */
    private function getTimeFromDate($date, $input_format) {
        //-- Change chars to it's respective size
        $newInput = str_replace('d', 'dd', $input_format);
        $newInput = str_replace('m', 'mm', $newInput);
        $newInput = str_replace('y', 'yy', $newInput);
        $newInput = str_replace('Y', 'YYYY', $newInput);
        //-- Get positions from format
        $dPos = strpos($newInput, 'd');
        $mPos = strpos($newInput, 'm');
        $yPos = strpos($newInput, 'y');
        $yPos = $yPos >= 0 ? $yPos : false;
        $YPos = $yPos === false ? strpos($newInput, 'Y') : false;
        //-- Recover data day, month and Year from date
        $d = substr($date, $dPos, 2);
        $m = substr($date, $mPos, 2);
        $y = substr($date, ($yPos === false ? $YPos : $yPos), ($yPos === false ? 4 : 2));
        return mktime(0, 0, 0, $m, $d, $y);
    }

    /**
     * Fill a string with a given char to a given lenth oriented by Rigth or Left
     * @param string $string String to be filled
     * @param char $char Character to fill
     * @param int $num Length to fill
     * @param string $orientacao R = Right | L = Left (Default)
     * @return string
     */
    private function fill($string, $char = '0', $num = 2, $orientacao = 'L') {
        while (strlen($string) < $num)
            $string = ($orientacao == 'R' ? $string . $char[0] : $char[0] . $string);
        return $string;
    }

    /**
     * Private sanitizer.
     * @param mixed $value Value to sanitize
     * @param string $mode Method to sanitize
     * @return mixed
     */
    private function sanitize($value, $mode) {
        switch ($mode) {
            case 'number':
                return preg_replace('/[^0-9]/i', '', $value);
                break;
            case 'float':
                return $this->toFloat($value);
                break;
            default:
                return $value;
                break;
        }
    }

    /**
     * Properly convert a number or string number to float.
     * @see http://php.net/manual/pt_BR/function.floatval.php <brewal.renault@gmail.com>
     * @param mixed $num Number to be converted
     * @return float
     */
    private function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
                ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
        return floatval(
                preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
                preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
        );
    }

}
