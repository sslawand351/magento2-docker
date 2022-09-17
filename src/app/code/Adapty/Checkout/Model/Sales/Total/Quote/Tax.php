<?php

namespace Adapty\Checkout\Model\Sales\Total\Quote;

use Magento\Tax\Model\Sales\Total\Quote\Tax as TotalQuoteTax;
use Magento\Customer\Api\Data\AddressInterfaceFactory as CustomerAddressFactory;
use Magento\Customer\Api\Data\RegionInterfaceFactory as CustomerAddressRegionFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address;

class Tax extends TotalQuoteTax
{
    // public function __construct(
    //     \Magento\Tax\Model\Config $taxConfig,
    //     \Magento\Tax\Api\TaxCalculationInterface $taxCalculationService,
    //     \Magento\Tax\Api\Data\QuoteDetailsInterfaceFactory $quoteDetailsDataObjectFactory,
    //     \Magento\Tax\Api\Data\QuoteDetailsItemInterfaceFactory $quoteDetailsItemDataObjectFactory,
    //     \Magento\Tax\Api\Data\TaxClassKeyInterfaceFactory $taxClassKeyDataObjectFactory,
    //     CustomerAddressFactory $customerAddressFactory,
    //     CustomerAddressRegionFactory $customerAddressRegionFactory,
    //     \Magento\Tax\Helper\Data $taxData,
    //      \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
    //     Json $serializer = null
    // ) {

    //     $this->setCode('tax');
    //     $this->_taxData = $taxData;
    //     $this->scopeConfig = $scopeConfig;
    //     $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
    //     parent::__construct(
    //         $taxConfig,
    //         $taxCalculationService,
    //         $quoteDetailsDataObjectFactory,
    //         $quoteDetailsItemDataObjectFactory,
    //         $taxClassKeyDataObjectFactory,
    //         $customerAddressFactory,
    //         $customerAddressRegionFactory,
    //         $taxData
    //     );
    // }

    /**
    * Custom Collect tax totals for quote address
    *
    * @param Quote $quote
    * @param ShippingAssignmentInterface $shippingAssignment
    * @param Address\Total $total
    * @return $this
    */
    public function collect( \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total) {

        return $this;
    }

}