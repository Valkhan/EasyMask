# EasyMask
Easy PHP mask class for: Phone Numbers, Dates, Documents and more...

##Usage:

The file is self-explanatory, some examples below:
```
//include [pathtoclass]; //-- Only necessary if used without composer's autoload
$EasyMask = new Valkhan\EasyTools\EasyMask();
$EasyMask->date("2016-01-18","m/Y","Y-m-d"); // returns "01/2016"
$EasyMask->number("1234.56",2,",",""); // returns "R$ 1234,56"
$EasyMask->number("1234.56",2,",","","R$","reais."); // returns "R$ 1234,56 reais."
$EasyMask->phone("11112222"); // returns "1111-2222"
$EasyMask->phone("111112222"); // returns "11111-2222"
$EasyMask->phone("3311112222"); // returns "(033)1111-2222"
$EasyMask->phone("33111112222"); // returns "(033)11111-2222"
$EasyMask->phone("4433111112222"); // returns "+044(033)11111-2222"
```

##Future Plans:
* Add more masks :)

##Changelog:

v1.1.0
* Added support for most commom brazilian documents
* All documents where put in a single function
* Changed from substr to preg_replace
* Added test file

v1.0.1:
* Added composer.json and composer compatibility

v1.0.0:
* Added support for phone numbers: (8-9) digits phone + (2-3) digits area code + country code
* Added support for dates.
* Added support for Zip Codes.
* Added support for Documents: CPF/CNPJ (Brazil)
* Added support for Numbers.
