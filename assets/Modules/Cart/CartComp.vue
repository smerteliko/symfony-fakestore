<template>
  <div class="component container bg-light vh-auto container-color vh-100">
    <div class="container">
      <div class="row mt-2">
        <div class="col-5 pt-2 d-flex justify-content-between align-items-center">
          <div class="m4-4">
            <h1>{{ 'Cart' }}</h1>
          </div>
        </div>
        <div 
          v-if="this.cartStore.getCartTotalItems > 0"
          class="col-2 d-flex justify-content-center align-items-center"
        >
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
    <div
      v-if="this.cartStore.getCartTotalItems > 0"
      class="row"
    >
      <div class="container col-7">
        <CartListComp :cart-list="this.cartItemsList" />
      </div>
      <div class="container col-4">
        <CartOrderComp :selected-items="this.cartStore.getCheckedCartItems" />
      </div>
    </div>
    <div
      v-else
      class="row pt-4 pb-3"
    >
      <div class="container rounded-container bg-body-secondary p-5 col-7 d-flex justify-content-center  align-items-center flex-column">
        <h3>There is no items in the cart</h3>
        <h5>
          {{ this.getCartEmptyText() }}
        </h5>
      </div>
      <div class="container col-4">
        <div class="container bg-body-secondary  rounded-container d-flex justify-content-center flex-column">
          <div
            v-if="!this.userStore.isAuthed"
            class="row"
          >
            <div class=" btn-group height-58px pt-5 pb-3 pe-5 ps-5">
              <button
                type="button"
                class="btn-success rounded-pill btn"
                data-bs-target="#loginModal"
                data-bs-toggle="modal"
                data-bs-dismiss="modal"
              >
                <b> Sign in </b>
              </button>
            </div>
          </div>
          <div class="row">
            <div
              :class="this.userStore.isAuthed ? 'pt-5':''"
              class=" btn-group height-58px  pb-5 pe-5 ps-5"
            >
              <RouterLink
                type="button"
                class="active rounded-pill btn"
                to="/"
              >
                <b> To main </b>
              </RouterLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CartListComp from "./CartListComp.vue";

import CartOrderComp from "./CartOrderComp.vue";
import {mapActions, mapStores} from "pinia";
import {useCartStore} from "../../store/cartStore";
import {useUserStore} from "../../store/userStore";

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
        ...mapStores(useCartStore, useUserStore),
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

      getCartEmptyText() {
        let rtrnText = 'Please select products ';
        if( ! this.userStore.isAuthed ) {
          rtrnText+='or log in if you previously added items to cart';
        }

        return rtrnText;
      },

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