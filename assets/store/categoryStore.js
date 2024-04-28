import axios from "axios";

export default {
	state: {
		categoryList: [],
	},
	mutations: {
		SET_CATEGORY_LIST(state, value) {
			state.categoryList = value;
		},
	},
	getters: {
		getCategoryList: (state) => { return state.categoryList; }
	},
	actions: {
		async fetchCatList({commit}) {
			const data = await axios.get('/catalog/list')
					.then((response )=> {
						commit("SET_CATEGORY_LIST",response.data.list)
					}).catch((reason)=>{
						console.warn(reason)
					})
		}
	}
}