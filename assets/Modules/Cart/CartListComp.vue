<template>
  <div class="container container-color  rounded-container align-content-lg-start ">
    <table class="table table-collapse table-hover ">
      <tbody
        v-for="prod in this.cartList"
        :key="`cart-list-item-product`+prod.Name"
        class=""
      >
        <CartListItem
          :key="`cart-list-item-`+prod.id"
          :cart-item="prod"
        />
      </tbody>
    </table>
  </div>
</template>

<script>

import CartListItem from "./CartListItem.vue";

export default {
    name:'CartListComp',
    components: {CartListItem},
    props: {
      cartList: {
        type: Object,
        default() {
          return {  }
        }
      }
    },
    data(){
        return {

        }
    },
    beforeMount() {

    },
}
</script>

<style scoped>


.table-collapse {
    border-collapse: separate;
    border-spacing:0 20px;
}

</style>
