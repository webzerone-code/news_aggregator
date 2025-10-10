<?php


class InvoiceFactory
{
    public function createFromOrder(Order $order) : Invoice
    {
        $invoice = new Invoice();
        $invoice->setOrder($order);
        $invoice->setInvoiceDate(new \DateTime());
        $invoice->setTotal($order->getTotal());
        return $invoice;
    }
}
