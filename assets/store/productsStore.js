import axios from "axios";

export default {
	state: {
		productsList: [],
		productsListByCat:[],
		productsListBySubCat:[],
		productData:[],
		productImages: []
	},
	mutations: {
		SET_PRODUCTS_LIST(state, value) {
			state.productsList = value;
		},
		SET_PRODUCTS_LIST_BY_CAT(state, value) {
			state.productsListByCat = value;
		},
		SET_PRODUCTS_LIST_BY_SUB_CAT(state, value) {
			state.productsListBySubCat = value;
		},
		SET_PRODUCT_DATA(state, value) {
			state.productData = value;
		},
		SET_PRODUCT_IMAGES(state, value) {
			state.productImages = value;
		}
	},
	actions: {
		async fetchProductList({commit}) {
			await axios.get('/products/ajax/list')
					.then((response )=> {
						commit("SET_PRODUCTS_LIST",response.data);
					}).catch((reason)=>{
						console.warn(reason)
					});
		},
		async fetchProductListByCat({commit}, id) {
			await axios.get('/products/ajax/category/'+id)
					.then((response )=> {
						commit("SET_PRODUCTS_LIST_BY_CAT",response.data);
					}).catch((reason)=>{
						console.warn(reason);
					});
		},

		async fetchProductListBySubCat({commit}, id) {
			await axios.get('/products/ajax/subcategory/'+id)
					.then((response )=> {
						commit("SET_PRODUCTS_LIST_BY_SUB_CAT",response.data);
					}).catch((reason)=>{
						console.warn(reason);
					});
		},

		async fetchProductData({commit}, id) {
			await axios.get('/products/ajax/'+id)
					.then((response )=> {
						commit("SET_PRODUCT_DATA",response.data.productData);
					}).catch((reason)=>{
						console.warn(reason);
					});
		},
		async fetchProductImages({commit}, id) {
			await axios.get('/products/ajax/'+id+'/images/')
					.then((response )=> {
						commit("SET_PRODUCT_IMAGES",response.data.productImages);
					}).catch((reason)=>{
						console.warn(reason);
					});
		},
	},
	getters: {
		getProductList: (state) => {
			return state.productsList;
		},
		getProductListByCat: (state) => {
			return state.productsListByCat;
		},
		getProductListBySubCat: (state) => {
			return state.productsListBySubCat;
		},
		getProductData: (state) => {
			return state.productData;
		},
		getProductImages:(state) => {
			return state.productImages;
		},
	},
}