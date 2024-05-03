const CatalogListComp = () =>  import('../Modules/Catalog/CatalogListComp.vue');
const CategoryComp = () => import( "../Modules/Catalog/CategoryComp.vue");

let catalogRoute = [
	{
		path: '/catalog',
		name: "CatalogListComp",
		component: CatalogListComp,
	},
	{
		path: '/catalog/category/:catID',
		name: "CategoryComp",
		component: CategoryComp
	},

	{
		path: '/catalog/category/:catID/subcategory/:subID',
		name: "CategoryCompBuSub",
		component: CategoryComp
	},
];

export default catalogRoute;