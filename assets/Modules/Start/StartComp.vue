<template>
  <div class="container component component-flex bg-light ">
    <div class="container container-color">
      <ProductListComp :product-list="getProductList" />
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import ProductListComp from "../Products/ProductsListComp.vue"

export default {
    name: 'StartComp',
    components: { ProductListComp},
    computed:{
        ...mapGetters([
            'getProductList'
        ])
    },
    beforeMount() {
        this.$store.dispatch('fetchProductList');

    }
}
</script>


<style scoped>

</style>