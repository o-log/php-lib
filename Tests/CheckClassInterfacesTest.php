<?php


class CheckClassInterfacesTest extends PHPUnit_Framework_TestCase
{
    public function testExceptionIfClassNotImplementsInterface()
    {
        $this->setExpectedException('Exception', 'does not implement interface');

        \OLOG\CheckClassInterfaces::exceptionIfClassNotImplementsInterface('stdClass', '');
    }
}