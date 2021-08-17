<?php


namespace Waldit\Validator;


final class WalditFactory
{
    private $messageBag;
    private $language;

    public function __construct()
    {
        $this->messageBag = new MessageBag();
        $this->language = new Language();
    }

    public function make(array $rules = [], $language = 'ru', $stopIfError = false) {
        # Установка языка
        $this->language->setLanguage($language);

        $waldit = new Waldit($this->messageBag, $this->language);
        $waldit->setRules($rules);
        $waldit->setStopOnFirstError($stopIfError);

        return $waldit;
    }
}