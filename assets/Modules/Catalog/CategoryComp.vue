<template>
  <div class="component container bg-light container-color">
    <div class="container">
      <div class="row">
        <h1>{{ catData.Name }}</h1>
      </div>
    </div>
    <div class="container container-color d-flex">
      <div class="container m-0 w-25 border-left-panel ">
        <ul
          v-for="subCat in catData.subCategories"
          :key="subCat.Name"
          class="list-group list-group-flush border-left-panel mb-2 mt-2"
        >
          <button
            class="list-group-item
                               list-group-item-action btn"
            :class="{'active' : subCat.id === active}"
            @click="changeSubCat(subCat.id)"
          >
            {{ subCat.Name }}
          </button>
        </ul>
      </div>
      <div class="container container-color m-0 w-75 d-flex flex-wrap">
        <div class="container w-100">
          <div class="row">
            <h5 class="col">
              Total: <small>{{ total }} items found</small>
            </h5>
          </div>
        </div>
        <div class="container">
          <div v-if="loading">
            <div class="d-flex justify-content-center">
              <div
                class="spinner-border"
                role="status"
              >
                <span class="visually-hidden">Загрузка...</span>
              </div>
            </div>
          </div>
          <div
            v-else
            class=" mb-2 mt-1 card-group"
          >
            <ProductListComp :product-list="productsList" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";
import ProductListComp from "../Products/ProductsListComp.vue"

export default {
    name: "CategoryComp",
    components: {ProductListComp},
     beforeRouteUpdate(to,) {
         this.setInitialData(to.params)
    },
    data(){
        return {
            catData: {},
            productsList: {},
            loading: true,
            total: 0,
            active: Number
        }
    },
    computed: {
        ...mapGetters([
            'getCategoryData' ,
            'getProductListByCat',
            'getProductListBySubCat'
        ]),
    },
    beforeMount() {
        this.setInitialData(this.$route.params);
    },
    methods: {
        async changeSubCat(subID) {
            this.loading = true;

            await this.$store.dispatch('fetchProductListBySubCat', subID);
            this.productsList = this.$store.getters.getProductListBySubCat;
            this.active = parseInt(subID);
            this.total = this.productsList.length;

            this.loading = false;
        },

        async setInitialData(params){
            this.loading = true
            await this.$store.dispatch('fetchCategoryData', params.catID);
            await this.$store.dispatch('fetchProductListByCat', params.catID);
            this.productsList = this.$store.getters.getProductListByCat;

            if(params.subID) {
                await this.$store.dispatch('fetchProductListBySubCat', params.subID);
                this.productsList = this.$store.getters.getProductListBySubCat;
                this.active = parseInt(params.subID);
            }


            this.catData = this.$store.getters.getCategoryData;

            this.total = this.productsList.length;
            this.loading = false;
        }
    },

}
</script>

<style scoped>
.border-left-panel{
    border: 1px solid #e3e8ef;
    border-radius: 8px;
}
</style>