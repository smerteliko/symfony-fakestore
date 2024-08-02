<template>
  <div
    v-show="this.productCh"
    class="hr mt-2 mb-2"
  />
  <div
    v-show="this.productCh"
    class="mt-4 container container-color"
  >
    <div class="row mb-4">
      <h3>Characteristics </h3>
    </div>
    <div class="row">
      <div
        v-for="(group, groupName, index) in this.productCh"
        :key="`char-group-name-`+ groupName"
        class="pb-4"
      >
        <div class="d-flex flex-wrap ms-2">
          <h5
            class="char-header w-100"
            :class="index === 0 ? 'mt-0':''"
            v-text="groupName"
          />
          <div
            v-for="(chValue, chName) in group"
            :key="`char-name-`+ chName"
            class="col-6 ps-2 "
          >
            <div class="d-flex pb-2 pt-2 col-6 justify-content-between charact-border-bot">
              <small>{{ chName }}</small>
              <small>{{ chValue }}</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "ProductCharacteristicComp",
    props:{
      productCharacteristic: {
        type: Object,
        default() {
          return {}
        }
      }
    },
  computed:{
    productCh() {
      return this.productCharacteristic? this.productCharacteristic.data : {}
    }
  }
}
</script>



<style scoped>
.charact-border-bot {
  border-bottom: .5px dotted rgba(13,13,213,1) !important;

}
</style>