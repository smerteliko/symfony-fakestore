import {createRouter, createWebHistory} from "vue-router";
import AdminLayout from "../Modules/templates/AdminLayout.vue";
import AdminRoute from "./adminRoute";
import {useUserStore} from "../../store/userStore";


let router =  createRouter({
	history: createWebHistory(),
	routes: [
		{
			name: 'AdminLayout',
			path: '/',
			component: AdminLayout,
			children: [].concat(AdminRoute),
			meta: {
				requiresAuth: true,
				isAdmin: true
			},

		}
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