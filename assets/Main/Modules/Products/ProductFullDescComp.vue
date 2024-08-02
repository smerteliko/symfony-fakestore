<template>
  <div 
    v-show="this.descText" 
    class="hr mt-2 mb-2"
  />
  <div
    v-show="this.descText"
    id="description"
    class="mt-4 container"
  >
    <div class="row mb-4">
      <h3>Description </h3>
    </div>
    <div class="row">
      <div class="col-10">
        <small><span v-text="this.descText" /></small>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    name: "ProductFullDescComp",
    props:{
      productDesc: Text,

    },
    data(){
        return {

        }
    },
    computed:{
      descText() {
        return this.productDesc ? this.productDesc.FullDescription:''
      }
    }
}
</script>

<style scoped>

</style>