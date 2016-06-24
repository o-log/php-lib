<?php


class FullObjectIdTest extends PHPUnit_Framework_TestCase
{
    public function testFullObjectId()
    {
        $this->assertEquals('not_object', \OLOG\FullObjectId::getFullObjectId(''));

        $this->assertEquals('stdClass', \OLOG\FullObjectId::getFullObjectId(new stdClass()));
    }
}