<template>

    <div class="container component component-flex bg-light ">
        <div class="container container-color">
            <ProductListComp :product-list="getProductList"></ProductListComp>
        </div>

    </div>

</template>

<script>
import {mapGetters} from "vuex";
import ProductCardComp from "../Products/ProductCardComp.vue";
import ProductListComp from "../Products/ProductsListComp.vue"
export default {
    name: 'StartComp',
    components: {ProductCardComp, ProductListComp},
    beforeMount() {
        this.$store.dispatch('fetchProductList');

    },
    computed:{
        ...mapGetters([
            'getProductList'
        ])
    }
}
</script>


<style scoped>

</style>