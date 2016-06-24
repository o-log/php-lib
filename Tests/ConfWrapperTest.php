<?php


class ConfWrapperTest extends PHPUnit_Framework_TestCase
{
    const TEST_CONFIG_ARR = array(
        'first_level_string' => 'string',
        'first_level_arr' => array(
            'second_level_string' => 'string'
        )
    );

    public function testGetRequiredValue()
    {
        \OLOG\ConfWrapper::assignConfig(self::TEST_CONFIG_ARR);

        $this->assertEquals('string', \OLOG\ConfWrapper::getRequiredValue('first_level_string'));

        $this->setExpectedException('Exception', 'missing config key');

        \OLOG\ConfWrapper::getRequiredValue('not_existing_key');
    }

    public function testGetRequiredSubValue()
    {
        $this->assertEquals('string', \OLOG\ConfWrapper::getRequiredSubvalue(self::TEST_CONFIG_ARR, 'first_level_arr.second_level_string'));

        $this->setExpectedException('Exception', 'missing config key');

        \OLOG\ConfWrapper::getRequiredSubvalue(self::TEST_CONFIG_ARR, 'first_level_arr.not_existing_key');
    }

    public function testGetOptionalValue()
    {
        \OLOG\ConfWrapper::assignConfig(self::TEST_CONFIG_ARR);

        $this->assertEquals('string', \OLOG\ConfWrapper::getOptionalValue('first_level_string'));

        $this->assertEquals('default_value', \OLOG\ConfWrapper::getOptionalValue('first_level_arr.not_existing_key', 'default_value'));
    }

    public function testGetOptionalSubvalue()
    {
        $this->assertEquals('default_value', \OLOG\ConfWrapper::getOptionalSubvalue(self::TEST_CONFIG_ARR, 'first_level_arr.not_existing_key', 'default_value'));

        $this->assertEquals('string', \OLOG\ConfWrapper::getOptionalSubvalue(self::TEST_CONFIG_ARR, 'first_level_arr.second_level_string'));
    }
}