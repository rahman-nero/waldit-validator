<?php


namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;
use Waldit\Validator\Exception\LanguageNotFoundException;

final class Language implements LanguageInterface
{
    const DEFAULT_DIRECTORY_AUTOLOAD = "/support/languages";
    private string $currentLanguageName;
    private array $loadedLanguage;

    public function __construct()
    {
    }

    public function setLanguage($language): void
    {
        $this->loadLanguage($language);
        $this->currentLanguage = $language;
    }

    public function getLang(): array
    {
        return $this->loadedLanguage;
    }

    private function loadLanguage($language)
    {
        $languagePath = sprintf('%s/%s.php', dirname(__DIR__) . self::DEFAULT_DIRECTORY_AUTOLOAD, $language);

        var_dump($languagePath);
        if (!file_exists($languagePath)) {
            throw new LanguageNotFoundException($language);
        }
        $this->loadedLanguage = require_once $languagePath;
    }
}