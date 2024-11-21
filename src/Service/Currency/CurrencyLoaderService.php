<?php
/**
 * User: smerteliko
 * Date: 29.05.2024
 * Time: 21:57
 */

namespace App\Service\Currency;

abstract class CurrencyLoaderService {

	public string $url = '';

	abstract public function load(): void;

	abstract public function save(): void;

	abstract public function setUrl(string $url): void;

	abstract public function getUrl(): string;
}