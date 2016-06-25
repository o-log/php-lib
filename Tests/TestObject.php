<?php


namespace Tests;


class TestObject implements TestInterface
{
    protected $id;

    public function __construct($id = 0)
    {
        $this->id = $id;
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
}