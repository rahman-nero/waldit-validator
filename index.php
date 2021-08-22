<?php


use Waldit\Validator\Exception\NotExistsValidatorMethodException;
use Waldit\Validator\WalditFactory;

require_once 'vendor/autoload.php';

$waldit = (new WalditFactory())->make();

$rules = [
    'title' => 'min:3|string|length:8'
];

$waldit->setRules($rules);

$data = [
  'title' => "Ну22222"
];

try {
    $waldit->validate($data);
} catch (NotExistsValidatorMethodException $e) {
    echo $e->getMethodName();
}
