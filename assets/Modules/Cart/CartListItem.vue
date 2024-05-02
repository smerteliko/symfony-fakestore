<template>
    <tr class="d-flex tr-height">
        <td class="align-content-center">
            <img :src="this.image"
                 class="img-thumbnail"
                 width="100px"
                 height="100px"
                 alt="No image">
        </td>
        <td class="align-content-center col-3 ">
            <div
                class=" link-underline-opacity-100 text-decoration-none">
                <!--                            :to="{name: 'ProductComp', params:{id: prod.id}}"-->
                <h6 class="mb-0 text-decoration-underline">{{ this.item.Name }}</h6>
                <div class="product-description">
                    <small class="text-secondary"> {{this.item.Description}}</small>
                </div>
            </div>
        </td>
        <td class="align-content-center col-2">
            <div class="input-group input-group-sm flex-nowrap w-100 ">
                <button
                    class="btn btn-outline-danger border-end-0 border-radius"
                    type="button"
                    @click="removeQuantity()">
                    <i :class="{
                                    'fa-solid fa-minus' : this.item.quantity !== 1,
                                     'fa-regular fa-trash-can' : this.item.quantity === 1}" ></i>
                </button>
                <input class="form-control border border-end-0 border-start-0 border-input"
                       value="1"
                       min="1"
                       type="number"
                       disabled
                       v-model="this.item.quantity">
                <button
                    class=" btn btn-outline-success border-start-0 border-radius"
                    type="button"
                    @click="addQuantity()">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
        </td>
        <td class="align-content-center col-3">

            <h5 class="mb-0"> Total: {{this.item.totalPrice}} <i class="fa-solid fa-dollar-sign"></i></h5>
            <small class="text-secondary text-decoration-underline">
                <i> Per each: {{this.item.price}} </i>
                <i class="fa-italic  fa-dollar-sign"></i>
            </small>
            <p class="align-text-bottom mb-0"> Shipping: </p>

        </td>
        <td class="align-content-center col-1">
            <div class="form-check">
                <input type="checkbox"
                       class="form-check-input"
                       v-model="this.item.checked"
                >
            </div>
        </td>
    </tr>
</template>

<script>
export default {
    name: "CartListItem",
    props:["cartItem"],
    data() {
        return {
            item: this.cartItem,
            image: this.checkImg() ? require(`../../img/` + this.checkImg()) : '',
            checked: this.cartItem.checked

        }
    },
    computed: {
    },
    watch: {
        checked:{
            handler(newVal) {
                if(newVal === true) {
                    this.selected.push(this.item);
                }

                if (newVal === false) {
                    const index = this.selected.findIndex(item=>item.id === this.item.id);
                    this.selected.splice(index, 1);
                }
            }
        },
    },
    beforeMount() {
        this.item.totalPrice = this.item.price * this.item.quantity;
        this.item.checked = false;
    },
    methods: {
        checkImg() {
            if (this.cartItem && this.cartItem.productImages.length > 0) {
                return this.cartItem.productImages[0].FileNameBase;
            }
            return '';
        },

        addQuantity() {
            this.item.quantity += 1
            this.item.totalPrice = this.item.price * this.item.quantity;
            this.$store.dispatch('updateCartItemQuantity', this.item);
            this.$forceUpdate()

        },
        removeQuantity() {
            this.item.quantity -= 1;
            this.item.totalPrice = this.item.price * this.item.quantity;
            if(this.item.quantity === 0) {
                this.item.totalPrice = this.item.price;
                this.$store.dispatch('removeItemFromCart', this.item);
            } else {
                this.$store.dispatch('updateCartItemQuantity', this.item);
            }
            this.$forceUpdate()
        }
    }
}
</script>

<style scoped>
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

input[type=checkbox]
{
    /* Double-sized Checkboxes */
    -ms-transform: scale(1.5); /* IE */
    -moz-transform: scale(1.5); /* FF */
    -webkit-transform: scale(1.5); /* Safari and Chrome */
    -o-transform: scale(1.5); /* Opera */
    padding: 5px;
}

.tr-height {
    height: 120px;
}

.product-description {
    display: -webkit-box !important ;
    -webkit-line-clamp: 2 !important ;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    cursor: pointer !important;
}

.border-input {
    border-style: solid !important;
    border-image: linear-gradient(90deg, rgba(220,53,69,1) 0%, rgba(25,135,84,1) 100%) 1 !important;
}

.border-radius {
    border-radius: 20px
}
</style>