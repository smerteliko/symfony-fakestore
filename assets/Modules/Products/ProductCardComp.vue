<template>
    <div class="card bg-light  border-product-foto w-18rem">
        <div class="card-header">
            <h5 class="card-title">
                {{ this.product.Name }}
            </h5>
        </div>

        <div class="card-body d-flex flex-wrap">
            <img :src="this.image"
                 class="card-img-top border-product-foto img-thumbnail"
                 alt="No image">

            <span> {{ this.product.Description }}</span>
        </div>
        <div class="card-footer">
            <div class="d-flex  justify-content-between">
                <div>
                    <h3> {{ this.product.price }}</h3>
                </div>
                <div>
                    <button class="btn btn-outline-danger"
                            :class="this.product.quantity !== 0 ? 'disabled':''"
                            @click="this.addItem">
                        Add to cart <i class="fa-solid fa-cart-plus"></i>
                    </button>
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
            image: this.checkImg() ? require(`../../img/` + this.checkImg()) : '',
            quantity: this.product.quantity,
        }
    },
    beforeCreate() {
    },
    watch:{
    },

    methods: {
        addItem() {
            this.$store.dispatch('addToCart', this.product);
            this.quantity++;
        },
        checkImg() {
            if (this.product && this.product.productImages.length > 0) {
                return this.product.productImages.find(
                    (value)=>{
                        return value.Main === true;
                    }
                    ).FileNameBase;
            }
            return '';
        },
    }
}
</script>

<style scoped>
.w-18rem {
    width: 18rem;
}
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