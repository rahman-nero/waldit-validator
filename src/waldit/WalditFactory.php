<?php


namespace Waldit\Validator;


final class WalditFactory
{
    private $language;

    public function __construct()
    {
        $this->language = new Language();
    }

    public function make(array $rules = [], $language = 'ru', $stopOnFirstIfError = false) {
        # Установка языка
        $this->language->setLanguage($language);

        $messageBag = new MessageBag($this->language);

        $waldit = new Waldit($messageBag, $this->language);
        $waldit->setRules($rules);
        $waldit->setStopOnFirstError($stopOnFirstIfError);

        return $waldit;
    }
}