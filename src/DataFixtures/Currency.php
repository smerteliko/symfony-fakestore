<?php

namespace App\DataFixtures;

use App\Service\Currency\CurrencyLoaders\CurrencyRCBLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Currency extends Fixture
{
	private CurrencyRCBLoader $currency;

	public function __construct(CurrencyRCBLoader $currency) {
		$this->currency = $currency;
	}

	public function load(ObjectManager $manager): void
    {

	    $this->currency->load();
	    $this->currency->saveToDB();

        $manager->flush();
    }
}
