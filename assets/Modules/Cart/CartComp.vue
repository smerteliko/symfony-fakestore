<template>
  <div class="component container bg-light vh-auto container-color">
    <div class="container">
      <div class="row">
        <div class="col-5 d-flex justify-content-between align-items-center">
          <div class="ms-4">
            <h1>{{ 'Cart' }}</h1>
          </div>
        </div>
        <div class="col-2 d-flex justify-content-center align-items-center">
          <div class="pe-calc ">
            <button
              class="btn"
              @click="this.removeFromCart"
            >
              <i class="fs-x-large icon-color  fa-regular fa-trash-can" />
            </button>
          </div>
          <div class="pe-calc  pe-40px form-check">
            <input
              v-model="this.checkedAll"
              class="pe-calc form-check-input"
              type="checkbox"
            >
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="container col-7">
        <CartListComp :cart-list="this.cartItemsList" />
      </div>
      <div class="container col-4">
        <CartOrderComp :selected-items="this.cartStore.getCheckedCartItems" />
      </div>
    </div>
  </div>
</template>

<script>
import CartListComp from "./CartListComp.vue";

import CartOrderComp from "./CartOrderComp.vue";
import {mapActions, mapStores} from "pinia";
import {useCartStore} from "../../store/cartStore";

export default {
    name: 'CartComp',
    components: {CartOrderComp, CartListComp},
    data(){
        return {
            cartItemsList: [],
            checkedAll: Boolean
        }
    },
    computed: {
        ...mapStores(useCartStore),
    },
    watch: {
        checkedAll: {
             handler(newVal) {
               this.cartStore.updateCartItemsSelection(newVal)
            }
        }
    },
    beforeMount() {
        this.cartStore.updateCartListFromLS();
        this.cartItemsList = this.cartStore.getCartItems;
        this.cartStore.updateCartItemsSelection(false)

    },

    methods:{
      ...mapActions(useCartStore,[
        'getCartItems',
        'getCheckedCartItems',
        'removeSelectedCartItems',
        'updateCartListFromLS',
        'updateCartItemsSelection'
      ]),

        removeFromCart() {
            let indexes = [];
            this.cartItemsList.forEach((value, key)=>{
                if(value.checked) {
                    indexes.push(key);
                }

            });
          this.cartStore.removeSelectedCartItems(indexes)
        }
    },
}
</script>

<style scoped>
.vh-auto {
    height: auto;
}

.pe-calc {
    padding-right: calc(2rem* 0.5);

}

.pe-40px {
    padding-right: 40px !important;
}

.fs-x-large {
    font-size: x-large;
}

input[type=checkbox]
{
    /* Double-sized Checkboxes */
    -ms-transform: scale(1.5); /* IE */
    -moz-transform: scale(1.5); /* FF */
    -webkit-transform: scale(1.5); /* Safari and Chrome */
    -o-transform: scale(1.5); /* Opera */
    padding: 5px;
}
</style>