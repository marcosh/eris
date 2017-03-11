<?php
namespace Eris\Generator;

use PHPUnit\Framework\TestCase;

class BooleanGeneratorTest extends TestCase
{
    public function setUp()
    {
        $this->rand = 'rand';
    }
    
    public function testRandomlyPicksTrueOrFalse()
    {
        $generator = new BooleanGenerator();
        for ($i = 0; $i < 10; $i++) {
            $generatedValue = $generator($_size = 0, $this->rand);
            $this->assertTrue($generator->contains($generatedValue));
        }
    }

    public function testShrinksToFalse()
    {
        $generator = new BooleanGenerator();
        for ($i = 0; $i < 10; $i++) {
            $generatedValue = $generator($_size = 10, $this->rand);
            $this->assertFalse($generator->shrink($generatedValue));
        }
    }

    /**
     * @expectedException DomainException
     */
    public function testShrinkOnlyAcceptsElementsOfTheDomainAsParameters()
    {
        $generator = new BooleanGenerator();
        $generator->shrink(GeneratedValue::fromJustValue(10));
    }
}
