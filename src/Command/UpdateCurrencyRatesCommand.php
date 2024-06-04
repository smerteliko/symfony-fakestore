<?php

namespace App\Command;

use App\Service\Currency\CurrencyLoaders\CurrencyRatesLoader;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

#[AsCommand(
    name: 'app:update-currency-rates',
    description: 'Update currency rates',
)]
class UpdateCurrencyRatesCommand extends Command
{
    public function __construct(private readonly CurrencyRatesLoader $ratesLoader,
                                private readonly TagAwareCacheInterface $cache)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

	/**
	 * @throws InvalidArgumentException
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

	    $this->cache->invalidateTags(['Currencies']);
		$this->ratesLoader->load();
		$this->ratesLoader->updateRates();


		$io->success('rates loaded and invalidated cache tags');


        return Command::SUCCESS;
    }
}
