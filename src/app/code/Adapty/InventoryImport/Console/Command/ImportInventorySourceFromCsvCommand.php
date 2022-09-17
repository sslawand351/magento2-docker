<?php

namespace Adapty\InventoryImport\Console\Command;

use Adapty\InventoryImport\Service\Product\ImportInventorySourceFromCsv;
use Magento\Framework\Filesystem\DirectoryList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportInventorySourceFromCsvCommand extends Command
{
    const CSV_FILE = "csv";

    private $importInventorySourceFromCsv;
    private $dir;

    public function __construct(
        ImportInventorySourceFromCsv $importInventorySourceFromCsv,
        DirectoryList $dir
    )
    {
        parent::__construct();
        $this->importInventorySourceFromCsv = $importInventorySourceFromCsv;
        $this->dir = $dir;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("adapty:inventory-source:import");
        $this->setDescription("Import Inventory Source from csv file");
        $this->setDefinition([
            new InputArgument(self::CSV_FILE, InputArgument::OPTIONAL, "Inventory source Csv file path")
        ]);
        parent::configure();
    }
     
    /**
     * {@inheritdoc}
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $name = $input->getArgument(self::CSV_FILE);
        $output->writeln("Importing Inventory SOurce FROm CSV " . $name);
        $csv = $this->getCSVPath($name); 

        if (!file_exists($csv)) {
            $output->writeln("CSV does not exist.");
            return;
        }
        ($this->importInventorySourceFromCsv)($csv);
        $output->writeln("Completed Inventory SOurce FROm CSV ");
    }

    private function getCSVPath(string $name)
    {
        return $this->dir->getPath('var') . '/csv/' . $name;
    }
}
