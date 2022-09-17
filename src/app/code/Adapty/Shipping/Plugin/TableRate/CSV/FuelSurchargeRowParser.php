<?php

namespace Adapty\Shipping\Plugin\TableRate\CSV;

use Magento\OfflineShipping\Model\ResourceModel\Carrier\Tablerate\CSV\{
    ColumnResolver,
    RowException,
    RowParser as CSVRowParser
};

class FuelSurchargeRowParser
{
    const COLUMN_FUEL_SURCHARGE = 'Fuel Surcharge';

    public function afterGetColumns(CSVRowParser $rowParser, array $columns)
    {
        $columns[] = 'fuel_surcharge';
        return $columns;
    }

    public function aroundParse(
        CSVRowParser $rowParser,
        callable $parse,
        array $rowData,
        $rowNumber,
        $websiteId,
        $conditionShortName,
        $conditionFullName,
        ColumnResolver $columnResolver
    ) {
        $fuelSurcharge = $this->getFuelSurcharge($rowData, $columnResolver, $rowNumber);

        $rates = $parse($rowData, $rowNumber, $websiteId, $conditionShortName, $conditionFullName, $columnResolver);

        foreach ($rates as &$rate) {
            $rate['fuel_surcharge'] = $fuelSurcharge;
        }

        return $rates;
    }

    private function getFuelSurcharge(array $rowData, ColumnResolver $columnResolver, $rowNumber): float
    {
        $fuelSurcharge = $columnResolver->getColumnValue(self::COLUMN_FUEL_SURCHARGE, $rowData);
        // Validate Fuel Surcharge
        if (!is_numeric($fuelSurcharge)) {
            throw new RowException(
                __(
                    'The Table Rates File Format is incorrect in row number "%1". Verify the fuel surcharge is numeric value and try again.',
                    $rowNumber
                )
            );
        }
        return $fuelSurcharge;
    }
}