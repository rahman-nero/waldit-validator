<?php


namespace Waldit;


use Waldit\Exception\MessageNotFoundException;
use Waldit\Exception\OverWriteMessageException;

final class MessageBag
{
    private array $messages = [];
    private bool $onOverWrite = false;

    public function __construct() {

    }

    public function setMessage($key, $value) {
        if (array_key_exists($key, $this->messages)
            && $this->getOnOverWriteValue() !== true) {
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

    public function onOverWriteMessages(bool $value): void
    {
        $this->onOverWrite = $value;
    }

    public function getOnOverWriteValue(): bool
    {
        return $this->onOverWrite;
    }


}