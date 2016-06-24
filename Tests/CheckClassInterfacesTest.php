<?php


class CheckClassInterfacesTest extends PHPUnit_Framework_TestCase
{
    public function testExceptionIfClassNotImplementsInterface()
    {
        $this->setExpectedException('Exception');

        \OLOG\CheckClassInterfaces::exceptionIfClassNotImplementsInterface('stdClass', '');
    }
}