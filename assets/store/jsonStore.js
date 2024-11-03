import {defineStore} from "pinia";
import axios from "axios";

export const useJSONStore = defineStore('jsonlist', {
	state: () => {
		return {
			currencies: [],
			categories: [],
			currencyRates:{},
		};
	},
	actions: {
		async fetchCategoriesList() {
			await axios.get('/json/catalogs')
					.then((response )=> {
						this.categories = response.data.categories
					}).catch((reason)=>{
						console.warn(reason)
					})
		},

		async fetchCurrencyList() {
			await axios.get('/json/currency')
					.then((response )=> {
						this.currencies = response.data.currencies;
					}).catch((reason)=>{
						console.warn(reason)
					})
		},
	},
	getters: {
		getCurrencies() {
			return this.currencies;
		}
	},
});