import axios from "axios";
import {defineStore} from "pinia";

export const useProductStore = defineStore('product', {
	state: () =>{
		return {
			productsList: [],
			productsListByCat: [],
			productsListBySubCat: [],
			productData: [],
			productImages: []
		}
	},
	getters: {
		getProductList() {
			return this.productsList;
		},
		getProductListByCat () {
			return this.productsListByCat;
		},
		getProductListBySubCat () {
			return this.productsListBySubCat;
		},
		getProductData() {
			return this.productData;
		},
		getProductImages() {
			return this.productImages;
		},
	},
	actions: {
		async fetchProductList() {
			await axios.get('/products/ajax/list')
					.then((response )=> {
						this.productsList = response.data;
					}).catch((reason)=>{
						console.warn(reason)
					});
		},
		async fetchProductListByCat(id) {
			await axios.get('/products/ajax/category/'+id)
					.then((response )=> {
						this.productsListByCat = response.data;
					}).catch((reason)=>{
						console.warn(reason);
					});
		},

		async fetchProductListBySubCat(id) {
			await axios.get('/products/ajax/subcategory/'+id)
					.then((response )=> {
						this.productsListBySubCat = response.data;
					}).catch((reason)=>{
						console.warn(reason);
					});
		},

		async fetchProductData(id) {
			await axios.get('/products/ajax/'+id)
					.then((response )=> {
						this.productData = response.data.productData;
					}).catch((reason)=>{
						console.warn(reason);
					});
		},
		async fetchProductImages(id) {
			await axios.get('/products/ajax/'+id+'/images/')
					.then((response )=> {
						this.productImages = response.data.productImages;
					}).catch((reason)=>{
						console.warn(reason);
					});
		},
	},
});