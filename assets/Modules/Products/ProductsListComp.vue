<template>
    <div class="card-group">
        <div class="col mt-5 mb-2 me-2" v-for="prod in this.productList">
            <ProductCardComp :product-data="prod"></ProductCardComp>
        </div>
    </div>
</template>

<script>
import ProductCardComp from "./ProductCardComp.vue";

export default {
    name: 'ProductsListComp',
    props:['productList'],
    components: {ProductCardComp}
}
</script>

<style scoped>

</style>