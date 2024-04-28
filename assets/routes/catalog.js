import CatalogComp from "../Modules/Catalog/CatalogComp.vue";
import CategoryComp from "../Modules/Catalog/CategoryComp.vue";
import CatalogListComp from "../Modules/Catalog/CatalogListComp.vue";

export default [
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