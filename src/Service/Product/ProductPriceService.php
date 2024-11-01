<?php
/**
 * User: smerteliko
 * Date: 17.06.2024
 * Time: 12:54
 */

namespace App\Service\Product;

use App\Service\Currency\CurrencyOperations;

class ProductPriceService {

	private CurrencyOperations $currencyOperations;

	public function __construct(CurrencyOperations $currencyOperations) {
		$this->currencyOperations = $currencyOperations;
	}

	private function getProductPriceByCurrency( $productPrice): array {
		return $this->currencyOperations->exchangeToAllCurrencies($productPrice);
	}

	public function getProductPriceInAllCurr( $productPrice): array {
		return $this->currencyOperations->exchangeToAllCurrencies($productPrice);
	}


	public function getProductListPricesInAllCurr($products = []) {
		foreach ($products as $product => $value) {
			$products[$product]['productPrice'] =
				$this->getProductPriceByCurrency($value['productPrice']);
		}
		return $products;
	}
}