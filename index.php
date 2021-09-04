<?php


use Waldit\Validator\Exception\NotExistsValidatorMethodException;
use Waldit\Validator\WalditFactory;

require_once 'vendor/autoload.php';
$waldit = (new WalditFactory())->make();

$rules = [
    'title' => 'required|min:3',
];

$data = [
];

$messages = [
    'title.min' => 'Минимальное значение в поле должно быть 3 символа',
];


$waldit->setRules($rules);
$waldit->setMessages($messages);

try {

    if ($waldit->validate($data)) {
        echo 'Все прошло успешно';
    } else {
        dd($waldit->getErrors());
    }

} catch (NotExistsValidatorMethodException $e) {
    echo sprintf("Вызов метода валидатора прошел не успешно, %s", $e->getMethodName());
}
