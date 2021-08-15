<?php

namespace tests\Feature;

use PHPUnit\Framework\TestCase;
use Waldit\Waldit;

final class WalditSetParamsTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function testConstructorSetter($rules, $lang, $stopIfError)
    {
        $walditObj = new Waldit($rules, $lang, $stopIfError);

        self::assertSame($walditObj->getRules(), $rules);
        self::assertSame($walditObj->getLanguage(), $lang);
        self::assertEquals($walditObj->getStopIfError(), $stopIfError);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testRules($rules) {
        $walditObj = new Waldit();
        $walditObj->setRules($rules);

        self::assertSame($walditObj->getRules(), $rules);
    }


    public function dataProvider()
    {
        return [
            [['name' => ['require', 'is_min:40']], 'ru', true],
            [['alias' => ['require', 'is_min:40']], 'en', false],
            [['asin' => ['require', 'is_min:40']], 'ru', true],
        ];
    }

}