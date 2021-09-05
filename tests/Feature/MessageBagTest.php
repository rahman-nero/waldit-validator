<?php

namespace tests\Feature;

use PHPUnit\Framework\TestCase;
use Waldit\Validator\Contracts\LanguageInterface;
use Waldit\Validator\Exception\MessageNotFoundException;
use Waldit\Validator\MessageBag;

class MessageBagTest extends TestCase
{
    private MessageBag $messageBag;

    public function setUp(): void
    {
        $language = $this->createMock(LanguageInterface::class);

        $language->method('getLanguageList')
            ->willReturn([]);

        $language->method('setLanguage')
            ->willReturn(null);

        $language->setLanguage('en');
        $this->messageBag = new MessageBag($language);
    }



    /**
     * @dataProvider messagesProvider
     */
    public function testSetMessage($key, $value)
    {
        $this->messageBag->setMessage($key, $value);
        self::assertEquals($this->messageBag->getMessage($key), $value);
    }

    public function testExceptionIfEmptyMessage()
    {
        $this->expectException(MessageNotFoundException::class);
        $this->messageBag->getMessage('oasjpf');
    }


    public function messagesProvider()
    {
        return [
            ['name', 'Delete your code'],
        ];
    }

}
