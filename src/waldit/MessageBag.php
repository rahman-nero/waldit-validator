<?php


namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;
use Waldit\Validator\Exception\MessageNotFoundException;

final class MessageBag
{
    private array $messages = [];
    private array $bagErrors = [];

    public function __construct(LanguageInterface $language)
    {
        $this->fillMessages($language);
    }

    public function hasMessage(string $key): bool
    {
        return array_key_exists($key, $this->messages);
    }

    public function setMessage($key, $value)
    {
        $this->messages[$key] = $value;
    }

    public function getMessage($key)
    {
        if (!array_key_exists($key, $this->messages)) {
            throw new MessageNotFoundException();
        }
        return $this->messages[$key];
    }

    public function setError($elem, $ruleName)
    {
        if (!array_key_exists($elem, $this->bagErrors)) {
            $message = sprintf("%s.%s", $elem, $ruleName);

            if ($this->hasMessage($message)) {
                $this->bagErrors[$elem] = $this->getMessage($message);
            } else {
                $this->bagErrors[$elem] = $this->getMessage($ruleName);
            }

        }
    }

    public function getBagErrors(): array
    {
        return $this->bagErrors;
    }


    private function fillMessages(LanguageInterface $language)
    {
        foreach ($language->getLanguageList() as $messageKey => $messageValue) {
            $this->setMessage($messageKey, $messageValue);
        }
    }
}