<?php

class Order extends AbstractEntity
{
    protected Customer $customer;
    protected string $orderNumber;
    protected string $description;
    protected int $total;

    public function getCustomer():Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer):self
    {
        $this->customer = $customer;
        return $this;
    }

    public function getOrderNumber():string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber):self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

    public function getDescription() : string {
        return $this->description;
    }
    public function setDescription($description):self
    {
        $this->description = $description;
        return $this;
    }

    public function getTotal():int
    {
        return $this->total;
    }
    public function setTotal($total) : self
    {
        $this->total = $total;
        return $this;
    }

}
