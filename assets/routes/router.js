import {createRouter, createWebHistory} from "vue-router";
import startRoute from "./startRoute";
import catalog from "./catalogRoute.js";
import cartRoute from "./cartRoute";
import productRoute from "./productRoute";


let router =  createRouter({
	history: createWebHistory(),
	routes: [].concat(
			startRoute,
			catalog,
			cartRoute,
			productRoute
	),
});

export default router;