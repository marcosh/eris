<?php
use Eris\Generator;

class SuchThatTest extends \PHPUnit\Framework\TestCase
{
    use Eris\TestTrait;

    public function testSuchThatBuildsANewGeneratorFilteringTheInnerOne()
    {
        $this
            ->forAll(
                Generator\vector(
                    5,
                    Generator\suchThat(
                        function ($n) {
                            return $n > 42;
                        },
                        Generator\choose(0, 1000)
                    )
                )
            )
            ->then($this->allNumbersAreBiggerThan(42));
    }

    public function testFilterSyntax()
    {
        $this
            ->forAll(
                Generator\vector(
                    5,
                    Generator\filter(
                        function ($n) {
                            return $n > 42;
                        },
                        Generator\choose(0, 1000)
                    )
                )
            )
            ->then($this->allNumbersAreBiggerThan(42));
    }

    public function testSuchThatAcceptsPHPUnitConstraints()
    {
        $this
            ->forAll(
                Generator\vector(
                    5,
                    Generator\suchThat(
                        $this->isType('integer'),
                        Generator\oneOf(
                            Generator\choose(0, 1000),
                            Generator\string()
                        )
                    )
                )
            )
            ->then($this->allNumbersAreBiggerThan(42));
    }


    public function testSuchThatShrinkingRespectsTheCondition()
    {
        $this
            ->forAll(
                Generator\suchThat(
                    function ($n) {
                        return $n > 42;
                    },
                    Generator\choose(0, 1000)
                )
            )
            ->then($this->numberIsBiggerThan(100));
    }

    public function testSuchThatShrinkingRespectsTheConditionButTriesToSkipOverTheNotAllowedSet()
    {
        $this
            ->forAll(
                Generator\suchThat(
                    function ($n) {
                        return $n <> 42;
                    },
                    Generator\choose(0, 1000)
                )
            )
            ->then($this->numberIsBiggerThan(100));
    }

    public function allNumbersAreBiggerThan($lowerLimit)
    {
        return function ($vector) use ($lowerLimit) {
            foreach ($vector as $number) {
                $this->assertTrue(
                    $number > $lowerLimit,
                    "\$number was asserted to be more than $lowerLimit, but it's $number"
                );
            }
        };
    }

    public function numberIsBiggerThan($lowerLimit)
    {
        return function ($number) use ($lowerLimit) {
            $this->assertTrue(
                $number > $lowerLimit,
                "\$number was asserted to be more than $lowerLimit, but it's $number"
            );
        };
    }
}
