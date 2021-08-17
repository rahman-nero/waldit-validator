<?php


namespace Waldit\Validator;


use Waldit\Validator\Exception\MessageNotFoundException;
use Waldit\Validator\Exception\OverWriteMessageException;

final class MessageBag
{
    private array $messages = [];
    private bool $onOverwrite = false;

    public function __construct() {

    }

    public function setMessage($key, $value) {
        if (array_key_exists($key, $this->messages)
            && $this->getOnOverwriteValue() !== true) {
            throw new OverWriteMessageException();
        }

        $this->messages[$key] = $value;
    }

    public function getMessage($key) {
        if (!array_key_exists($key, $this->messages)) {
            throw new MessageNotFoundException();
        }
        return $this->messages[$key];
    }

    public function onOverwriteMessages(bool $value): void
    {
        $this->onOverwrite = $value;
    }

    public function getOnOverwriteValue(): bool
    {
        return $this->onOverwrite;
    }
}