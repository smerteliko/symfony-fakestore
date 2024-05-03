<template>
    <div class="container container-color  align-content-lg-start ">
        <table class="table table-collapse table-hover " >
            <tbody class="" v-for="prod in this.cartList">
                <CartListItem :cart-item="prod" :key="`cart-list-item-`+prod.id"></CartListItem>
            </tbody>
        </table>
    </div>
</template>

<script>

import CartListItem from "./CartListItem.vue";

export default {
    name:'CartListComp',
    components: {CartListItem},
    props: ['cartList'],
    data(){
        return {
            cartList: this.cartList,

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
