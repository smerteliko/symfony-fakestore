<template>
  <div
    class="container container-color rounded-container "
    :class="selectedItems.length === 0 ? 'container-danger' : 'container-success'"
  >
    <div
      v-if="selectedItems.length === 0"
      class="mt-4 mb-4 row align-items-center text-center"
    >
      <div class="col text-col-danger">
        <h2 class="">
          Please select items
        </h2>
      </div>
    </div>
    <div
      v-else
      class="d-flex flex-column mt-3 mb-3"
    >
      <div class="row align-items-center text-center">
        <h4> Place an order </h4>
      </div>
      <hr class="hr hr-blurry">
      <div class="row ms-2 me-2 flex-nowrap">
        <div class="col-8">
          <h6> Products (<span v-text="setTotalQuantity()" />)</h6>
        </div>
        <div class="col-4 text-end">
          <i v-text="setTotalPriceForAll()" />
          <i class="ms-1 fa-italic  fa-dollar-sign" />
        </div>
      </div>
      <div class="row ms-2 me-2 flex-nowrap">
        <div class="col-8">
          <i>Discount</i>
        </div>
        <div class="col-4 text-end text-danger">
          -<i v-text="sale" />
          <i class="ms-1 fa-italic  fa-dollar-sign" />
        </div>
      </div>
      <div class="row ms-2 me-2 flex-nowrap">
        <div class="col-8">
          <i>Delivery </i>
        </div>
        <div
          class="col-4 text-end"
          :class="delivery === 0 ? 'text-success':'text-danger'"
          v-text="delivery === 0 ? 'Free':delivery"
        />
      </div>
      <hr class="hr hr-blurry">
      <div class="row flex-nowrap">
        <div class="col-12">
          <button
            class="btn order-btn-color form-control text-center "
            type="button"
          >
            <span class="fs-x-large ">
              <b>Checkout</b>
            </span>
            <br>
            <span class="text-decoration-underline">
              <i>Total to pay: </i>
              <i v-text="setTotalToOrder()" />
              <i class="ms-1 fa-italic  fa-dollar-sign" />
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "CartOrderComp",
    props:{
      selectedItems: {
        type: Object,
        default() {
          return {  }
        }
      }
    },
    data(){
        return {
            sale: 1276,
            total: 0,
            delivery: 0
        }
    },
    methods: {
        setTotalQuantity() {
            let totalQty = 0;
            this.selectedItems.forEach((value)=>{
                totalQty+=value.quantity
            })
            return totalQty;
        },
        setTotalPriceForAll(){
            let total = 0;
            this.selectedItems.forEach((value)=>{
                total+=value.totalPrice
            })
            this.total = total;
            return total.toLocaleString('ru');
        },

        setTotalToOrder() {
            return (this.total-this.sale).toLocaleString('ru')
        }
    }

}
</script>

<style scoped>

.container-danger {
    border: 1px solid darkred !important;
}

.text-col-danger {
    color: darkred !important;
}

.container-success {
    border: 1px solid rgba(13,13,213,1) !important;
}

.fs-x-large {
    font-size: large;
}

.order-btn-color {
    background: rgba(16, 196, 76, 1);
    color: white;
}
</style>