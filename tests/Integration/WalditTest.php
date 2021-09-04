<?php

namespace tests\Integration;

use PHPUnit\Framework\TestCase;
use Waldit\Validator\Waldit;
use Waldit\Validator\WalditFactory;

final class WalditTest extends TestCase
{
    private Waldit $waldit;

    public function setUp(): void
    {
        $this->waldit = (new WalditFactory())->make();
        $this->waldit->setStopOnFirstError(true);
    }

    public function testSuccessValidateWithoutErrors() {
        $data = [
            'title' => 'not empty'
        ];

        $rules = [
            'title' => 'required|min:3'
        ];
        $this->waldit->setRules($rules);

        $this->assertTrue($this->waldit->validate($data));
    }

    public function testRequiredValidateRule()
    {
        $data = [];

        $rules = [
            'title' => 'required'
        ];

        $this->waldit->setRules($rules);
        $this->waldit->validate($data);

        $this->assertArrayHasKey('title.required', $this->waldit->getErrors());
    }

    public function testFailedValidateIsReturnFalse() {
        $data = [];

        $rules = [
            'title' => 'required'
        ];
        $this->waldit->setRules($rules);

        $this->assertFalse($this->waldit->validate($data));
    }

    public function testMakeFailedValidateCheckGetErrors()
    {
        $data = [];

        $rules = [
            'title' => 'required'
        ];

        $this->waldit->setRules($rules);
        $this->waldit->validate($data);

        $this->assertNotEmpty($this->waldit->getErrors());
    }


    public function dataProvider()
    {
        return [
            []
        ];
    }


}