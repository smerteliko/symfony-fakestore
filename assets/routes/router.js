import VueRouter from "vue-router";
import startRoute from "./startRoute";
import Vue from "vue";
import catalog from "./catalog.js";

Vue.use(VueRouter);

let router = new VueRouter({
	mode: 'history',
	routes: [].concat(
			startRoute,
			catalog
	),
});

export default router;