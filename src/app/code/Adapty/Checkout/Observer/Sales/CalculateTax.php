<?php

namespace Adapty\Checkout\Observer\Sales;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Psr\Log\LoggerInterface;

class CalculateTax implements ObserverInterface
{
    private $logger;
    const TAX = 30.0;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        /** @var Total $total */
        $total = $observer->getEvent()->getTotal();
        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $this->logger->info("Totals", [$total->toArray()]);

        foreach ($quote->getAllItems() as $item) {
            $this->logger->info("Quote Item", [$item->getData()]);
        }
        // foreach ($quote->getAllAddresses() as $address) {

        //     $this->logger->info("Quote Address", [$address->getData()]);
        // }

        // TODO: move this to seaparate observer
        $quote->setFuelSurchargeAmount($total->getFuelSurchargeAmount());
        $quote->setBaseFuelSurchargeAmount($total->getBaseFuelSurchargeAmount());

        $total->addTotalAmount('tax', self::TAX);
        // $total->addBaseTotalAmount('tax', self::TAX);
        $total->setGrandTotal($total->getGrandTotal() + self::TAX);

        $this->logger->info("Applied Taxes", [$total->getAppliedTaxes()]);
        $this->logger->info("Set Base Tax Amount", [$total->toArray()]);
        $this->logger->info("Quote get Totals", [$quote->getTotals()['tax']->toArray()]);
        return $this;
    }
}
