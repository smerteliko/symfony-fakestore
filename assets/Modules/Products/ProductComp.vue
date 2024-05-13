<template>
    <div class="component container bg-light component-flex">
        <div class="row mb-2  ">
            <div class="col-5">
                <ProductImagesComp ></ProductImagesComp>
            </div>
            <div class="col-4">
                <ProductImagesComp ></ProductImagesComp>
            </div>
            <div class="col-3">
                <ProductImagesComp ></ProductImagesComp>
            </div>
        </div>
        <div class="row"></div>
    </div>
</template>

<script>
import ProductImagesComp from "./ProductImagesComp.vue";
import {mapGetters} from "vuex";

export default {
    name: "ProductComp",
    components: {ProductImagesComp},
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

</style>