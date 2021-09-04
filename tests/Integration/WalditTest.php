<?php


namespace tests\Integration;


use PHPUnit\Framework\TestCase;
use Waldit\Validator\WalditFactory;

final class WalditTest extends TestCase
{

    public function setUp(): void
    {
        $this->waldit = (new WalditFactory())->make();
    }

}