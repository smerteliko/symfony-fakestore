<template>
    <div class="container container-color w-50">
        <div class="d-flex" v-for="prod in cartList">
            <img :src="checkImg(prod)"
                 class="img-thumbnail"
                 width="100px"
                 height="100px"
                 alt="No image">
            <h5 class="align-content-center">{{ prod.Name }}</h5>
            <div class="input-group quantity-selector">
                <button
                    class="btn btn-outline-danger"
                    type="button"
                    @click="removeQuantity(prod)">
                    <i class="fa-solid fa-minus"></i>
                </button>
                <input class="form-control border-dark"
                       value="1"
                       min="1"
                       type="number"
                       v-model.number="prod.quantity">
                <button
                    class=" btn btn-outline-success "
                    type="button"
                    @click="addQuantity(prod)">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name:'CartListComp',
    props: ['cartListLS'],
    data(){
        return {
            cartList: this.cartListLS
        }
    },
    computed: {

        quantity(prod) {
            console.log(prod)
            return this.cartList.quantity;
        }
    },
    watch: {
        'cartList': {
            handler(v){
                console.log(v)
            },
            deep:true
        }

    },
    methods:{
        checkImg(product) {
            if (product.productImages.length > 0) {
                return require(`../../img/` + product.productImages[0].FileNameBase)
            }
            return '';
        },

        addQuantity(prod) {
            console.log()
            prod.quantity += 1
            prod.totalPrice = prod.price * prod.quantity;
            this.$store.dispatch('updateCartItemQuantity', prod);this.$forceUpdate()

        },
        removeQuantity(prod) {
            prod.quantity -= 1;
            prod.totalPrice = prod.price * prod.quantity;
            if(prod.quantity === 0) {
                prod.totalPrice = prod.price;
                this.$store.dispatch('removeItemFromCart', prod);
            } else {
                this.$store.dispatch('updateCartItemQuantity', prod);
            }
            this.$forceUpdate()
        }
    }
}
</script>

<style scoped>

</style>