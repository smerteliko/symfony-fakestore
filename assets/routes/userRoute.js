
const UserComp = ()=> import("../Modules/User/UserComp.vue");
const UserPersonalInfo = ()=> import("../Modules/User/UserPersonalInfoComp.vue");

let userRoute = [
	{
		path: '/user/profile',
		name: 'UserComp',
		component: UserComp,
		meta: {requiresAuth: true},
		children: [
			{
				// UserProfile will be rendered inside User's <router-view>
				// when /user/:id/profile is matched
				name: 'UserPersonalInfo',
				path: 'personal_info',
				component: UserPersonalInfo,
			},
		]

	}
];

export default userRoute;