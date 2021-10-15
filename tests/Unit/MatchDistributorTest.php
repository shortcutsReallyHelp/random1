<?php


namespace Tests\Unit;


use App\Game\Entities\Division;
use App\Game\Entities\Team;
use App\Game\MatchDistributor;
use PHPUnit\Framework\TestCase;

class MatchDistributorTest extends TestCase
{
    protected MatchDistributor $matchDistributor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->matchDistributor = new MatchDistributor();
    }

    public function testDistributeTeamsAmongstOneDivision()
    {
        $division = new Division(
            'First', [
                new Team('1.1'),
                new Team('1.2'),
                new Team('1.3'),
            ]
        );

        $matches = $this->matchDistributor->distributeTeamsAmongstOneDivision($division);

        $this->assertCount(6, $matches);
    }

    public function testDistributeTeamsAgainstDivisionsInPlayOff()
    {
        $matches = $this->matchDistributor->distributeTeamsAgainstDivisionsInPlayOff(
            [
                (new Team('1.1'))->incrementScore(5),
                (new Team('1.2'))->incrementScore(9),
            ],
            [
                (new Team('2.1'))->incrementScore(3),
                (new Team('2.2'))->incrementScore(6),
            ]
        );

        $this->assertCount(2, $matches);
        $this->assertEquals('1.1', $matches[0]->getLeftTeam()->getName());
        $this->assertEquals('2.2', $matches[0]->getRightTeam()->getName());
        $this->assertEquals('1.2', $matches[1]->getLeftTeam()->getName());
        $this->assertEquals('2.1', $matches[1]->getRightTeam()->getName());
    }

    public function testDistributeTeamsInSemiFinal()
    {
        $matches = $this->matchDistributor->distributeTeamsInSemiFinal(
            [
                (new Team('1.1'))->incrementScore(5),
                (new Team('1.2'))->incrementScore(9),
                (new Team('2.1'))->incrementScore(3),
                (new Team('2.2'))->incrementScore(6),
            ]
        );

        $this->assertCount(2, $matches);
        $this->assertEquals('1.1', $matches[0]->getLeftTeam()->getName());
        $this->assertEquals('2.2', $matches[0]->getRightTeam()->getName());
        $this->assertEquals('1.2', $matches[1]->getLeftTeam()->getName());
        $this->assertEquals('2.1', $matches[1]->getRightTeam()->getName());
    }

}
