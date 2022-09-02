<?php

namespace Adapty\Customer\Setup\Patch\Data;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class AddIsVIPCustomerAttribute implements DataPatchInterface
{
    private $moduleDataSetup;
    private $customerSetup;
    private $attributeResource;
    private $logger;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeResource $attributeResource,
        LoggerInterface $logger
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetup = $customerSetupFactory->create(['setup' => $moduleDataSetup]);
        $this->attributeResource = $attributeResource;
        $this->logger = $logger;
    }

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        try {
            $this->customerSetup->addAttribute(
                CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, // entity type code
                'is_vip_customer', // unique attribute code
                [
                    'label' => 'Is VIP Customer?',
                    'input' => 'boolean',
                    'required' => 0,
                    'position' => 200,
                    'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                    'default' => '0',
                    'system' => 0,
                    'user_defined' => 1,
                    'is_used_in_grid' => 1,
                    'is_visible_in_grid' => 1,
                    'is_filterable_in_grid' => 1,
                    'is_searchable_in_grid' => 1,
                ]
            );

            $this->customerSetup->addAttributeToSet(
                CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, // entity type code
                CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER, // attribute set ID
                null, // attribute group ID
                'is_vip_customer' // unique attribute code
            );

            // Get the newly created attribute's model
            $attribute = $this->customerSetup->getEavConfig()
                ->getAttribute(CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER, 'is_vip_customer');

            // Make attribute visible in Admin customer form
            $attribute->setData('used_in_forms', ['adminhtml_customer']);

            // Save modified attribute model using its resource model
            $this->attributeResource->save($attribute);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
