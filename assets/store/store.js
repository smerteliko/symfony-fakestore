import Vuex from 'vuex'
import categoryStore from './categoryStore'

import productsStore from "./productsStore";
import cartStore from "./cartStore";


const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
	modules: {
		Category: categoryStore,
		Products: productsStore,
		Cart: cartStore
	},
});


export default store;