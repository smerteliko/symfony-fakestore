const UserComp = ()=> import("../Modules/User/UserComp.vue");

let userRoute = {
	path: '/user/profile',
	name: 'UserComp',
	component: UserComp,
	meta: { requiresAuth: true }
};

export default userRoute;