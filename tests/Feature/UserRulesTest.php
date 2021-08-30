<?php


namespace tests\Feature;


use PHPUnit\Framework\TestCase;
use Waldit\Validator\Exception\InvalidRuleException;
use Waldit\Validator\WalditFactory;

final class UserRulesTest extends TestCase
{
    private \Waldit\Validator\Waldit $waldit;

    public function setUp(): void
    {
        $this->waldit = (new WalditFactory())->make();
    }

    public function testNotValidRuleWithoutExtendsFromInterface()
    {
        $this->expectException(InvalidRuleException::class);
        $rule = $this->getMockBuilder('Rule')->getMock();

        $rules = [
            'title' => $rule,
        ];
        $data = [
            'title' => 'asdasd'
        ];

        $this->waldit->setRules($rules);
        $this->waldit->validate($data);
    }
}