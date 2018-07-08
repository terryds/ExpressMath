# ExpressMath

ExpressMath is a parser for its own math/computational problem markup language.  
The markup language is inspired from Jinja template.
See example for better understanding of how this works

## Installing
ExpressMath installation using Composer  
```
composer require terrydjony/ExpressMath
```

## Example

```php
require 'vendor/autoload.php';

use ExpressMath\ExpressMath;

$mathlang = 'Jika Andi punya {{ a }} bola, dan Budi punya {{ b }} bola, maka jumlah bola mereka adalah {% a + b %}';
$config = [
    'a' => mt_rand(2,5)
];

$expressMath = new ExpressMath();

$eval = $expressMath->eval($mathlang, $config);

var_dump($eval->getProblem()); // Jika Andi punya 4 bola, dan Budi punya 56 bola, maka jumlah bola mereka adalah
var_dump($eval->getVariables()); //   ['a' => 4, 'b' => 56]
var_dump($eval->getValue()); // 60
```