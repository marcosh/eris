<?php
use Eris\Generator;

class NamesTest extends \PHPUnit\Framework\TestCase
{
    use Eris\TestTrait;

    public function testGeneratingNames()
    {
        $this->forAll(
            Generator\names()
        )->then(function ($name) {
            var_dump($name);
        });
    }

    public function testSamplingShrinkingOfNames()
    {
        $generator = Generator\NamesGenerator::defaultDataSet();
        var_dump($this->sampleShrink($generator)->collected());
    }
}
