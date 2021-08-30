<?php


namespace tests\Feature;

use PHPUnit\Framework\TestCase;
use Waldit\Validator\Exception\InvalidLanguageTypeFileException;
use Waldit\Validator\Exception\LanguageNotFoundException;
use Waldit\Validator\Language;

final class LanguageTest extends TestCase
{
    private Language $language;

    public function setUp(): void
    {
        $this->language = new Language('en');
    }

    public function testCheckoutLanguage()
    {
        $this->language->setLanguage('en');
        $this->assertSame($this->language->getCurrentLanguage(), 'en');
    }

    public function testExceptionIfSetNotExistsLanguage() {
        $this->expectException(LanguageNotFoundException::class);
        $this->language->setLanguage('asd');
    }

    public function testOnInvalidLanguageTypeFile() {
        $this->expectException(InvalidLanguageTypeFileException::class);
        $this->language->setLanguage('invalidateFile');
    }

}