<?php

namespace App\DataFixtures;

use App\Service\Currency\CurrencyLoaders\CurrencyLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Currency extends Fixture
{
	private CurrencyLoader $currency;

	public function __construct(CurrencyLoader $currency) {
		$this->currency = $currency;
	}

	public function load(ObjectManager $manager): void
    {

	    $this->currency->load();
	    $this->currency->saveToDB();

        $manager->flush();
    }
}
