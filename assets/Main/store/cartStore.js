import {defineStore} from "pinia";
import {useUserStore} from "../../store/userStore";
import {useJSONStore} from "../../store/jsonStore";

export const useCartStore = defineStore('cart', {
	state: () => {
		return {
			cartItems: [],
			cartTotal: 0,
			selectedCartItems: [],
			userStore: useUserStore(),
			jsonlistStore: useJSONStore()
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
			this.cartItems = this.getCartItemsLS;
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
			return this.convertPrice(this.cartItems.findIndex(lsItem=>lsItem.id === item.id));
		},

		setCartItemsTotal(item) {
			const index = this.cartItems.findIndex(lsItem=>lsItem.id === item.id);

			this.cartItems[index].totalPrice =
					(this.convertPrice(index) * this.cartItems[index].quantity).toFixed(2);

		},

		convertPrice(itemIndex) {
			let price = this.cartItems[itemIndex].productPrice.ConvertedPrice[840];
			if(this.userStore.currencyID) {
				price = this.cartItems[itemIndex].productPrice.ConvertedPrice[this.userStore.currencyID]
			}
			return price
		},
		getPriceCurrencySymbol() {
			const findCurrency = this.jsonlistStore.currencies.find((item)=>{
				return item.IsoCode === (this.userStore.currencyID ? this.userStore.currencyID : '840')
			})
			return findCurrency?findCurrency.Symbol:'';
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
			if(this.cartItems.length) {
				this.cartItems.forEach((value)=>{
					if(value.checked) {
						checked.push(value);
					}
				});
			}
			return checked;
		},
		getCartTotalItems() {
			return this.cartItems?this.cartItems.length:[];
		},
		getCartTotal() {
			return this.cartTotal;
		},
		getCartItems() {
			return this.cartItems;
		},
	},
});