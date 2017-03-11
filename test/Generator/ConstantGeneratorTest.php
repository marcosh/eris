<?php
namespace Eris\Generator;

use PHPUnit\Framework\TestCase;

class ConstantGeneratorTest extends TestCase
{
    protected function setUp()
    {
        $this->size = 0;
        $this->rand = 'rand';
    }

    public function testPicksAlwaysTheValue()
    {
        $generator = new ConstantGenerator(true);
        for ($i = 0; $i < 50; $i++) {
            $this->assertTrue($generator($this->size, $this->rand)->unbox());
        }
    }

    public function testShrinkAlwaysToTheValue()
    {
        $generator = new ConstantGenerator(true);
        $element = $generator($this->size, $this->rand);
        for ($i = 0; $i < 50; $i++) {
            $this->assertTrue($generator->shrink($element)->unbox());
        }
    }

    public function testContainsOnlyTheValue()
    {
        $generator = new ConstantGenerator(true);
        $this->assertTrue($generator->contains(GeneratedValue::fromJustValue(true)));
        $this->assertFalse($generator->contains(GeneratedValue::fromJustValue(42)));
    }

    /**
     * @expectedException DomainException
     */
    public function testShrinkOnlyAcceptsElementsOfTheDomainAsParameters()
    {
        $generator = new ConstantGenerator(5);
        $generator->shrink(GeneratedValue::fromJustValue(10));
    }
}
