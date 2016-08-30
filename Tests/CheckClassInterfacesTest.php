<?php


class CheckClassInterfacesTest extends PHPUnit_Framework_TestCase
{
    public function testExceptionIfClassNotImplementsInterface()
    {
        \OLOG\CheckClassInterfaces::exceptionIfClassNotImplementsInterface(\Tests\TestObject::class, \Tests\TestInterface::class);

        $this->expectException('Exception');
        $this->expectExceptionMessage('does not implement interface');

        \OLOG\CheckClassInterfaces::exceptionIfClassNotImplementsInterface(stdClass::class, '');
    }

    public function testClassImplementsInterface()
    {
        $this->assertTrue(
            \OLOG\CheckClassInterfaces::classImplementsInterface(\Tests\TestObject::class, \Tests\TestInterface::class)
        );

        $this->assertFalse(
            \OLOG\CheckClassInterfaces::classImplementsInterface(\Tests\TestObject::class, \Tests\TestInterface2::class)
        );
    }
}