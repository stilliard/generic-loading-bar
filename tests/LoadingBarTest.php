<?php

use PHPUnit\Framework\TestCase;

use GLB\LoadingBar;

class LoadingBarTest extends TestCase
{
    public function testBasicUsage(): void
    {
        $loading = new LoadingBar;
        $this->assertEquals(0, $loading->get());

        $loading->set(50);
        $this->assertEquals(50, $loading->get());

        $loading->step();
        $this->assertEquals(51, $loading->get());

        $loading->complete();
        $this->assertEquals(100, $loading->get());

        $loading->reset();
        $this->assertEquals(0, $loading->get());
        $this->assertEquals(false, $loading->isComplete());
        $this->assertEquals(false, $loading->isRunning());
        $this->assertEquals(true, $loading->isReset());

        $loading->set(25);
        $this->assertEquals(25, $loading->get());
        $this->assertEquals('25%', $loading->display());
        $this->assertEquals(false, $loading->isComplete());
        $this->assertEquals(true, $loading->isRunning());
        $this->assertEquals(false, $loading->isReset());

        $loading->set(125);
        $this->assertEquals(100, $loading->get());
        $this->assertEquals('100%', $loading->display());
        $this->assertEquals(true, $loading->isComplete());
        $this->assertEquals(false, $loading->isRunning());
        $this->assertEquals(false, $loading->isReset());

        $loading->set(-25);
        $this->assertEquals(0, $loading->get());
        $this->assertEquals('0%', $loading->display());

        $loading->step();
        $this->assertEquals(1, $loading->get());

        $loading->step();
        $this->assertEquals(2, $loading->get());
        $this->assertEquals('2%', $loading->display());
    }

    public function testCustomOptions(): void
    {
        $loading = new LoadingBar([
            'min' => 10,
            'max' => 40,
            'steps' => 30,
        ]);
        $this->assertEquals(10, $loading->get());

        $loading->set(25);
        $this->assertEquals(25, $loading->get());
        $this->assertEquals('50%', $loading->display());

        $loading->step();
        $this->assertEquals(26, $loading->get());

        $loading->complete();
        $this->assertEquals(40, $loading->get());

        $loading->reset();
        $this->assertEquals(10, $loading->get());

        $loading->set(5);
        $this->assertEquals(10, $loading->get());
        $this->assertEquals('0%', $loading->display());

        $loading->set(50);
        $this->assertEquals(40, $loading->get());
        $this->assertEquals('100%', $loading->display());

        $loading->set(0);
        $this->assertEquals(10, $loading->get());
        $this->assertEquals('0%', $loading->display());

        $loading->step();
        $this->assertEquals(11, $loading->get());
        $this->assertEquals('3%', $loading->display());

        $loading->step();
        $this->assertEquals(12, $loading->get());
        $this->assertEquals('7%', $loading->display());
    }

    public function testCalcRanged()
    {
        $loading = new LoadingBar;

        $loading->calc([0, 100], [0, 100]);
        $this->assertEquals(0, $loading->get());

        $loading->calc([0, 100], [1, 100]);
        $this->assertEquals(1, $loading->get());

        $loading->calc([0, 100], [2, 100]);
        $this->assertEquals(2, $loading->get());

        $loading->calc([0, 100], [3, 100]);
        $this->assertEquals(3, $loading->get());

        $loading->calc([0, 100], [50, 100]);
        $this->assertEquals(50, $loading->get());

        $loading->calc([0, 100], [49, 100]);
        $this->assertEquals(49, $loading->get());

        $loading->calc([0, 100], [99, 100]);
        $this->assertEquals(99, $loading->get());

        $loading->calc([0, 100], [100, 100]);
        $this->assertEquals(100, $loading->get());

        // smaller range

        $loading->calc([0, 20], [0, 100]);
        $this->assertEquals('0%', $loading->display());

        $loading->calc([0, 20], [1, 100]);
        $this->assertEquals('0%', $loading->display());

        $loading->calc([0, 20], [2, 100]);
        $this->assertEquals('0%', $loading->display());

        $loading->calc([0, 20], [3, 100]);
        $this->assertEquals('1%', $loading->display());

        $loading->calc([0, 20], [4, 100]);
        $this->assertEquals('1%', $loading->display());

        $loading->calc([0, 20], [5, 100]);
        $this->assertEquals('1%', $loading->display());

        $loading->calc([0, 20], [50, 100]);
        $this->assertEquals('10%', $loading->display());

        $loading->calc([0, 20], [75, 100]);
        $this->assertEquals('15%', $loading->display());

        $loading->calc([0, 20], [100, 100]);
        $this->assertEquals('20%', $loading->display());

        $loading->calc([20, 40], [0, 100]);
        $this->assertEquals('20%', $loading->display());

        $loading->calc([20, 40], [1, 100]);
        $this->assertEquals('20%', $loading->display());

        $loading->calc([20, 40], [2, 100]);
        $this->assertEquals('20%', $loading->display());

        $loading->calc([20, 40], [3, 100]);
        $this->assertEquals('21%', $loading->display());

        $loading->calc([20, 40], [4, 100]);
        $this->assertEquals('21%', $loading->display());

        $loading->calc([20, 40], [5, 100]);
        $this->assertEquals('21%', $loading->display());

        $loading->calc([20, 40], [50, 100]);
        $this->assertEquals('30%', $loading->display());

        $loading->calc([20, 40], [75, 100]);
        $this->assertEquals('35%', $loading->display());

        $loading->calc([20, 40], [100, 100]);
        $this->assertEquals('40%', $loading->display());

        // smaller current range

        $loading->calc([0, 100], [0, 20]);
        $this->assertEquals('0%', $loading->display());

        $loading->calc([0, 100], [5, 20]);
        $this->assertEquals('25%', $loading->display());

        $loading->calc([0, 100], [10, 20]);
        $this->assertEquals('50%', $loading->display());

        $loading->calc([0, 100], [15, 20]);
        $this->assertEquals('75%', $loading->display());

        $loading->calc([0, 100], [20, 20]);
        $this->assertEquals('100%', $loading->display());
    }
}