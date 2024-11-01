<template>
  <div class="card bg-light border-1-solid-white border-product-foto w-18rem height-400px">
    <div class="card-header header-height">
      <RouterLink
        :to="{name: 'ProductComp', params:{id: product.id}}"
        class=" link-underline-opacity-100 text-decoration-none"
      >
        <h5 class="card-title">
          {{ product.Name }}
        </h5>
      </RouterLink>
    </div>

    <div class="card-body d-flex flex-wrap">
      <img
        :src="image"
        class="card-img-top border-product-foto img-thumbnail"
        alt="No image"
      >

      <span class="product-description "> {{ desc }}</span>
    </div>
    <div class="card-footer">
      <div 
        v-if="product.productPrice" 
        class="d-flex  justify-content-between"
      >
        <div class="row align-items-center">
          <h4 class="mb-0">{{ this.getPrice() }}
            <i 
              class="" 
              v-text="this.getPriceCurrencySymbol()"
            />
          </h4>
        </div>
        <div>
          <button
            class="btn btn-outline-danger"
            :class="product.quantity !== 0 ? 'disabled':''"
            title="Add to cart"
            @click="addItem"
          >
            <i class="fa-solid fa-cart-plus" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapStores} from "pinia";
import {useCartStore} from "../../store/cartStore";
import {useUserStore} from "../../../store/userStore";
import {useJSONStore} from "../../../store/jsonStore";

export default {
    name: "ProductCardComp",
    props: {
      product: {
        type:Object,
        default() {
          return {  }
        }
      }
    },
    data() {
        return {
            image: this.checkImg() ? require(`../../../img/products/` + this.checkImg()) : '',
            quantity: this.product.quantity,
            desc: this.product.productDescription ? this.product.productDescription.BriefDesc : ''

        }
    },
    computed:{
        ...mapStores(useCartStore, useUserStore, useJSONStore)
    },

    methods: {
        ...mapActions(useCartStore, ['addToCart']),

        addItem() {
          this.cartStore.addToCart(this.product)
            this.quantity++;
        },

        checkImg() {
            if (this.product && this.product.productImages.length > 0) {
                return this.product.productImages.find(
                    (value)=>{
                        return value.Main === true;
                    }
                    ).FileNameBase;
            }
            return '';
        },

      getPrice() {
          if(!this.userStore.isAuthed) {
            return this.product.productPrice.ConvertedPrice[840]
          }

          return this.product.productPrice.ConvertedPrice[this.userStore.currencyID]
      },
      getPriceCurrencySymbol() {
        const findCurrency = this.jsonlistStore.currencies.find((item)=>{
          return item.IsoCode === (this.userStore.currencyID ? parseInt(this.userStore.currencyID) : '840')
        })
        return findCurrency?findCurrency.Symbol:'';
      }
    }
}
</script>

<style scoped>
.w-18rem {
    width: 14rem;
}
.height-400px {
  height: 400px;
}
.border-product-foto {
    border-radius: 10px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    text-align: center;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
    text-align: center;
}

input:disabled{
    background: none;
}

.table-collapse {
    border-collapse: separate;
    border-spacing:0 20px;
}

.border-input {
    border-style: solid !important;
    border-image: linear-gradient(90deg, rgba(220,53,69,1) 0%, rgba(25,135,84,1) 100%) 1 !important;
}


.input-width {
    width: 50% !important;
}
.header-height {
  height: 73px;
}

</style>