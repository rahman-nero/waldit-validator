<?php

namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;
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
        foreach ($data as $inputName => $valueInput) {
            # Проверка есть ли такое правило
            if (!$this->hasRule($inputName)) continue;
            # Перебираем правила и применяем по очередной
            foreach ($this->rules as $ruleName => $ruleValue) {
                # Сперва парсим правило
                $parsedRule = $this->recursiveParse($ruleValue);

                # Указываем какое правило обрабатываем на данный момент
                $this->currentElemValidation = $ruleName;

                # Вызываем метод для обработки, с передачей правила
                if(!$this->callValidateMethod($parsedRule, $valueInput)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getErrors() {
        return $this->messageBag->getBagErrors();
    }

    protected function recursiveParse(string $rule): array
    {
        # Разделяем правила: "required|min:3|max:4" и т.д
        $explodedRule = explode('|', $rule);

        $parsedRule = array_map(function ($elem) {
            $result = preg_match_all("#^(.*):(.*)$#i", $elem, $matches);

            if ($result === 1) {
                $methodName = $matches[1][0];
                $params = $matches[2];
            }elseif ($result === 0) {
                $methodName = $elem;
                $params = null;
            } elseif ($result === false) {
                throw new \Exception('Не смогли распарсить правило');
            }

            return ['method' => $methodName, 'params' => $params];
        }, $explodedRule);

        return $parsedRule;
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
                return $this->{$method}($value, ...$params);
            }

            return $this->{$method}($value);
        }

    }

    private function minValidate($value, $count): bool
    {
        if(is_string($value)) {
            $result = mb_strlen($value) > $count;
        }

        if (is_int($value)) {
            $result = $value > $count;
        }

        if($result === false) {
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