<?php

require_once '../libs/easymask.php';

use Valkhan\EasyTools;

$EasyMask = new EasyTools\EasyMask();

echo '<h2>Documents</h2>';
echo 'CEP: 11111222 -> ',$EasyMask->document('11111222','zipcode'), '<br>';
echo 'CEP: 11111 -> ',$EasyMask->document('11111','cep'), '<br>';
echo '<hr>';
echo 'CPF: 11122233344 -> ', $EasyMask->document('11122233344', 'cpf'), '<br>';
echo 'CPF: 122233344 -> ', $EasyMask->document('122233344', 'cpf'), '<br>';
echo 'CPF: 2233344 -> ', $EasyMask->document('2233344', 'cpf'), '<br>';
echo '<hr>';
echo 'CNPJ: 2333444455 -> ', $EasyMask->document('2333444455', 'cnpj'), '<br>';
echo 'CNPJ: 222333444455 -> ', $EasyMask->document('222333444455', 'cnpj'), '<br>';
echo 'CNPJ: 1222333444455 -> ', $EasyMask->document('1222333444455', 'cnpj'), '<br>';
echo 'CNPJ: 11222333444455 -> ', $EasyMask->document('11222333444455', 'cnpj'), '<br>';
echo '<hr>';
echo 'RG: 2223334 -> ', $EasyMask->document('2223334', 'rg'), '<br>';
echo 'RG: 1222333X -> ', $EasyMask->document('1222333X', 'rg'), '<br>';
echo 'RG: 11222333Y -> ', $EasyMask->document('11222333Y', 'rg'), '<br>';
echo '<hr>';
echo 'IE: 2333444 -> ', $EasyMask->document('2333444', 'ie'), '<br>';
echo 'IE: 1222333444 -> ', $EasyMask->document('1222333444', 'ie'), '<br>';
echo 'IM: 111222333444 -> ', $EasyMask->document('111222333444', 'im'), '<br>';
echo '<hr>';
echo '<h2>Dates:</h2>';
echo 'DATE: from Y-m-d 2016-01-18 to m/d/Y -> ', $EasyMask->date("2016-01-18", "m/Y", "Y-m-d"), '<br>';
echo '<hr>';
echo '<h2>Numbers:</h2>';
echo 'NUMBER: 1234.56 with 2 decimals -> ', $EasyMask->number("1234.56", 2, ",", ""), '<br>';
echo 'NUMBER: 1234.56 with 2 decimals + prefix + suffix -> ', $EasyMask->number("1234.56", 2, ",", "", "R$", "reais."), '<br>';
echo '<hr>';
echo '<h2>Phones:</h2>';
echo 'PHONE: 11112222 -> ',$EasyMask->phone("11112222"), '<br>';
echo 'PHONE: 111112222 -> ',$EasyMask->phone("111112222"), '<br>';
echo 'PHONE: 3311112222 -> ',$EasyMask->phone("3311112222"), '<br>';
echo 'PHONE: 33111112222 -> ',$EasyMask->phone("33111112222"), '<br>';
echo 'PHONE: 4433111112222 -> ',$EasyMask->phone("4433111112222"), '<br>';
