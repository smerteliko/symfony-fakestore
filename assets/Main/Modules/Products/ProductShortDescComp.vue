<template>
  <div class="mt-4 container">
    <div class="row">
      <h4
        class="product-description"
        v-text="this.productName"
      />
    </div>
    <div
      v-show="this.productBriefDesc" 
      class="row"
    >
      <div class="col-8 product-description">
        <h6
          v-text="this.productBriefDesc"
        />
      </div>
      <div class="col-4">
        <small class="">
          <button
            class="active rounded-pill btn-xs
                    text-decoration-none"
            @click.prevent="scrollTo('#description')"
          >
            Description <i class="fa-solid fa-arrow-right" />
          </button>
        </small>
      </div>
    </div>
    <div
      v-show="this.productCharacteristic"
      class="row mt-3 border-1 border-black"
    >
      <div class="row">
        <h5>Characteristics:</h5>
      </div>
      <div
        v-for="(value, key, index) in this.productCharacteristic"
        :key="`characteristic-`+key"
        class="row pb-2 pt-2 ms-0"
        :class="index !== 0 ? 'charact-border-top':''"
      >
        <div class="col d-flex ">
          {{ key }}
        </div>
        <div class="col">
          {{ value }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    name: "ProductShortDescComp",
    props: {
      product: {
        type: Object,
        default() {
          return {  };
        }
      }
    },
    data(){
      return {
      };
    },
    computed:{
      productName() {
        return this.product.Name;
      },
      productBriefDesc() {
       return  this.product.productDescription ?
         this.product.productDescription.BriefDesc: '';
      },
      productCharacteristic() {
        return this.product.productCharacteristic ?
          this.product.productCharacteristic.data.Base:''
      },
    },
    methods:{
        scrollTo(selector) {
            document.querySelector(selector).scrollIntoView();
        },
    }
}
</script>

<style scoped>

.charact-border-top {
  border-top: .5px solid rgba(13,13,213,1) !important;
}

.product-description {
  display: -webkit-box !important ;
  -webkit-line-clamp: 2 !important ;
  -webkit-box-orient: vertical !important;
  overflow: hidden !important;
  text-overflow: ellipsis !important;
  cursor: pointer !important;
}
</style>