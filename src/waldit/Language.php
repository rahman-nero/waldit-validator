<?php


namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;
use Waldit\Validator\Exception\InvalidLanguageTypeFileException;
use Waldit\Validator\Exception\LanguageNotFoundException;

final class Language implements LanguageInterface
{
    private string $default_language_autoload_path;
    private string $currentLanguageName;
    private array  $loadedLanguage = [];

    public function __construct(string $language = 'en', string $default_language_autoload_path = "/support/languages")
    {
        $this->setLanguageAutoloadPath($default_language_autoload_path);
        $this->setLanguage($language);
    }

    public function setLanguage($language): void
    {
        if ($this->loadLanguage($language)) {
            $this->currentLanguageName = $language;
        }
    }

    public function getLanguageList(): array
    {
        return $this->loadedLanguage;
    }

    public function getCurrentLanguage()
    {
        return $this->currentLanguageName;
    }

    private function loadLanguage($language): bool
    {
        $languagePath = sprintf('%s/%s.php', dirname(__DIR__) . $this->default_language_autoload_path, $language);
        if (!file_exists($languagePath)) {
            throw new LanguageNotFoundException($language);
        }

        $downloadedArray = require $languagePath;
        if (!is_array($downloadedArray)) {
            throw new InvalidLanguageTypeFileException();
        }

        $this->loadedLanguage = $downloadedArray;

        return true;
    }

    public function setLanguageAutoloadPath($path)
    {
        $this->default_language_autoload_path = $path;
    }
}