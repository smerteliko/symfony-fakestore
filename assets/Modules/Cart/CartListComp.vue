<template>
    <div class="container container-color  align-content-lg-start ">
        <table class="table table-collapse table-hover table-width " >
            <tbody class="" v-for="prod in this.cartListLS">
                <CartListItem :cart-item="prod"></CartListItem>
            </tbody>
        </table>
    </div>
</template>

<script>

import CartListItem from "./CartListItem.vue";

export default {
    name:'CartListComp',
    components: {CartListItem},
    props: ['cartListLS'],
    data(){
        return {
            cartList: this.cartListLS,

        }
    },
    beforeMount() {

    },
    computed: {

    },
    watch: {

    },
    methods:{ }
}
</script>

<style scoped>


.table-collapse {
    border-collapse: separate;
    border-spacing:0 20px;
}

.table-width {
    width: 55% !important;
}

</style>
