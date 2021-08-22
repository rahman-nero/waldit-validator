<?php


use Waldit\Validator\WalditFactory;

require_once 'vendor/autoload.php';

$waldit = (new WalditFactory())->make();

$rules = [
    'title' => 'min:3|string'
];

$waldit->setRules($rules);

$data = [
  'title' => "Ну привет"
];

$waldit->validate($data);