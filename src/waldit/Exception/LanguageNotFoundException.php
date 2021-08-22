<?php


namespace Waldit\Validator\Exception;


final class LanguageNotFoundException extends \Exception
{
    private $language;

    /**
     * LanguageNotFoundException constructor.
     * @param $language
     */
    public function __construct($language)
    {
        $this->language = $language;
    }

    public function getNotFoundLanguage() {
        return $this->language;
    }
}