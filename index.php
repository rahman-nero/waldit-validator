<?php


use Waldit\Validator\Exception\NotExistsValidatorMethodException;
use Waldit\Validator\WalditFactory;

require_once 'vendor/autoload.php';
$waldit = (new WalditFactory())->make();

$rules = [
    'title' => 'min:3'
];

$data = [
    'title' => "у"
];

$messages = [
    'title' => 'Да черт, у вас там все сгорело'
];


$waldit->setRules($rules);
//$waldit->setMessages($messages);

try {
    if ($waldit->validate($data)) {
        echo 'Все прошло успешно';
    } else {
        dd($waldit->getErrors());
    }

} catch (NotExistsValidatorMethodException $e) {
    echo $e->getMethodName();
}
