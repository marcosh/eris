<?php
namespace Eris\Generator;

use PHPUnit\Framework\TestCase;

class FloatGeneratorTest extends TestCase
{
    protected function setUp()
    {
        $this->size = 300;
        $this->rand = 'rand';
    }

    public function testPicksUniformelyPositiveAndNegativeFloatNumbers()
    {
        $generator = new FloatGenerator();
        $sum = 0;
        $trials = 500;
        for ($i = 0; $i < $trials; $i++) {
            $value = $generator($this->size, $this->rand);
            $this->assertInternalType('float', $value->unbox());
            $sum += $value->unbox();
        }
        $mean = $sum / $trials;
        // over a 300 size
        $this->assertLessThan(10, abs($mean));
    }

    public function testShrinksLinearly()
    {
        $generator = new FloatGenerator();
        $this->assertSame(3.5, $generator->shrink(GeneratedValue::fromJustValue(4.5))->unbox());
        $this->assertSame(-2.5, $generator->shrink(GeneratedValue::fromJustValue(-3.5))->unbox());
    }

    public function testWhenBothSignsArePossibleCannotShrinkBelowZero()
    {
        $generator = new FloatGenerator();
        $this->assertSame(0.0, $generator->shrink(GeneratedValue::fromJustValue(0.0))->unbox());
        $this->assertSame(0.0, $generator->shrink(GeneratedValue::fromJustValue(0.5))->unbox());
        $this->assertSame(0.0, $generator->shrink(GeneratedValue::fromJustValue(-0.5))->unbox());
    }

    /**
     * @expectedException DomainException
     */
    public function testExceptionWhenTryingToShrinkValuesOutsideOfTheDomain()
    {
        $generator = new FloatGenerator(100.12, 200.12);
        $generator->shrink(GeneratedValue::fromJustValue(300));
    }
}
