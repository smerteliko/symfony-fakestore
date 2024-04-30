<template>
    <div class="component container bg-light">
        <div class="container">
            <div class="row">
                <h1>{{ 'Cart' }}</h1>
            </div>
        </div>
        <CartListComp :cart-list-l-s="getCartItemsLS"></CartListComp>
    </div>
</template>

<script >
import CartListComp from "./CartListComp.vue";
import {mapGetters} from "vuex";

export default {
    name: 'CartComp',
    components: {CartListComp},
    computed: {
        ...mapGetters([
            'getCartItemsLS'
        ])
    }
}
</script>

<style scoped>

</style>