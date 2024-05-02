<template>
    <div class="card bg-light  border-product-foto" style="width: 18rem;">
        <div class="card-header">
            <h5 class="card-title">
                {{ this.product.Name }}
            </h5>

        </div>

        <div class="card-body d-flex flex-wrap">
            <img :src="this.image" class="card-img-top border-product-foto img-thumbnail"
                 alt="No image">

            <span> {{ this.product.Description }}</span>
        </div>
        <div class="card-footer">
            <div class="d-flex  justify-content-between"
                >
                <div>
                    <h3> {{ this.product.totalPrice }}</h3>
                </div>
                <div v-if="this.product.quantity === 0">
                    <button class="btn btn-outline-danger"
                            @click="this.addItem">
                        Add to cart <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
                <div v-else  class="d-flex justify-content-end">
                    <div class="input-group input-group-sm input-width flex-nowrap ">
                        <button
                            class="btn btn-outline-danger border-end-0 border-radius"
                            type="button"
                            @click="removeQuantity()">
                            <i :class="{
                                    'fa-solid fa-minus' : this.product.quantity !== 1,
                                     'fa-regular fa-trash-can' : this.product.quantity === 1}" ></i>
                        </button>
                        <input class="form-control border border-end-0 border-start-0 border-input"
                               value="1"
                               min="1"
                               type="number"
                               disabled
                               v-model.number="this.product.quantity">
                        <button
                            class=" btn btn-outline-success border-start-0 border-radius"
                            type="button"
                            @click="addQuantity()">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductCardComp",
    props: ['product'],
    data() {
        return {
            image: this.checkImg() ? require(`../../img/` + this.checkImg()) : ''
        }
    },
    beforeCreate() {
        this.product['quantity'] = 0;
        this.product['totalPrice'] = this.product.price;
    },
    watch:{
    },

    methods: {
        addItem() {
            this.product.quantity += 1;
            this.$store.dispatch('addToCart', this.product);
        },
        checkImg() {
            if (this.product && this.product.productImages.length > 0) {
                return this.product.productImages[0].FileNameBase;
            }
            return '';
        },
        addQuantity() {
            this.product.quantity += 1;
            this.product.totalPrice = this.product.price * this.product.quantity;
            this.$store.dispatch('updateCartItemQuantity', this.product);
        },
        removeQuantity() {
            this.product.quantity -= 1;
            this.product.totalPrice = this.product.price * this.product.quantity;
            if(this.product.quantity === 0) {
                this.product.totalPrice = this.product.price;
                this.$store.dispatch('removeItemFromCart', this.product);
            } else {
                this.$store.dispatch('updateCartItemQuantity', this.product);
            }
        }
    },
}
</script>

<style scoped>
.border-product-foto {
    border: 1px solid #e3e8ef;
    border-radius: 10px;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    text-align: center;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
    text-align: center;
}

input:disabled{
    background: none;
}

.table-collapse {
    border-collapse: separate;
    border-spacing:0 20px;
}

.border-input {
    border-style: solid !important;
    border-image: linear-gradient(90deg, rgba(220,53,69,1) 0%, rgba(25,135,84,1) 100%) 1 !important;
}

.border-radius {
    border-radius: 20px
}

.input-width {
    width: 50% !important;
}


</style>