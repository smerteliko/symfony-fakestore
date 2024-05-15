<template>
  <div class="mt-4 container">
    <div class="row">
      <h4
        class="product-description"
        v-text="product.Name"
      />
      <small class="">
        <a
          class="link-primary link-underline-opacity-100 text-decoration-none"
          @click.prevent="scrollTo('#description')"
        >
          Description
        </a>
      </small>
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
          return {  }
        }
      }
    },
    methods:{
        scrollTo(selector) {
            document.querySelector(selector).scrollIntoView();
        }
    }
}
</script>

<style scoped>

</style>