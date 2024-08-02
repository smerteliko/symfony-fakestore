import {defineStore} from "pinia";
import {useUserStore} from "../../store/userStore";

export const useCartStore = defineStore('cart', {
	state: () => {
		return {
			cartItems: [],
			cartTotal: 0,
			selectedCartItems: []
		};
	},
	actions: {
		addToCart( item) {
			this.cartItems.push(item)

			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
 			this.cartItems[index].quantity++;
			this.setCartItemsLS();
		},

		removeItemFromCart(item) {
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
 			this.cartItems.splice(index, 1);
			this.setCartItemsLS();
		},


		addCartItemQuantity(item){
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
			this.cartItems[index].quantity++;
			this.setCartItemsLS();
		},
		removeCartItemQuantity(item){
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
			this.cartItems[index].quantity--;
			this.setCartItemsLS();
		},

		updateCartItemsSelection(item) {
			this.cartItems.forEach((valueC)=>{
 				valueC.checked = item;
 			});
		},

		updateCartItemSelection(item, checked) {
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
			this.cartItems[index].checked = checked;
		},

		updateCartListFromLS() {
			this.cartItems = JSON.parse(window.localStorage.getItem('cart'));
		},
		setCartItemsLS() {
			window.localStorage.setItem('cart', JSON.stringify(this.cartItems));
		},

		removeSelectedCartItems(items) {
			items.sort(function(a,b){ return a-b; });
			for(let i = items.length -1; i >= 0; i--) {

				this.cartItems.splice(items[i], 1);
	 		}
			this.setCartItemsLS();
		},

		getCartItemPrice(item) {
			const userStore = useUserStore();
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
			let price = this.cartItems[index].productPrice.ConvertedPrice[840];
			if(userStore.currencyID) {
				price = this.cartItems[index].productPrice.ConvertedPrice[userStore.currencyID]
			}
			return price;
		},

		setCartItemsTotal(item) {
			const userStore = useUserStore();
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);
			let price = this.cartItems[index].productPrice.ConvertedPrice[840];
			if(userStore.currencyID) {
				price = this.cartItems[index].productPrice.ConvertedPrice[userStore.currencyID]
			}

			this.cartItems[index].totalPrice =
					(price * this.cartItems[index].quantity).toFixed(2);

		}
	},
	getters: {
		getCartItemsLS(){
			if(window.localStorage.getItem('cart')) {
				return JSON.parse(window.localStorage.getItem('cart'));
			}
		},
		getCheckedCartItems() {
			let checked = [];
			this.cartItems.forEach((value)=>{
				if(value.checked) {
					checked.push(value);
				}
			})
			return checked;
		},
		getCartTotalItems() {
			return this.cartItems.length;
		},
		getCartTotal() {
			return this.cartTotal;
		},
		getCartItems() {
			return this.cartItems;
		},
	},
});