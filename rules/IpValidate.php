<?php

namespace Rules;

use Waldit\Validator\Contracts\RuleInterface;

final class IpValidate implements RuleInterface
{

    public function process($value):bool
    {
        return false;
    }

    private function parse()
    {
    }
}