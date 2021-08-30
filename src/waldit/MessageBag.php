<?php


namespace Waldit\Validator;


use Waldit\Validator\Contracts\LanguageInterface;
use Waldit\Validator\Exception\MessageNotFoundException;
use Waldit\Validator\Exception\OverWriteMessageException;

final class MessageBag
{
    private array $messages = [];
    private LanguageInterface $language;

    public function __construct(LanguageInterface $language)
    {
        $this->language = $language;
        $this->fillMessages();
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

    private function fillMessages()
    {
        foreach ($this->language->getLanguageList() as $messageKey => $messageValue) {
            $this->setMessage($messageKey, $messageValue);
        }
    }
}