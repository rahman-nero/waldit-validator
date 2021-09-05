<?php


namespace Waldit\Validator\Contracts;


interface RuleInterface
{
    public function process($value): bool;
}