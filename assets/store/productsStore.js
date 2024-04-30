import axios from "axios";

export default {
	state: {
		productsList: [],
		productsListByCat:[],
		productsListBySubCat:[],
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
	},
	getters: {
		getProductList: (state) => { return state.productsList; },
		getProductListByCat: (state) => { return state.productsListByCat; },
		getProductListBySubCat: (state) => { return state.productsListBySubCat; },
	},
	actions: {
		async fetchProductList({commit}) {
			const data = await axios.get('/products/ajax/list')
					.then((response )=> {
						commit("SET_PRODUCTS_LIST",response.data)
					}).catch((reason)=>{
						console.warn(reason)
					})
		},
		async fetchProductListByCat({commit}, id) {
			const data = await axios.get('/products/ajax/category/'+id.id)
					.then((response )=> {
						commit("SET_PRODUCTS_LIST_BY_CAT",response.data)
					}).catch((reason)=>{
						console.warn(reason)
					})
		},

		async fetchProductListBySubCat({commit}, id) {
			const data = await axios.get('/products/ajax/subcategory/'+id)
					.then((response )=> {
						commit("SET_PRODUCTS_LIST_BY_SUB_CAT",response.data)
					}).catch((reason)=>{
						console.warn(reason)
					})
		},
	},
}