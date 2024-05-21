import {createRouter, createWebHistory} from "vue-router";
import startRoute from "./startRoute";
import catalog from "./catalogRoute.js";
import cartRoute from "./cartRoute";
import productRoute from "./productRoute";
import userRoute from "./userRoute";


let router =  createRouter({
	history: createWebHistory(),
	routes: [].concat(
			startRoute,
			catalog,
			cartRoute,
			productRoute,
			userRoute
	),
});
// router.beforeEach((to) => {
// 	const store = useUserStore()
// 	if (to.meta.requiresAuth && !store.isAuthed) return '/'
// })

export default router;