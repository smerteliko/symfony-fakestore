<?php

namespace App\Command;

use App\Repository\CurRatesRepository;
use App\Service\Currency\CurrencyLoaders\CurrencyRCBRatesLoader;
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
final class UpdateCurrencyRatesCommand extends Command
{
    public function __construct(private readonly CurrencyRCBRatesLoader $ratesLoader,
                                private readonly TagAwareCacheInterface $cache,
                                private readonly CurRatesRepository $currencyRatesRepository,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

	/**
	 * @throws InvalidArgumentException
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

	    $this->cache->invalidateTags(['Currencies']);
		$this->ratesLoader->load();
		if(count($this->currencyRatesRepository->findAll())>0) {
			$this->ratesLoader->updateRates();
		} else {
			$this->ratesLoader->save();
		}



		$io->success('rates loaded and invalidated cache tags');


        return Command::SUCCESS;
    }
}
