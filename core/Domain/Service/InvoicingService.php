<?php
class InvoicingService
{
    protected OrderRepositoryInterface $orderRepository;
    protected InvoiceFactory $invoiceFactory;
    public function __construct(OrderRepositoryInterface $orderRepository,InvoiceFactory $invoiceFactory)
    {
        $this->orderRepository = $orderRepository;
        $this->invoiceFactory = $invoiceFactory;
    }
    public function generateInvoices() : array
    {
        $orders = $this->orderRepository->getUninvoicedOrders();
        $invoices = [];

        foreach ($orders as $order)
        {
            $invoices[] = $this->invoiceFactory->createFromOrder($order);
        }
        return $invoices;
    }
}
