import {createRouter, createWebHistory} from "vue-router";
import startRoute from "./startRoute";
import catalog from "./catalogRoute.js";
import cartRoute from "./cartRoute";
import productRoute from "./productRoute";
import userRoute from "./userRoute";
import {useUserStore} from "../../store/userStore";
import mainLayout from "../Modules/templates/MainLayout.vue";


let router =  createRouter({
	history: createWebHistory(),
	// routes: [].concat(
	// 		startRoute,
	// 		catalog,
	// 		cartRoute,
	// 		productRoute,
	// 		userRoute,
	// 		adminRoute
	// ),
	routes: [
		{
			name:'MainLayout',
			path:'/',
			component: mainLayout,
			children:
				[].concat(
						startRoute,
						catalog,
						cartRoute,
						productRoute,
						userRoute
				)
		},
	]
});
router.beforeEach( async (to, from ,next) => {
	const store = useUserStore();
	await store.isAuthorized();
	if (to.meta.requiresAuth && !store.isAuthed) {
		next({name:'StartComp'});
		return;
	}
	if(to.meta.isAdmin && !store.checkAdmin) {
		next({name:'StartComp'});
		return;
	}
	next();
	return;

});


export default router;