<template>
    <div class="component  container bg-light component-flex">
        <div class="row mb-5 mt-2  ">
            <div class="col-5">
                <ProductImagesComp ></ProductImagesComp>
            </div>
            <div class="col-4">
                   <ProductShortDescComp :product="this.product"></ProductShortDescComp>
            </div>
            <div class="col-3">
                <ProductImagesComp ></ProductImagesComp>
            </div>
        </div>
        <div class="hr mt-4 mb-2">

        </div>
        <div class="row">
            <ProductFullDescComp :productDesc="this.product.productDescription"></ProductFullDescComp>
        </div>
    </div>
</template>

<script>
import ProductImagesComp from "./ProductImagesComp.vue";
import {mapGetters} from "vuex";
import ProductShortDescComp from "./ProductShortDescComp.vue";
import ProductFullDescComp from "./ProductFullDescComp.vue";

export default {
    name: "ProductComp",
    components: {ProductShortDescComp, ProductImagesComp,ProductFullDescComp},
    data() {
        return {
            product:[],
            productID: this.$router.currentRoute.value.params.id
        };
    },
    computed: {
        ...mapGetters([
            'getProductData'
        ]),
    },
   async  beforeMount() {
        await this.$store.dispatch('fetchProductData', this.productID);
        await this.$store.dispatch('fetchProductImages', this.productID);

        this.product = this.getProductData;
    },
}
</script>

<style scoped>
.hr {

    height: 3px!important;
    width: 100% !important;
    background-color: rgba(13,13,213,1)!important;
}
</style>