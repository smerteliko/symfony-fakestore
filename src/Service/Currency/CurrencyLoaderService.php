<?php
/**
 * User: smerteliko
 * Date: 29.05.2024
 * Time: 21:57
 */

namespace App\Service\Currency;

abstract class CurrencyLoaderService implements CurrencyLoaderServiceInterface {

	public string $url = 'https://www.cbr.ru/scripts/';

	abstract public function load(): void;

	abstract public function saveToDB(): void;

	abstract public function setUrl(string $url): void;

	abstract public function getUrl(): string;
}