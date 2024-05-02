<template>
    <div class="component container bg-light vh-auto">
        <div class="container">
            <div class="row">
                <div class="col-5 d-flex justify-content-between align-items-center">
                    <div class="">
                        <h1>{{ 'Cart' }}</h1>
                    </div>

                </div>
                <div class="col-1 d-flex justify-content-between align-items-center">
                    <div class="pe-calc ">
                        <button class="btn"
                                @click="this.removeFromCart">
                            <i class="fs-x-large  fa-regular fa-trash-can" ></i>
                        </button>
                    </div>
                    <div class="pe-calc  pe-10px form-check">
                    <input class="pe-calc form-check-input" type="checkbox" v-model="this.checkedAll">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="container col">
                <CartListComp :cart-list-l-s=" this.cartItemList"></CartListComp>
            </div>
        </div>
    </div>
</template>

<script>
import CartListComp from "./CartListComp.vue";
import {mapGetters} from "vuex";

export default {
    name: 'CartComp',
    components: {CartListComp},
    data(){
        return {
            cartItemList: [],
            checkedAll: Boolean
        }
    },
    computed: {
        ...mapGetters([
            'getCartItemsLS'
        ]),
    },
    watch: {
        checkedAll: {
             handler(newVal) {
                 this.cartItemList.forEach((value)=>{
                     value.checked = newVal;
                 });
            }
        }
    },
    beforeMount() {
        this.cartItemList = this.getCartItemsLS;
        this.cartItemList.forEach((value)=>{
            value.checked = false;
            value.totalPrice = value.price * value.quantity;
        });
    },

    methods:{
        removeFromCart() {
            let indexes = [];
            this.cartItemList.forEach((value, key)=>{
                if(value.checked) {
                    this.$store.dispatch('removeItemFromCart', value);
                    indexes.push(key);
                }

            });
            indexes.sort(function(a,b){ return a-b; });
            for(let i = indexes.length -1; i >= 0; i--) {
                this.cartItemList.splice(indexes[i],1)
            }
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

.pe-10px {
    padding-right: 10px !important;
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