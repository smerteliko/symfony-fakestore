<template>
  <div class="component  container bg-light component-flex container-color">
    <div class="row mb-2 mt-2">
      <div class="col-5">
        <ProductImagesComp />
      </div>
      <div class="col-4">
        <ProductShortDescComp :product="product" />
      </div>
      <div class="col-3">
        <ProductOrderComp :product="product" />
      </div>
    </div>
    <div class="row mt-2 mb-2 w-100">
      <ProductFullDescComp :product-desc="product.productDescription" />
    </div>
    <div class="row mt-2 mb-2 w-100">
      <ProductCharacteristicComp :product-characteristic="product.productCharacteristic" />
    </div>
  </div>
</template>

<script>
import ProductImagesComp from "./ProductImagesComp.vue";
import {mapGetters} from "vuex";
import ProductShortDescComp from "./ProductShortDescComp.vue";
import ProductFullDescComp from "./ProductFullDescComp.vue";
import ProductCharacteristicComp from "./ProductCharacteristicComp.vue";
import ProductOrderComp from "./ProductOrderComp.vue";

export default {
    name: "ProductComp",
    components: {
      ProductShortDescComp,
      ProductImagesComp,
      ProductFullDescComp,
      ProductCharacteristicComp,
      ProductOrderComp
    },
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