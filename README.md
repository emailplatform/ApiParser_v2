# ApiParser
PHP class for using our company's API v2 as part of the subscription.
<hr><br>

## Installation
Run following command in terminal from the root of your project:
```bash
composer require marketingplatform/api_parser
```
You can load dependencies by adding these lines to your code: 
```php
require_once 'vendor/marketingplatform/api_parser/src/settings.php';
require_once 'vendor/marketingplatform/api_parser/src/ApiParser.class.php';
```
<hr><br>

## How to use
1. Set up your API credentials (apiusername & apitoken) into **settings.php**
2. Create instance from **ApiParser.class.php**
```php
$parser = new ApiParser($settings);
```
3. Call method from ApiParser

```php
$subscriberid = 68317547;
$listid = 0;
$emailaddress = "";
$mobileNumenr = "";
$mobilePrefix = "";
$fieldid = 14;
$fieldValue = array(
   'Lastname' => "Tom",
   'Firstname' => 'Jones',
   'Date' => '31-12-2020 T00:00',
   'Active' => 0
);
$path = 'Users[Lastname=SimpleChange4]';

$result = $parser->UpdateOTMDocument($subscriberid, $listid, $emailaddress, $mobileNumber, $mobilePrefix, $fieldid, $fieldValue, $path);

print_r($result);
```
<hr><br>

## Changelog:
