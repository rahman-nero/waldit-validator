<?php


namespace Waldit\Validator\Contracts;


interface LanguageInterface
{
    /**
     *
    */
    public function getLanguageList(): array;

    public function setLanguage($language);
}
