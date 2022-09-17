<?php

namespace Adapty\Shipping\Model\Sales\Shipping\TableRate;

use Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate\CollectionFactory as TableRateCollectionFactory;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

class FuelSurcharge extends AbstractTotal
{
    private $tableRateCollectionFactory;
    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null; 

    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        TableRateCollectionFactory $tableRateCollectionFactory
    ) {
        $this->quoteValidator = $quoteValidator;
        $this->tableRateCollectionFactory = $tableRateCollectionFactory;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        
        // dd($this->getFuelSurcharge($quote));
        // $exist_amount = 0; //$quote->getCustomfee(); 
        // $customfee = $this->getFuelSurcharge($quote); //enter amount which you want to set
        $balance = $this->getFuelSurcharge($quote); // $customfee - $exist_amount;//final amount

        $total->setTotalAmount('fuel_surcharge', $balance);
        $total->setBaseTotalAmount('fuel_surcharge', $balance);

        // $total->setFuelSurcharge($balance);
        // $total->setBaseFuelSurcharge($balance);

        $total->setGrandTotal($total->getGrandTotal() + $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);

        return $this;
    }

    protected function clearValues(Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code' => 'fuel_surcharge',
            'title' => 'Fuel Surcharge',
            'value' => $this->getFuelSurcharge($quote)
        ];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Fuel Surcharge');
    }

    private function getFuelSurcharge(Quote $quote): float
    {
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();
        if ($shippingMethod !== 'tablerate_bestway') {
            return 0;
        }
        $postCode = $quote->getShippingAddress()->getPostcode();
        if (!$postCode) {
            return 0;
        }

        $tableRate = $this->getTableRate($postCode);
        // dd($tableRate);
        return $tableRate->getFuelSurcharge();
    }

    private function getTableRate(string $postCode)
    {
        /** @var \Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate\Collection $collection */
        $collection = $this->tableRateCollectionFactory->create();
        $tableRates = $collection->addFieldToFilter('dest_zip', [['eq' => $postCode], ['eq' => '*']])->load();
        // echo $collection->getSelect();
        return $tableRates->count() ? $tableRates->getLastItem() : null;
    }
}
