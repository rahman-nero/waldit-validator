<?php


namespace Waldit\Validator\Contracts;


interface RuleInterface
{
    public function process($rule, $value, $parameters);
}