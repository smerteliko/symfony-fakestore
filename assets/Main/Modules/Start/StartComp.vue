<template>
  <div class="container component component-flex bg-light ">
    <div class="container container-color">
      <ProductListComp :product-list="this.productStore.getProductList" />
    </div>
  </div>
</template>

<script>
import ProductListComp from "../Products/ProductsListComp.vue"
import {useProductStore} from "../../store/productsStore";
import {mapActions, mapStores} from 'pinia'

export default {
    name: 'StartComp',
    components: { ProductListComp},
    computed:{
      ...mapStores(useProductStore),
    },
    beforeMount() {
      this.fetchProductList();

    },
  methods: {
    ...mapActions(useProductStore, ["fetchProductList"]),
  }
}
</script>


<style scoped>

</style>