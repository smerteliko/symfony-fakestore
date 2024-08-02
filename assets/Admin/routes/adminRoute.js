import AdminComp from "../Modules/Admin/AdminComp.vue";
import AdminCompMain from "../Modules/Admin/AdminCompMain.vue";
import AdminCompEntities from "../Modules/Admin/AdminCompEntities.vue";
import AdminUserLoginComp from "../Modules/AdminUser/AdminUserLoginComp.vue";

let adminRoute = [
	{
		path: '/admin',
		name: 'AdminComp',
		component: AdminComp,
		meta: {
			requiresAuth: true,
			isAdmin: true
		},
		children: [
			{
				name: 'AdminCompMain',
				path: 'main',
				component: AdminCompMain,
				meta: {
					requiresAuth: true,
					isAdmin: true
				},
			},
			{
				name: 'AdminCompEntities',
				path: 'entities',
				component: AdminCompEntities,
				meta: {
					requiresAuth: true,
					isAdmin: true
				},
			},
		],

	},
	{
		path: '/admin/login',
		name: 'AdminUserLogin',
		component:  AdminUserLoginComp
	}
];

export default adminRoute;