<?php

namespace tests\Feature;

use Waldit\Validator\Exception\MessageNotFoundException;
use Waldit\Validator\Exception\OverWriteMessageException;
use Waldit\Validator\Language;
use Waldit\Validator\MessageBag;
use PHPUnit\Framework\TestCase;

class MessageBagTest extends TestCase
{
    private MessageBag $messageBag;

    public function setUp(): void
    {
        $language = new Language();
        $language->setLanguage('en');
        $this->messageBag = new MessageBag($language);
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


    public function messagesProvider() {
        return [
            ['name', 'Delete your code'],
        ];
    }

}
