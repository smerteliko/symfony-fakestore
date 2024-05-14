<template>
  <div class="card-group">
    <div
      v-for="prod in productList"
      :key="`product-item-`+prod.id"
      class="col mt-5 mb-2 me-2"
    >
      <ProductCardComp
        :key="`product-item-`+prod.id"
        :product="prod"
      />
    </div>
  </div>
</template>

<script>
import ProductCardComp from "./ProductCardComp.vue";

export default {
    name: 'ProductsListComp',
    components: {ProductCardComp},
    props:{
      productList: {
        type: Object,
        default() {
          return {  }
        }
      }
    },
}
</script>

<style scoped>

</style>