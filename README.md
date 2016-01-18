# EasyMask
Easy PHP mask class for: Phone Numbers, Dates, Documents and more...

##Usage:

The file is self-explanatory, some examples below:
```
include [pathtoclass];
$EasyMask = new EasyMask();
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
* Add support for more Brazilian Documents: RG (Registro Geral), IE (Inscrição Estadual) and IM (Inscrição Municipal).
* Add a function to centralize documents masks. 
* Add composer.json




##Changelog:

v1.0:
* Added support for phone numbers: (8-9) digits phone + (2-3) digits area code + country code
* Added support for dates.
* Added support for Zip Codes.
* Added support for Documents: CPF/CNPJ (Brazil)
* Added support for Numbers.
