<?php

namespace tests;

use Waldit\Exception\MessageNotFoundException;
use Waldit\Exception\OverWriteMessageException;
use Waldit\MessageBag;
use PHPUnit\Framework\TestCase;

class MessageBagTest extends TestCase
{
    private MessageBag $messageBag;

    public function setUp(): void
    {
        $this->messageBag = new MessageBag();
    }

    /**
     * @dataProvider messagesProvider
    */
    public function testSetMessage($key, $value) {
        $this->messageBag->setMessage($key, $value);
        self::assertEquals($this->messageBag->getMessage($key), $value);
    }

    public function testExceptionIfEmptyMessage() {
        $this->expectException(MessageNotFoundException::class);
        $this->messageBag->getMessage('oasjpf');
    }

    public function testAllowOverWriteMessage() {
        $this->messageBag->onOverWriteMessages(true);
        #
        $this->messageBag->setMessage('name', 'Hehe e boy');
        $message1 = $this->messageBag->getMessage('name');
        #
        $this->messageBag->setMessage('name', 'This is not a boy');
        $message2 = $this->messageBag->getMessage('name');

        self::assertEquals($message1, 'Hehe e boy');
        self::assertEquals($message2, 'This is not a boy');
    }


    public function testNotAllowOverWriteMessage() {
        $this->expectException(OverWriteMessageException::class);
        $this->messageBag->onOverWriteMessages(false);
        #
        $this->messageBag->setMessage('name', 'Hehe e boy');
        $message1 = $this->messageBag->getMessage('name');
        #
        $this->messageBag->setMessage('name', 'This is not a boy');
        $message2 = $this->messageBag->getMessage('name');

        self::assertEquals($message1, 'Hehe e boy');
        self::assertEquals($message2, 'This is not a boy');
    }


    public function messagesProvider() {
        return [
            ['name', 'Удалите ваш тупой код'],
        ];
    }
}
