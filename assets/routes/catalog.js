import CatalogComp from "../Modules/Catalog/CatalogComp.vue";
import CategoryComp from "../Modules/Catalog/CategoryComp.vue";

export default [
	{
		path: '/catalog',
		name: "CatalogComp",
		component: CatalogComp
	},
	{
		path: '/catalog/category/:id',
		name: "CategoryComp",
		component: CategoryComp
	}
];