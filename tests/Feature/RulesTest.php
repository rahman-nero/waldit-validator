<?php

namespace Feature;

use PHPUnit\Framework\TestCase;
use Waldit\Validator\Waldit;
use Waldit\Validator\WalditFactory;

final class RulesTest extends TestCase
{

    /**
     * @var Waldit
     */
    private Waldit $walditObj;

    public function setUp(): void
    {
        $this->walditObj = (new WalditFactory())->make();
    }

    /**
     * @dataProvider rulesDataProvider
     */
    public function testSetRules($rules)
    {
        $this->walditObj->setRules($rules);

        self::assertSame($this->walditObj->getRules(), $rules);
    }

    public function testHasRuleMethodIsReturnTrue() {
        $rules = [
            'name' => "required",
        ];
        $this->walditObj->setRules($rules);

        $this->assertTrue($this->walditObj->hasRule('name'));
    }

    public function testHasRuleMethodIsReturnFalse() {
        $rules = [
            'name' => "required",
        ];
        $this->walditObj->setRules($rules);

        $this->assertFalse($this->walditObj->hasRule('asb'));
    }

    public function rulesDataProvider()
    {
        return [
            [['name' => 'required|min:40']],
            [['alias' => 'required|min:40']],
            [['asin' => 'required|min:40']],
        ];
    }
}