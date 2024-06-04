<?php
/**
 * User: smerteliko
 * Date: 29.05.2024
 * Time: 19:21
 */

namespace App\Service\Currency\CurrencyLoaders;


use App\Repository\CurRatesRepository;
use App\Service\Currency\CurrencyLoaderService;

class CurrencyRatesLoader extends CurrencyLoaderService {

    private CurRatesRepository $currencyRatesRepository;
    private string             $urlParams = 'XML_daily_eng.asp?date_req=';

    private array $localCurrencyRatesArr =[];

    public function __construct(CurRatesRepository $currencyRatesRepository) {
        $this->currencyRatesRepository = $currencyRatesRepository;
    }
    /**
     * @return void
     */
    public function load(): void {
        try {
            $page = file_get_contents($this->getUrl());
            if($page) {
                $xml = simplexml_load_string($page);
                $aRates = [];

                if(count($xml)) {
                    foreach ($xml as $oneCurRate) {
                        $this->setCurrencyRates($oneCurRate);
                    }
                }
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
    }

    private function setCurrencyRates($oneCurRate): void {
        if ((int)$oneCurRate->NumCode) {
            $this->localCurrencyRatesArr[(int)$oneCurRate->NumCode] = [
                'NumCode'     =>            str_pad($oneCurRate->NumCode,3,'0',STR_PAD_LEFT),
                'CharCode'    => (string)   $oneCurRate->CharCode,
                'Nominal'     => (float)    $oneCurRate->Nominal,
                'Value'       => (float)    str_replace(',', '.', (string)$oneCurRate->Value),
                'UnitRate'    => (float)    str_replace(',', '.', (string)$oneCurRate->VunitRate),
            ];
        }
    }

    public function saveToDB(): void {
        if (count($this->localCurrencyRatesArr)) {
            foreach ($this->localCurrencyRatesArr as $currency) {
                $this->currencyRatesRepository->setCurrencyRateEntity($currency);
            }
        }
    }
    
    public function updateRates(): void {
        if (count($this->localCurrencyRatesArr)) {
            foreach ($this->localCurrencyRatesArr as $currencyRate) {
                $this->currencyRatesRepository->updateCurrencyRate($currencyRate);
            }
        }
    }


    public function setUrl(string $url): void {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string {
        return $this->url.$this->urlParams.date('d.m.Y');
    }
}