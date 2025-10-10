<?php

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getUninvoicedOrders();
}
