<template>
  <div class="mt-4 container ">
    <div class="row">
      <div class="col-3">
        <div
          v-for="(value, index) in productImages"
          :key="`image-`+index"
          class="row mb-2"
        >
          <div
            class="btn button-hover"
            @click="setNewSlideIndex(index)"
          >
            <img
              :src="setCurrentImage(index)"
              class="img-fluid border-1-solid-white border-product-foto img-thumbnail"
              :class="index === currentSlideIndex ? 'button-selected':'' "
              alt="No image"
            >
          </div>
        </div>
      </div>
      <div class="col-9">
        <div class="row">
          <img
            :src="setCurrentMain(currentSlideIndex)"
            class="img-fluid border-product-foto img-thumbnail"
            alt="No image"
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>


export default {
    name: "ProductImagesComp",
    props:{
        productImages: {
          type: Object,
          default() {
            return {}
          }
      }
    },
    data(){
        return {
            currentSlideIndex: 0
        }
    },
    computed: {
    },
    methods: {
        setCurrentMain() {
            let image = this.productImages[this.currentSlideIndex];
            return  image ? require (`../../../img/products/` +this.productImages[this.currentSlideIndex].FileNameBase):'';
        },
        setCurrentImage(index) {
            return require (`../../../img/products/` +this.productImages[index].FileNameBase);
        },
        setNewSlideIndex(index) {
           this.currentSlideIndex = index;
        }
    },
}
</script>

<style scoped>
.border-product-foto {
    border-radius: 10px;
}

.button-selected {
    border: 2px solid rgba(13,13,213,1);
    border-radius: 10px;
}

</style>