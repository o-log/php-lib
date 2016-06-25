<?php


class ConfWrapperTest extends PHPUnit_Framework_TestCase
{
    const TEST_FIRST_LEVEL_STRING_KEY = 'first_level_string';
    const TEST_SECOND_LEVEL_STRING_KEY = 'second_level_string';
    const TEST_NOT_EXISTING_KEY = 'not_existing_key';
    const TEST_FIRST_LEVEL_ARR_KEY = 'first_level_arr';
    const TEST_VALUE = 'string';
    const TEST_DEFAULT_VALUE = 'default_value';

    const TEST_CONFIG_ARR = array(
        self::TEST_FIRST_LEVEL_STRING_KEY => self::TEST_VALUE,
        self::TEST_FIRST_LEVEL_ARR_KEY => array(
            self::TEST_SECOND_LEVEL_STRING_KEY => self::TEST_VALUE
        )
    );

    public function testGetRequiredValue()
    {
        \OLOG\ConfWrapper::assignConfig(self::TEST_CONFIG_ARR);

        $this->assertEquals(self::TEST_VALUE, \OLOG\ConfWrapper::getRequiredValue(self::TEST_FIRST_LEVEL_STRING_KEY));

        $this->expectException('Exception');
        $this->expectExceptionMessage('missing config key');

        \OLOG\ConfWrapper::getRequiredValue(self::TEST_NOT_EXISTING_KEY);
    }

    public function testGetRequiredSubValue()
    {
        $this->assertEquals(self::TEST_VALUE, \OLOG\ConfWrapper::getRequiredSubvalue(self::TEST_CONFIG_ARR, self::TEST_FIRST_LEVEL_ARR_KEY . '.' . self::TEST_SECOND_LEVEL_STRING_KEY));

        $this->expectException('Exception');
        $this->expectExceptionMessage('missing config key');

        \OLOG\ConfWrapper::getRequiredSubvalue(self::TEST_CONFIG_ARR, self::TEST_FIRST_LEVEL_ARR_KEY . '.' . self::TEST_NOT_EXISTING_KEY);
    }

    public function testGetOptionalValue()
    {
        \OLOG\ConfWrapper::assignConfig(self::TEST_CONFIG_ARR);

        $this->assertEquals(self::TEST_VALUE, \OLOG\ConfWrapper::getOptionalValue(self::TEST_FIRST_LEVEL_STRING_KEY));

        $this->assertEquals(self::TEST_DEFAULT_VALUE, \OLOG\ConfWrapper::getOptionalValue(self::TEST_FIRST_LEVEL_ARR_KEY . '.' . self::TEST_NOT_EXISTING_KEY, self::TEST_DEFAULT_VALUE));
    }

    public function testGetOptionalSubvalue()
    {
        $this->assertEquals(self::TEST_DEFAULT_VALUE, \OLOG\ConfWrapper::getOptionalSubvalue(self::TEST_CONFIG_ARR, self::TEST_FIRST_LEVEL_ARR_KEY . '.' . self::TEST_NOT_EXISTING_KEY, self::TEST_DEFAULT_VALUE));

        $this->assertEquals(self::TEST_VALUE, \OLOG\ConfWrapper::getOptionalSubvalue(self::TEST_CONFIG_ARR, self::TEST_FIRST_LEVEL_ARR_KEY . '.' . self::TEST_SECOND_LEVEL_STRING_KEY));
    }
}