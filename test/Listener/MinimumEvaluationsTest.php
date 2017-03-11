<?php
namespace Eris\Listener;

use Eris\Generator\GeneratedValue;
use LogicException;
use PHPUnit\Framework\TestCase;

class MinimumEvaluationsTest extends TestCase
{
    protected function setUp()
    {
        $this->listener = MinimumEvaluations::ratio(0.5);
    }

    public function testAllowsExecutionsWithHigherThanMinimumRatioToBeGreen()
    {
        $this->listener->endPropertyVerification(99, 100);
    }

    /**
     * @expectedException OutOfBoundsException
     * @expectedExceptionMessage Evaluation ratio 0.2 is under the threshold 0.5
     */
    public function testWarnsOfDangerouslyLowEvaluationRatiosAsVeryFewTestsAreBeingPerformed()
    {
        $this->listener->endPropertyVerification(20, 100);
    }

    public function testIfTheTestIsAlreadyFailingDoesNotCreateNoiseWithItsOwnCheck()
    {
        $this->listener->endPropertyVerification(10, 100, new LogicException("One of the cross beams has gone out askew on the treadle"));
    }
}
