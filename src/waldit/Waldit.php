<?php

namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;
use Waldit\Validator\Contracts\RuleInterface;
use Waldit\Validator\Exception\InvalidRuleException;
use Waldit\Validator\Exception\NotExistsValidatorMethodException;

final class Waldit
{
    private LanguageInterface $language;
    private MessageBag $messageBag;

    private array $rules;
    private bool $stopOnFirstError;
    private $currentElemValidation;


    public function __construct(MessageBag $messageBag, LanguageInterface $language)
    {
        $this->messageBag = $messageBag;
        $this->language = $language;
    }

    public function validate($data): bool
    {
        # Перебираем все правила
        foreach ($this->rules as $ruleName => $ruleValue) {
            $this->currentElemValidation = $ruleName;

            $parsedRule = $this->recursiveParse($ruleValue);

            # Вызываем метод для обработки, с передачей правил
            if (!$this->callValidateMethod($parsedRule, $data[$ruleName] ?? null)) {
                return false;
            }

        }

        return true;
    }

    private function requiredValidate($value): bool
    {
        if ($value === null) {
            $this->messageBag->setError($this->currentElemValidation, 'required');
            return false;
        }
        return true;
    }


    public function getErrors()
    {
        return $this->messageBag->getBagErrors();
    }

    protected function recursiveParse($rule): array
    {
        # Если передан объект класса, то делегируем работу к другому материалу
        if (is_object($rule)) {
            $parsedRule = $this->parseObjectRule($rule);
        }

        if (is_string($rule)) {
            $parsedRule = $this->parseTextRule($rule);
        }

        return $parsedRule;
    }

    private function parseTextRule(string $rule): array
    {
        # Разделяем правила: "required|min:3|max:4" и т.д
        $explodedRule = explode('|', $rule);

        $parsedRule = array_map(function ($elem) {
            $result = preg_match_all("#^(.*):(.*)$#i", $elem, $matches);

            if ($result === 1) {
                $methodName = $matches[1][0];
                $params = $matches[2];
            } elseif ($result === 0) {
                $methodName = $elem;
                $params = null;
            } elseif ($result === false) {
                throw new \Exception('Не смогли распарсить правило');
            }

            return ['method' => $methodName, 'params' => $params];
        }, $explodedRule);

        return $parsedRule;
    }

    private function parseObjectRule(object $rule): array
    {
        if (!($rule instanceof RuleInterface)) {
            throw new InvalidRuleException();
        }
        return [];
    }

    private function callValidateMethod(array $parsedRules, $value)
    {
        foreach ($parsedRules as $parsedElem) {
            $method = sprintf("%sValidate", $parsedElem['method']);
            $params = $parsedElem['params'];
            if (!method_exists($this, $method)) {
                throw new NotExistsValidatorMethodException($method);
            }

            if (!is_null($params)) {
                $result = $this->{$method}($value, ...$params);
            } else if (is_null($params)) {
                $result = $this->{$method}($value);
            }

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    private function minValidate($value, $count): bool
    {
        if (is_string($value)) {
            $result = mb_strlen($value) > $count;
        }

        if (is_int($value)) {
            $result = $value > $count;
        }

        if ($value === null || $result === false) {
            $this->messageBag->setError($this->currentElemValidation, 'min');
            return false;
        }

        return true;
    }

    public function setMessages(array $arrayMessages): void
    {
        foreach ($arrayMessages as $keyRule => $message) {
            $this->messageBag->setMessage($keyRule, $message);
        }
    }

    public function hasRule($ruleName): bool
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