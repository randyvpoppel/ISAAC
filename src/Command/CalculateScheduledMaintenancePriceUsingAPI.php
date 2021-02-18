<?php
declare(strict_types=1);

namespace App\Command;

use App\Service\ScheduledMaintenanceJob;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CalculateScheduledMaintenancePriceUsingAPI extends Command
{
    protected static $defaultName = 'app:calculate-api-price';

    private ScheduledMaintenanceJob $scheduledMaintenanceService;

    public function __construct(ScheduledMaintenanceJob $scheduledMaintenanceService)
    {
        $this->scheduledMaintenanceService = $scheduledMaintenanceService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Which scheduled maintenance order are you looking for?')
            ->setDescription('Calculates scheduled maintenance price using API')
            ->setHelp('This command allows you to calculate the price of scheduled maintenance using an ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        try {
            if (is_numeric($id)) {
                $output->write(
                    '<info>€' .
                    number_format(
                        $this->scheduledMaintenanceService->calculateCost((int) $id, true) / 100,
                        2,
                        ',',
                        '.'
                    ) .
                    '</info>',
                    true
                );
                return Command::SUCCESS;
            }
        } catch (\RuntimeException $e) {
            $output->write(
                '<error>' .
                $e->getMessage() .
                '</error>',
                true
            );
        }

        return Command::FAILURE;
    }
}
