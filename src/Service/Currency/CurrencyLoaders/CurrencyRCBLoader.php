<?php
/**
 * User: smerteliko
 * Date: 30.05.2024
 * Time: 09:24
 */

declare(strict_types=1);

namespace App\Service\Currency\CurrencyLoaders;

use App\Repository\CurrencyRepository;
use App\Service\Currency\CurrencyLoaderService;
use Psr\Log\LoggerInterface;

/**
 * Currency list loader from Russian Central Bank
 *
 * @class CurrencyRCBLoader
 */
final class CurrencyRCBLoader extends CurrencyLoaderService {

	private CurrencyRepository $currencyRepository;
	private LoggerInterface    $logger;

	public string              $url = 'https://www.cbr.ru/scripts/';
	private string             $urlParams = 'XML_valFull.asp';

	private array              $localCurrenciesArr = [];


	public function __construct(CurrencyRepository $currencyRepository,
	                            LoggerInterface $logger) {
		$this->currencyRepository = $currencyRepository;
		$this->logger = $logger;
	}

	/**
	 * @throws \Exception
	 */
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
			$this->logger->critical('Currency Loader Service '. __CLASS__ , [
				'Message' => $e->getMessage(),
				'Trace ' => $e->getTrace(),
			]);
			throw $e;
		}
	}

	private function setCurrencies($currency): void {
		if((int)$currency->ISO_Num_Code) {
			$this->localCurrenciesArr[(int)$currency->ISO_Num_Code] = [
				'Name' => (string)$currency->EngName,
				'ISOCode' => str_pad((string)$currency->ISO_Num_Code, 3, '0', STR_PAD_LEFT),
				'ISOCharCode'=> (string)$currency->ISO_Char_Code
			];
		}
	}

	public function save(): void {
		if(count($this->localCurrenciesArr)) {
			foreach ($this->localCurrenciesArr as $currency) {
				$this->currencyRepository->setCurrencyEntity($currency);
			}
		}
	}


	public function setUrl(string $url): void {
		$this->url = $url;
	}

	public function getUrl(): string {
		return $this->url.$this->urlParams;
	}
}