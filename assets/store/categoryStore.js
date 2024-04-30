import axios from "axios";

export default {
	state: {
		categoryList: [],
		categoryData: []
	},
	mutations: {
		SET_CATEGORY_LIST(state, value) {
			state.categoryList = value;
		},
		SET_CATEGORY_DATA(state, value) {
			state.categoryData = value;
		},
	},
	getters: {
		getCategoryList: (state) => { return state.categoryList; },
		getCategoryData: (state) => { return state.categoryData; }
	},
	actions: {
		async fetchCatList({commit}) {
			const data = await axios.get('/catalog/ajax/list')
					.then((response )=> {
						commit("SET_CATEGORY_LIST",response.data.dataObject)
					}).catch((reason)=>{
						console.warn(reason)
					})
		},

		async fetchCategoryData({commit}, id ) {
			const data = await axios.get('/catalog/ajax/category/'+id.id)
					.then((response )=> {
						commit("SET_CATEGORY_DATA",response.data.dataObject)
					}).catch((reason)=>{
						console.warn(reason)
					})
		}
	},
}