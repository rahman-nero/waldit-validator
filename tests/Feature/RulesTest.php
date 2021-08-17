<?php

namespace Feature;

use PHPUnit\Framework\TestCase;
use Waldit\Validator\Waldit;
use Waldit\Validator\WalditFactory;

final class RulesTest extends TestCase
{
    /**
     * @dataProvider rulesDataProvider
     */
    public function testSetRules($rules)
    {
        $walditObj = (new WalditFactory())->make();
        $walditObj->setRules($rules);

        self::assertSame($walditObj->getRules(), $rules);
    }

    public function rulesDataProvider()
    {
        return [
            [['name' => 'required|is_min:40']],
            [['alias' => 'required|is_min:40']],
            [['asin' => 'required|is_min:40']],
        ];
    }
}