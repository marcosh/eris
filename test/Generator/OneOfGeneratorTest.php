<?php
namespace Eris\Generator;

use PHPUnit\Framework\TestCase;

class OneOfGeneratorTest extends TestCase
{
    protected function setUp()
    {
        $this->singleElementGenerator = new ChooseGenerator(0, 100);
        $this->size = 10;
        $this->rand = 'rand';
    }

    public function testConstructWithAnArrayOfGenerators()
    {
        $generator = new OneOfGenerator([
            $this->singleElementGenerator,
            $this->singleElementGenerator,
        ]);

        $element = $generator($this->size, $this->rand);

        $this->assertTrue($generator->contains($element));
    }

    public function testConstructWithNonGenerators()
    {
        $generator = new OneOfGenerator([42, 42]);
        $element = $generator($this->size, $this->rand)->unbox();
        $this->assertEquals(42, $element);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructWithNoArguments()
    {
        $generator = new OneOfGenerator([]);
        $element = $generator($this->size, $this->rand);
    }
}
