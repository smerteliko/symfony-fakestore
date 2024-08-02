<template>
  <div class="mt-4 container border-1-solid-white border-product-order shadow">
    <div class="d-flex flex-column mt-3 mb-3">
      <div class="row">
        <h4>
          {{ this.getPrice() }}
          <i
            class=""
            v-text="this.getPriceCurrency()"
          />
        </h4>
      </div>
      <div class="mt-3 row flex-row">
        <div class="col-6 d-flex justify-content-center">
          <button
            v-show="this.productQuantity === 0"
            class="btn btn-outline-success "
            :class="this.productQuantity !== 0 ? 'disabled':''"
            @click="this.productQ++"
          >
            <small>Add to cart <i class="fa-solid fa-cart-plus" /></small>
          </button>
          <button
            v-show="this.productQuantity !== 0"
            class="btn btn-outline-success "
            @click="this.$router.push({path:'/cart'})"
          >
            <small>Go to cart <i class="fa-solid fa-cart-plus" /></small>
          </button>
        </div>
        <div class="col-6 d-flex justify-content-center">
          <button
            v-show="this.productQuantity === 0"
            class="btn btn-outline-warning "
          >
            Buy now <i class="fa-solid fa-cart-plus" />
          </button>
          <div 
            v-show="this.productQuantity !== 0"
            class="input-group input-group-sm flex-nowrap w-100 "
          >
            <button
              class="btn btn-outline-danger border-end-0 border-radius"
              type="button"
              @click="removeQuantity()"
            >
              <i
                :class="{
                  'fa-solid fa-minus' : this.productQ !== 1,
                  'fa-regular fa-trash-can' : this.productQ === 1}"
              />
            </button>
            <input
              v-model="this.productQ"
              class="form-control border border-end-0 border-start-0 border-input"
              value="1"
              min="1"
              type="number"
              disabled
            >
            <button
              class=" btn btn-outline-success border-start-0 border-radius"
              type="button"
              @click="addQuantity()"
            >
              <i class="fa-solid fa-plus" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapStores} from "pinia";
import {useUserStore} from "../../../store/userStore";
import {useJSONStore} from "../../../store/jsonStore";

export default {
  name: "ProductOrderComp",
  props: {
    product: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  data() {
    return {
      productQ: 0
    };
  },
  computed: {
    productPrice() {
      return this.product.productPrice? this.product.productPrice.Price:'';
    },
    productQuantity() {
      return this.productQ;
    },
    ...mapStores(useUserStore, useJSONStore)
  },

  methods: {

    addQuantity() {
      this.productQ++;

    },
    removeQuantity() {
      this.productQ--;
    },

    getPrice() {
      if(!this.userStore.isAuthed) {
        return this.product.productPrice.ConvertedPrice[840]
      }

      return this.product.productPrice.ConvertedPrice[this.userStore.currencyID]
    },
    getPriceCurrency() {
      const findSymbol = this.jsonlistStore.currencies.find((item)=>{
        return item.IsoCode === (this.userStore.currencyID ? this.userStore.currencyID : 840)
      })
      return findSymbol.Symbol
    }
  }
}
</script>

<style scoped>

.shadow {
  box-shadow:
    rgba(0, 0, 0, 0.25) 0px 54px 55px,
    rgba(0, 0, 0, 0.12) 0px -12px 30px,
    rgba(0, 0, 0, 0.12) 0px 4px 6px,
    rgba(0, 0, 0, 0.17) 0px 12px 13px,
    rgba(0, 0, 0, 0.09) 0px -3px 5px !important;
}

.border-product-order {
  border-radius: 20px;
}

.order-btn-color {
  background: rgba(16, 196, 76, 1);
  color: white;
}

.border-input {
  border-style: solid !important;
  border-image: linear-gradient(90deg, rgba(220,53,69,1) 0%, rgba(25,135,84,1) 100%) 1 !important;
}

.border-radius {
  border-radius: 20px
}
</style>