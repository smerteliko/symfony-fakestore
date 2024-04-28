import Vuex from 'vuex'
import categoryStore from './categoryStore'
import Vue from "vue";

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
	modules: {
		Category: categoryStore,
	}
});

export default store;