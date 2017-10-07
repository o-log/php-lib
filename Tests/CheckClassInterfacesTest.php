<?php


class CheckClassInterfacesTest extends PHPUnit_Framework_TestCase
{
    public function testExceptionIfClassNotImplementsInterface()
    {
        \OLOG\ClassName::exceptionIfNot(\Tests\TestObject::class, \Tests\TestInterface::class);

        $this->expectException('Exception');
        $this->expectExceptionMessage('does not implement interface');

        \OLOG\ClassName::exceptionIfNot(stdClass::class, '');
    }

    public function testClassImplementsInterface()
    {
        $this->assertTrue(
            \OLOG\ClassName::is(\Tests\TestObject::class, \Tests\TestInterface::class)
        );

        $this->assertFalse(
            \OLOG\ClassName::is(\Tests\TestObject::class, \Tests\TestInterface2::class)
        );
    }
}