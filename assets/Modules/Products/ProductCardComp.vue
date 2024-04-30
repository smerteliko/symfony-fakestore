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
            <div class="d-flex"
                 :class="{
                    'flex-wrap':this.product.quantity > 0,
                     'justify-content-between': this.product.quantity ===0
                }">
                <div>
                    <h3> {{ this.product.totalPrice }}</h3>
                </div>
                <div v-if="this.product.quantity === 0">
                    <button class="btn btn-outline-danger"
                            @click="this.addItem">
                        Add to cart <i class="fa-solid fa-cart-plus"></i>
                    </button>
                </div>
                <div v-else>
                    <div class="input-group quantity-selector">
                        <button
                            class="btn btn-outline-danger"
                            type="button"
                            @click="this.removeQuantity">
                                <i class="fa-solid fa-minus"></i>
                        </button>
                        <input class="form-control border-dark"
                               value="1"
                               min="1"
                               type="number"
                               v-model.number="product.quantity">
                        <button
                            class=" btn btn-outline-success "
                            type="button"
                            @click="this.addQuantity">
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
    props: ['ProductData'],
    data() {
        return {
            product: this.ProductData,
            image: this.checkImg() ? require(`../../img/` + this.checkImg()) : ''
        }
    },
    beforeMount() {
        this.$set(this.product, 'quantity', 0);
        this.$set(this.product, 'totalPrice', this.product.price);
    },
    watch:{
    },

    methods: {
        addItem() {
            this.product.quantity += 1;
            this.$store.dispatch('addToCart', this.product);
        },
        checkImg() {
            if (this.ProductData.productImages.length > 0) {
                return this.ProductData.productImages[0].FileNameBase;
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
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>