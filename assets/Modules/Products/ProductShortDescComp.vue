<template>
    <div class="mt-4 container container-color">
        <div class="row">
            <h4 class="product-description" v-text="this.product.Name"></h4>
            <small class="">
                <a
                    class="link-primary link-underline-opacity-100 text-decoration-none"
                   @click.prevent="scrollTo('#description')">
                    Description
                </a>
            </small>
        </div>
    </div>
</template>
<script>
export default {
    name: "ProductShortDescComp",
    props:['product'],
    methods:{
        scrollTo(selector) {
            document.querySelector(selector).scrollIntoView();
        }
    }
}
</script>

<style scoped>

</style>