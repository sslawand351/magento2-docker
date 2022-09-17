<?php

namespace Adapty\InventoryImport\Service\Product;

use Magento\InventoryAdminUi\Model\Source\SourceHydrator;
use Magento\InventoryApi\Api\Data\SourceInterfaceFactory;
use Magento\InventoryApi\Api\SourceRepositoryInterface;
use Psr\Log\LoggerInterface;

class ImportInventorySourceFromCsv
{
    private $sourceRepository;
    private $sourceInterfaceFactory;
    private $inventorySourceHydrator;
    private $logger;

    public function __construct(
        SourceRepositoryInterface $sourceRepository,
        SourceInterfaceFactory $sourceInterfaceFactory,
        SourceHydrator $inventorySourceHydrator,
        LoggerInterface $logger
    )
    {
        $this->sourceRepository = $sourceRepository;
        $this->sourceInterfaceFactory = $sourceInterfaceFactory;
        $this->inventorySourceHydrator = $inventorySourceHydrator;
        $this->logger = $logger;
    }

    public function __invoke(string $csv)
    {
        $this->logger->info('Started Inventory Source Import', ['csv' => $csv]);
        $this->importInventorySources($csv);
        $this->logger->info('Completed Inventory Source Import');
    }

    private function importInventorySources($file)
    {
        foreach ($this->mapCsvRowsToInventorySource($file) as $inventorySource) {
            $response = $this->saveInventorySource($inventorySource);
        }
    }

    private function saveInventorySource(array $source)
    {
        $this->logger->info('Inventory Source Data', ['source' => $source]);
        $sourceCode = $source['source_code'];
        try {
            $inventorySource = $this->sourceRepository->get($sourceCode);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->logger->info('The Source does not exist.', ['source_code' => $sourceCode]);
            $inventorySource = null;
        }

        try {
            $newSource['general'] = $source;
            if (!$inventorySource) {
                $inventorySource = $this->sourceInterfaceFactory->create();
            }
            $inventorySource = $this->inventorySourceHydrator->hydrate($inventorySource, $newSource);

            // insert or update inventory source
            $this->sourceRepository->save($inventorySource);
            $this->logger->info('The Source has been saved.', ['source_code' => $sourceCode]);
            return [
                'status' => 'success',
                'source_code' => $sourceCode
            ];
        } catch (\Magento\Framework\Validation\ValidationException $e) {
            foreach ($e->getErrors() as $localizedError) {
                $this->logger->error($localizedError->getMessage());
            }
        } catch (\Magento\Framework\Exception\CouldNotSaveException $e) {
            $this->logger->error($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->error('Could not save Source.', ['error_message' => $e->getMessage()]);
        }
        return [
            'status' => 'failure',
            'source_code' => $sourceCode
        ];
    }

    private function validateInventorySource()
    {

    }

    private function mapCsvRowsToInventorySource($file)
    {
        foreach ($this->iterCsv($file) as $row) {
            yield [
                'source_code' => $row[0],
                'name' => $row[1],
                'email' => $row[2],
                'contact_name' => $row[3],
                'enabled' => $row[4],
                'description' => $row[5],
                'latitude' => $row[6],
                'longitude' => $row[7],
                'country_id' => $row[8],
                'region_id' => $row[9],
                'city' => $row[10],
                'postcode' => $row[11],
                'use_default_carrier_config' => $row[12],
                'carrier_codes' => $row[13],
                'disable_source_code' => $row[14],
                'phone' => $row[15],
                'fax' => $row[16],
                'region' => $row[17],
                'street' => $row[18],
            ];
        }
    }

    private function iterCsv($file, string $delimiter = ',')
    {
        $i = 0;
        $fp = fopen($file, "r");
        while ($row = fgetcsv($fp, 0, $delimiter)) {
            // skip header row
            if ($i == 0) {
                $i++;
                continue;
            }
            yield $row;
        }
        fclose($fp);
    }
}
