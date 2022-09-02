<?php

namespace Adapty\Checkout\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;

class CalculateTax implements ObserverInterface
{
    private $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $total = $observer->getEvent()->getTotal();
        $quote = $observer->getEvent()->getQuote();
        // $total->setBaseTaxAmount(30);
        $this->logger->info("Set Base Tax Amount", ['total address']);
        foreach ($quote->getAllAddresses() as $address) {
            // base totals
            $address->setBaseTaxAmount(30.0);
            // normal totals
            $address->setTaxAmount(30.0);
        }
        // base totals
        $total->setBaseTaxAmount(30.0);
        // normal totals
        $total->setTaxAmount(30.0);
        // $total->setBaseSubTotalInclTax(30.0);
        $this->logger->info("Set Base Tax Amount", [$total->toArray()]);
        $total->addTotalAmount('tax', 30.0);
        
        // dd($total);
    }
}
