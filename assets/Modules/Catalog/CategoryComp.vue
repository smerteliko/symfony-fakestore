<template>
    <div class="component container bg-light ">
        <div class="container">
            <div class="row">
                <h1>{{ catData.Name}}</h1>
            </div>
        </div>
        <div class="container container-color d-flex">
            <div class="container m-0 w-25 border-left-panel ">
                <ul class="list-group list-group-flush border-left-panel mb-2 mt-2" v-for="subCat in this.catData.subCategories">
                    <li class="list-group-item
                               list-group-item-action">
                        <button class="btn" @click="changeSubCat(subCat.id)">{{subCat.Name}}</button></li>
                </ul>
            </div>
            <div class="container container-color m-0 w-75 d-flex flex-wrap">
                <div class="container w-100">
                    <div class="row">
                        <h5 class="col"> Total: <small>{{this.total}} items found</small></h5>
                    </div>
                </div>
                <div class="container">
                    <div v-if="this.loading">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                        </div>
                    </div>
                    <div v-else  class=" mb-2 mt-1 card-group">
                        <ProductListComp :product-list="this.productsList"></ProductListComp>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import productCardComp from "../Products/ProductCardComp.vue";
import ProductListComp from "../Products/ProductsListComp.vue"
export default {
    name: "CategoryComp",
    components: {productCardComp,ProductListComp},
    data(){
        return {
            catData: {},
            productsList: {},
            loading: true,
            total: 0
        }
    },
    computed: {
        ...mapGetters([
            'getCategoryData' ,
            'getProductListByCat',
            'getProductListBySubCat'
        ]),
    },
    methods: {
        async changeSubCat(subID) {
            console.log(subID)
            this.loading = true
            await this.$store.dispatch('fetchProductListBySubCat', subID)
            this.productsList = this.$store.getters.getProductListBySubCat
            this.total = this.productsList.length
            this.loading = false;
        }
    },
    async beforeMount() {
        this.loading = true
        await this.$store.dispatch('fetchCategoryData', this.$route.params)
        await this.$store.dispatch('fetchProductListByCat', this.$route.params)
        this.catData = this.$store.getters.getCategoryData
        this.productsList = this.$store.getters.getProductListByCat
        this.total = this.productsList.length
        this.loading = false
    }
}
</script>

<style scoped>
.border-left-panel{
    border: 1px solid #e3e8ef;
    border-radius: 8px;
}
</style>