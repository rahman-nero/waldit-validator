<?php

namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;

final class Waldit
{
    private LanguageInterface $language;
    private MessageBag $messageBag;

    private array $rules;
    private bool $stopOnFirstError;


    public function __construct(MessageBag $messageBag, LanguageInterface $language)
    {
        $this->messageBag = $messageBag;
        $this->language = $language;
    }


    public function getRules(): array
    {
        return $this->rules;
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    public function getStopOnFirstError(): bool
    {
        return $this->stopOnFirstError;
    }

    public function setStopOnFirstError(bool $val)
    {
        $this->stopOnFirstError = $val;
    }

    public function getLanguage()
    {
        return $this->language;
    }
}