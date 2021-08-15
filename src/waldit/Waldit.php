<?php
namespace Waldit;


final class Waldit
{
    private $rules;
    private $language;
    private $stopIfError;


    public function __construct(array $rules = [], $language = 'en', bool $stopIfError = false)
    {
        $this->rules = $rules;
        $this->language = $language;
        $this->stopIfError = $stopIfError;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    public function getStopIfError(): bool
    {
        return $this->stopIfError;
    }

    public function getLanguage()
    {
        return $this->language;
    }
}