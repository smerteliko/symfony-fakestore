import {createRouter, createWebHistory} from "vue-router";
import startRoute from "./startRoute";
import catalog from "./catalogRoute.js";
import cartRoute from "./cartRoute";


let router =  createRouter({
	history: createWebHistory(),
	routes: [].concat(
			startRoute,
			catalog,
			cartRoute
	),
});

export default router;