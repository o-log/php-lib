<?php


class AssertTest extends PHPUnit_Framework_TestCase
{
    public function testAssert()
    {
        $this->setExpectedException('Exception', 'Assertion failed');

        \OLOG\Assert::assert(false);
    }
}