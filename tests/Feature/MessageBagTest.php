<?php

namespace tests\Feature;

use Waldit\Validator\Exception\MessageNotFoundException;
use Waldit\Validator\Exception\OverWriteMessageException;
use Waldit\Validator\MessageBag;
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

    public function testAllowOverwriteMessage() {
        $this->messageBag->onOverwriteMessages(true);
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
        $this->messageBag->onOverwriteMessages(false);
        #s
        $this->messageBag->setMessage('name', 'Hehe e boy');
        #
        $this->messageBag->setMessage('name', 'This is not a boy');
    }


    public function messagesProvider() {
        return [
            ['name', 'Delete your code'],
        ];
    }

}
