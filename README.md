# ApiParser
PHP class for using our company's API v2 as part of the subscription.
<hr><br>

## Installation
Run following command in terminal from the root of your project:
```bash
composer require marketingplatform/api_parser_2
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
$listid = 24;
$emailaddress = "contact@marketingplatform.com";
$mobileNumber = "72444444";
$mobilePrefix = "45";
$confirmed = false;
$addToAutoreposnders = false;

$result = $parser->AddProfileToList($listid, $emailaddress, $mobileNumber, $mobilePrefix, $confirmed, $addToAutoreposnders);

print_r($result);
```
<hr><br>

## Changelog:
