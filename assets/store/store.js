import Vuex from 'vuex'
import categoryStore from './categoryStore'
import Vue from "vue";
import productsStore from "./productsStore";
import cartStore from "./cartStore";

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
	modules: {
		Category: categoryStore,
		Products: productsStore,
		Cart: cartStore
	},
});


export default store;