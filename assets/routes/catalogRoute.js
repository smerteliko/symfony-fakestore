const CatalogListComp = () =>  import('../Modules/Catalog/CatalogListComp.vue');
const CategoryComp = () => import( "../Modules/Catalog/CategoryComp.vue");

let catalogRoute = [
	{
		path: '/catalog',
		name: "CatalogListComp",
		component: CatalogListComp
	},
	{
		path: '/catalog/category/:id',
		name: "CategoryComp",
		component: CategoryComp
	},
];

export default catalogRoute;