import VueRouter from "vue-router";
import startRoute from "./startRoute";
import Vue from "vue";
import catalog from "./catalogRoute.js";
import cartRoute from "./cartRoute";

Vue.use(VueRouter);

let router = new VueRouter({
	mode: 'history',
	routes: [].concat(
			startRoute,
			catalog,
			cartRoute
	),
});

export default router;