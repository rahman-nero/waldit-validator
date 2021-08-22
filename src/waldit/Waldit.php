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


    public function validate($data)
    {
        foreach ($data as $inputName => $valueInput) {
            if (!$this->hasRule($inputName)) continue;
            foreach ($this->rules as $ruleName => $ruleValue) {
                $explodedRule = $this->recursiveParse($ruleValue);

                $this->callValidateMethod($explodedRule);
            }
        }

    }

    protected function recursiveParse(string $rule)
    {
        $explodedRule = explode('|', $rule);

        $explodedRule = array_map(function ($elem) {
            $result = preg_match_all("#^(.*):(.*)$#i", $elem, $matches);

            if ($result === 1) {
                $methodName = $matches[1];
                $params = $matches[2];
            } elseif ($result === false) {
                throw new \Exception('Не смогли распарсить правило');
            }

            return $elem;
        }, $explodedRule);

        var_dump($explodedRule);
        return $explodedRule;
    }

    private function callValidateMethod(array $explodedRule)
    {

    }

    protected function hasRule($ruleName): bool
    {
        return array_key_exists($ruleName, $this->rules);
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