<template>
  <tr class="d-flex tr-height">
    <td class="align-content-center ">
      <img
        :src="this.image"
        class="img-thumbnail"
        width="100px"
        height="100px"
        alt="No image"
      >
    </td>
    <td class="align-content-center col-3 ">
      <RouterLink
        :to="{name: 'ProductComp', params:{id: this.cartItem.id}}"
        class=" link-underline-opacity-100 text-decoration-none"
      >
        <h6 class="mb-0 text-decoration-underline">
          {{ this.cartItem.Name }}
        </h6>
        <div class="product-description">
          <small class="text-secondary"> {{ this.desc }}</small>
        </div>
      </RouterLink>
    </td>
    <td class="align-content-center col-2">
      <div class="input-group input-group-sm flex-nowrap w-100 ">
        <button
          class="btn btn-outline-danger border-end-0 border-radius"
          type="button"
          @click="removeQuantity()"
        >
          <i
            :class="{
              'fa-solid fa-minus' : this.quantity !== 1,
              'fa-regular fa-trash-can' : this.quantity === 1}"
          />
        </button>
        <input
          v-model="this.cartItem.quantity"
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
    </td>
    <td class="align-content-center col-3">
      <h5 class="mb-0">
        Total: {{ this.cartItem.totalPrice }} <i class="fa-solid fa-dollar-sign" />
      </h5>
      <small class="text-secondary text-decoration-underline">
        <i> Per each: {{ this.cartItem.price }} </i>
        <i class="fa-italic  fa-dollar-sign" />
      </small>
      <p class="align-text-bottom mb-0">
        Shipping:
      </p>
    </td>
    <td class="align-content-center col-1">
      <div class="form-check">
        <input
          v-model="this.checked"
          type="checkbox"
          class="form-check-input"
        >
      </div>
    </td>
    <td class="align-content-center col-1">
      <div class="form-check ps-0">
        <label class="fancy-checkbox font-size-x-large">
          <input
            class="form-check-input"
            type="checkbox"
          >
          <i class="fa-regular icon-color fa-heart unchecked" />
          <i class="fa-solid icon-color fa-heart checked" />
        </label>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
    name: "CartListItem",
    props:["cartItem"],
    data() {
        return {
            checked: this.cartItem.checked,
            favourite: false,
            quantity: this.cartItem.quantity,
            image: this.checkImg() ? require(`../../img/` + this.checkImg()) : '',
            desc: this.cartItem.productDescription ? this.cartItem.productDescription.BriefDesc : ''
        }
    },
    computed:{
    },

    watch:{
        checked: {
            handler(newVal) {
                this.$store.dispatch('updateCartItemSelection', {item:this.cartItem,checked:newVal});
                this.checked = this.cartItem.checked;

            },
        },
        'cartItem.checked': {
            handler(newVal) {
                this.$store.dispatch('updateCartItemSelection', {item:this.cartItem,checked:newVal});
                this.checked = newVal
            },
        },
    },
    beforeMount() {
        this.$store.commit('SET_CART_ITEM_TOTAL', this.cartItem);
        this.$store.commit('SET_ALL_CART_UNSELECTED', false);
        this.checked = this.cartItem.checked;
    },
    methods: {

        checkImg() {
            if (this.cartItem && this.cartItem.productImages.length > 0) {
                return this.cartItem.productImages[0].FileNameBase;
            }
            return '';
        },

        addQuantity() {
            this.$store.dispatch('addCartItemQuantity', this.cartItem);
            this.$store.commit('SET_CART_ITEM_TOTAL', this.cartItem);

        },
        removeQuantity() {
            this.$store.dispatch('removeCartItemQuantity', this.cartItem);
            this.$store.commit('SET_CART_ITEM_TOTAL', this.cartItem);
            if(this.cartItem.quantity === 0) {
                this.$store.dispatch('removeItemFromCart', this.cartItem);

            }
            this.$forceUpdate();


        }
    }
}
</script>

<style scoped>
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

input[type=checkbox]
{
    /* Double-sized Checkboxes */
    -ms-transform: scale(1.5); /* IE */
    -moz-transform: scale(1.5); /* FF */
    -webkit-transform: scale(1.5); /* Safari and Chrome */
    -o-transform: scale(1.5); /* Opera */
    padding: 5px;
}

.tr-height {
    height: 120px;
}

.product-description {
    display: -webkit-box !important ;
    -webkit-line-clamp: 2 !important ;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    cursor: pointer !important;
}

.border-input {
    border-style: solid !important;
    border-image: linear-gradient(90deg, rgba(220,53,69,1) 0%, rgba(25,135,84,1) 100%) 1 !important;
}

.border-radius {
    border-radius: 20px
}

.fancy-checkbox input[type="checkbox"],
.fancy-checkbox .checked {
    display: none !important;
    width: 1em !important;
    height: 1em !important;
}

.fancy-checkbox input[type="checkbox"],
.fancy-checkbox .checked {
    display: none !important;
    width: 1em !important;
    height: 1em !important;
}

.fancy-checkbox input[type="checkbox"]:checked ~ .checked
{
    display: inline-block!important;
    width: 1em !important;
    height: 1em !important;
}

.fancy-checkbox input[type="checkbox"]:checked ~ .unchecked
{
    display: none !important;
    width: 1em!important;
    height: 1em!important;
}

.font-size-x-large {
    font-size: x-large !important;
}


</style>