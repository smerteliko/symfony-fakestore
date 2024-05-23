import {createRouter, createWebHistory} from "vue-router";
import startRoute from "./startRoute";
import catalog from "./catalogRoute.js";
import cartRoute from "./cartRoute";
import productRoute from "./productRoute";
import userRoute from "./userRoute";
import {useUserStore} from "../store/userStore";


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
router.beforeEach(async (to) => {
	const store = useUserStore();
	await store.isAuthorized();
	if (to.meta.requiresAuth && !store.isAuthed) return '/'
});

export default router;