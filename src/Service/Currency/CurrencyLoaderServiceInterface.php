<?php
/**
 * User: smerteliko
 * Date: 29.05.2024
 * Time: 21:56
 */

namespace App\Service\Currency;

interface CurrencyLoaderServiceInterface {

	public function load():void;

	public function saveToDB();
}