<template>
  <div class="mt-4 container ">
    <div class="row">
      <div class="col-3">
        <div
          v-for="(value, index) in images"
          :key="`image-`+index"
          class="row mb-2"
        >
          <div
            class="btn button-hover"
            @click="setNewSlideIndex(index)"
          >
            <img
              :src="setCurrentImage(index)"
              class="img-fluid border-product-foto img-thumbnail"
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
import {mapGetters} from "vuex";

export default {
    name: "ProductImagesComp",
    props: [],
    data(){
        return {
            currentSlideIndex: 0
        }
    },
    computed: {
        ...mapGetters({
            images: 'getProductImages'
        }),
    },
    methods: {
        setCurrentMain() {
            let image = this.images[this.currentSlideIndex];
            return  image ? require (`../../img/` +this.images[this.currentSlideIndex].FileNameBase):'';
        },
        setCurrentImage(index) {
            return require (`../../img/` +this.images[index].FileNameBase);
        },
        setNewSlideIndex(index) {
           this.currentSlideIndex = index;
        }
    },
}
</script>

<style scoped>
.border-product-foto {
    border: 1px solid #e3e8ef;
    border-radius: 10px;
}

.button-selected {
    border: 2px solid rgba(13,13,213,1);
    border-radius: 10px;
}

</style>