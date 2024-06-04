<?php
/**
 * User: smerteliko
 * Date: 30.05.2024
 * Time: 09:24
 */

namespace App\Service\Currency\CurrencyLoaders;

use App\Repository\CurrencyRepository;
use App\Service\Currency\CurrencyLoaderService;

class CurrencyLoader extends CurrencyLoaderService {

	private CurrencyRepository $currencyRepository;
	private string             $urlParams = 'XML_valFull.asp';

	private array $localCurrenciesArr = [];


	public function __construct(CurrencyRepository $currencyRepository) {
		$this->currencyRepository = $currencyRepository;
	}

	public function load(): void {
		try {
			$page = file_get_contents($this->getUrl());
			if($page) {
				$xml = simplexml_load_string($page);

				if(count($xml)) {
					foreach ($xml as $oneCurrency) {
						$this->setCurrencies($oneCurrency);
					}
				}

			}
		} catch (\Exception $e) {
			$error = $e->getMessage();
		}
	}

	private function setCurrencies($currency): void {
		if((int)$currency->ISO_Num_Code) {
			$this->localCurrenciesArr[(int)$currency->ISO_Num_Code] = [
				'Name' => (string)$currency->EngName,
				'ISOCode' => str_pad($currency->ISO_Num_Code, 3, '0', STR_PAD_LEFT),
				'ISOCharCode'=> (string)$currency->ISO_Char_Code
			];
		}
	}


	public function getUrl(): string {
		return $this->url.$this->urlParams;
	}

	public function saveToDB(): void {
		if(count($this->localCurrenciesArr)) {
			foreach ($this->localCurrenciesArr as $currency) {
				$this->currencyRepository->setCurrencyEntity($currency);
			}
		}

	}


	public function setUrl(string $url): void {
		$this->url = $url;
	}
}