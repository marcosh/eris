<?php
namespace Eris\Generator;

use PHPUnit\Framework\TestCase;

class GeneratedValueTest extends TestCase
{
    public function testCanBeMappedToDeriveValues()
    {
        $initialValue = GeneratedValue::fromJustValue(
            3,
            'my-generator'
        );
        $this->assertEquals(
            GeneratedValue::fromValueAndInput(
                6,
                $initialValue,
                'derived-generator'
            ),
            $initialValue->map(
                function ($value) {
                    return $value * 2;
                },
                'derived-generator'
            )
        );
    }

    public function testDerivedValueCanBeAnnotatedWithNewGeneratorNameWithoutBeingChanged()
    {
        $initialValue = GeneratedValue::fromJustValue(
            3,
            'my-generator'
        );
        $this->assertEquals(
            GeneratedValue::fromValueAndInput(
                3,
                $initialValue,
                'derived-generator'
            ),
            $initialValue->derivedIn('derived-generator')
        );
    }

    public function testCanBeRepresentedOnOutput()
    {
        $generatedValue = GeneratedValue::fromValueAndInput(
            422,
            GeneratedValue::fromJustValue(211),
            'map'
        );
        $this->assertInternalType('string', $generatedValue->__toString());
        $this->assertRegExp('/value.*422/', $generatedValue->__toString());
        $this->assertRegExp('/211/', $generatedValue->__toString());
        $this->assertRegExp('/generator.*map/', $generatedValue->__toString());
    }
}
