const CartComp = () => import( "../Modules/Cart/CartComp.vue");

let cartRoute  = [
	{
		path: '/cart',
		name: "CartComp",
		component: CartComp
	},
];
export default cartRoute;