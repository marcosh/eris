<?php
use Eris\Generator;
use Eris\Random;
use Eris\TestTrait;

class RandConfigurationTest extends \PHPUnit\Framework\TestCase
{
    use TestTrait;

    public function testUsingTheDefaultRandFunction()
    {
        $this
            ->withRand('rand')
            ->forAll(
                Generator\int()
            )
            ->withMaxSize(1000 * 1000* 1000)
            ->then($this->isInteger());
    }

    public function testUsingTheDefaultMtRandFunction()
    {
        $this
            ->withRand('mt_rand')
            ->forAll(
                Generator\int()
            )
            ->then($this->isInteger());
    }

    public function testUsingThePurePhpMtRandFunction()
    {
        $this
            ->withRand(Random\purePhpMtRand())
            ->forAll(
                Generator\int()
            )
            ->then($this->isInteger());
    }

    private function isInteger()
    {
        return function ($number) {
            $this->assertInternalType('integer', $number);
        };
    }
}
