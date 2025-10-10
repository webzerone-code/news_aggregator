<?php

namespace App\__OOThroughProcess\Chapter02\DatabaseReader;

class DatabaseReader
{
    private string $dbName;
    private int $startPosition;
    public function __construct(string $dbName)
    {
        $this->dbName = $dbName;
        $this->startPosition = 0;
    }
    public function open(string $name):void
    {

    }
    public function close():void
    {

    }
    public function goToFirst():void
    {

    }
    public function goToLast():void
    {

    }
    public function howManyRecords():int
    {
        return 0;
    }
    public function areThereMoreRecords():bool
    {
        return false;
    }
    public function positionRecords():void
    {

    }
    public function getRecords():string
    {
        return '';
    }
    public function getNextRecord():string
    {
        return '';
    }
}
