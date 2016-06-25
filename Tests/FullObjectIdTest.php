<?php


class FullObjectIdTest extends PHPUnit_Framework_TestCase
{
    public function testFullObjectId()
    {
        $this->assertEquals('not_object', \OLOG\FullObjectId::getFullObjectId(''));

        $id = rand(1,1000);
        $test_obj = new \Tests\TestObject($id);

        $this->assertEquals(\Tests\TestObject::class . '.' . $id, \OLOG\FullObjectId::getFullObjectId($test_obj));
    }
}