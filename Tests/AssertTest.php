<?php


class AssertTest extends PHPUnit_Framework_TestCase
{
    public function testAssert()
    {
        \OLOG\Assert::assert(true);

        $this->expectException('Exception');
        $this->expectExceptionMessage('Assertion failed');

        \OLOG\Assert::assert(false);
    }
}