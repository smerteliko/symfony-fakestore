const ProductComp = () => import( "../Modules/Products/ProductComp.vue");

let productRoute  = [
	{
		path: '/products/:id',
		name: "ProductComp",
		component: ProductComp
	},
];
export default productRoute;