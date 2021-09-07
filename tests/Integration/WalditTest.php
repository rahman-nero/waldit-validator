<?php

namespace tests\Integration;

use PHPUnit\Framework\TestCase;
use Waldit\Validator\Contracts\RuleInterface;
use Waldit\Validator\Exception\InvalidRuleException;
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

    /**
     * @dataProvider rulesProvider
     */
    public function testSuccessValidate(array $rules, array $data, array $messages)
    {
        $this->waldit->setRules($rules);
        $this->waldit->setMessages($messages);

        $this->assertTrue($this->waldit->validate($data));
    }

    /**
     * @dataProvider failedRules
    */
    public function testFailedValidate(array $rules, array $data, array $messages)
    {
        $this->waldit->setRules($rules);
        $this->waldit->setMessages($messages);
        $this->waldit->validate($data);

        $this->assertFalse($this->waldit->validate($data));
        $this->assertNotEmpty($this->waldit->getErrors());
    }

    /**
     * @dataProvider myRulesProvider
     */
    public function testMyCreatedRuleNeedSuccessfully(array $rules, array $data, array $messages)
    {
        $this->waldit->setRules($rules);
        $this->waldit->setMessages($messages);

        $this->assertTrue($this->waldit->validate($data));
    }

    /**
     * @dataProvider myRulesWhichNotAcceptedProvider
     */
    public function testMyCreatedRuleNeedFailed(array $rules, array $data, array $messages)
    {
        $this->waldit->setRules($rules);
        $this->waldit->setMessages($messages);


        $this->assertFalse($this->waldit->validate($data));
    }

    /**
     * @dataProvider myInvalidateRules
     */
    public function testInvalidateRuleCatchException(array $rules)
    {
        $this->expectException(InvalidRuleException::class);
        $this->waldit->setRules($rules);

        $this->waldit->validate([]);
    }

    public function rulesProvider()
    {
        return [
            [['name' => 'required'], ['name' => 'asdasd'], ['name.required' => 'У тебя ошибка']],
            [['count' => 'min:3'], ['count' => 33], ['count.min' => 'У тебя ошибка']],
        ];
    }

    public function failedRules()
    {
        return [
            [['name' => 'required'], [], ['name.required' => 'У тебя ошибка']],
            [['count' => 'min:3'], ['count' => 1], ['count.min' => 'У тебя ошибка']],
        ];
    }

    public function myRulesProvider()
    {
        return [
            [['name' => new IsStringRule], ['name' => 'asdasd'], ['name.class' => 'У тебя ошибка']],
            [['count' => new IsIntRule], ['count' => 33], ['count.class' => 'У тебя ошибка']],
        ];
    }

    public function myRulesWhichNotAcceptedProvider()
    {
        return [
            [['name' => new IsStringRule], ['name' => 334], ['name.class' => 'У тебя ошибка']],
            [['count' => new IsIntRule], ['count' => 'asd'], ['count.class' => 'У тебя ошибка']],
        ];
    }

    public function myInvalidateRules()
    {
        return [
            [['name' => new IsInvalidateRule()]],
        ];
    }

}

class IsStringRule implements RuleInterface
{

    public function process($value): bool
    {
        if (is_string($value)) {
            return true;
        }
        return false;
    }
}

class IsIntRule implements RuleInterface
{

    public function process($value): bool
    {
        if (is_int($value)) {
            return true;
        }
        return false;
    }
}

class IsInvalidateRule
{

}