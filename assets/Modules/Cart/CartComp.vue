<template>
    <div class="component container bg-light vh-auto">
        <div class="container">
            <div class="row">
                <div class="col-5 d-flex justify-content-between align-items-center">
                    <div class="ms-4">
                        <h1>{{ 'Cart' }}</h1>
                    </div>

                </div>
                <div class="col-2 d-flex justify-content-center align-items-center">
                    <div class="pe-calc ">
                        <button class="btn"
                                @click="this.removeFromCart">
                            <i class="fs-x-large icon-color  fa-regular fa-trash-can" ></i>
                        </button>
                    </div>
                    <div class="pe-calc  pe-40px form-check">
                    <input class="pe-calc form-check-input" type="checkbox" v-model="this.checkedAll">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container col-7">
                <CartListComp :cart-list=" this.cartItemsList"></CartListComp>
            </div>
            <div class="container col-4">
                <CartOrderComp :selected-items="this.getCheckedCartItems"></CartOrderComp>
            </div>
        </div>
    </div>
</template>

<script>
import CartListComp from "./CartListComp.vue";
import {mapGetters} from "vuex";
import CartOrderComp from "./CartOrderComp.vue";

export default {
    name: 'CartComp',
    components: {CartOrderComp, CartListComp},
    data(){
        return {
            cartItemsList: [],
            checkedAll: Boolean
        }
    },
    computed: {
        ...mapGetters([
            'getCartItems',
            'getCheckedCartItems'
        ]),
    },
    watch: {
        checkedAll: {
             handler(newVal) {
                 this.$store.commit('SET_ALL_CART_SELECTED', newVal)
            }
        }
    },
    beforeMount() {
        this.$store.dispatch('updateCartListFromLS');
        this.$store.commit('SET_ALL_CART_UNSELECTED', false);
        this.cartItemsList = this.$store.getters.getCartItems;
    },

    methods:{
        removeFromCart() {
            let indexes = [];
            this.cartItemsList.forEach((value, key)=>{
                if(value.checked) {
                    indexes.push(key);
                }

            });
           this.$store.dispatch('removeSelectedCartItems',indexes)
        }
    },
}
</script>

<style scoped>
.vh-auto {
    height: auto;
}

.pe-calc {
    padding-right: calc(2rem* 0.5);

}

.pe-40px {
    padding-right: 40px !important;
}

.fs-x-large {
    font-size: x-large;
}

input[type=checkbox]
{
    /* Double-sized Checkboxes */
    -ms-transform: scale(1.5); /* IE */
    -moz-transform: scale(1.5); /* FF */
    -webkit-transform: scale(1.5); /* Safari and Chrome */
    -o-transform: scale(1.5); /* Opera */
    padding: 5px;
}
</style>