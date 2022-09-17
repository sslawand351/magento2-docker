<?php

namespace Adapty\Shipping\Observer\Sales\Quote;

use Exception;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class UpdateFuelSurchargeInQuote implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this;
     * @throws Exception
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        // Get Order Object
        /* @var $order \Magento\Sales\Model\Order */
        $order = $event->getOrder();
        // Get Quote Object
        /** @var $quote \Magento\Quote\Model\Quote $quote */
        $quote = $event->getQuote();

        if ($quote->getFuelSurchargeAmount()) {
            $order->setFuelSurchargeAmount($quote->getFuelSurchargeAmount());
        }

        if ($quote->getBaseFuelSurchargeAmount()) {
            $order->setBaseFuelSurchargeAmount($quote->getBaseFuelSurchargeAmount());
        }
        return $this;
    }
}
