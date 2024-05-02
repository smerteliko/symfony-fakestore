export default {
	state: {
		cartItems: [],
		cartTotal: 0
	},
	mutations: {

		SET_CART_ITEMS_LS(state,value) {
			window.localStorage.setItem('cart', JSON.stringify(state.cartItems));

		},

		SET_NEW_CART_ITEMS(state, value) {
			state.cartItems.push(value);
		},

		SET_CART_TOTAL(state, value) {
			state.cartTotal += value;
		},

		REMOVE_ITEM(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value);
			state.cartItems.splice(index, 1);
		},

		SET_CART_ITEM_QUANTITY(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value.id);
			state.cartItems[index].quantity = value.quantity;
		},

		SET_ALL_CART_SELECTED(state, value) {
			state.cartItems.forEach((valueC, key)=>{
				valueC.checked = value;
			});
		}

	},
	actions: {
		addToCart({commit},item) {
			commit('SET_NEW_CART_ITEMS', item);
			commit('SET_CART_ITEMS_LS');
		},

		removeItemFromCart({commit}, item) {
			commit('REMOVE_ITEM', item.id)
			commit('SET_CART_ITEMS_LS');
		},

		updateCartItemQuantity({commit}, item) {
			if(item.quantity !== 0) {
				commit('SET_CART_ITEM_QUANTITY', item)
				commit('SET_CART_ITEMS_LS');
			} else {
				commit('REMOVE_ITEM', item)
				commit('SET_CART_ITEMS_LS');
			}

		},

		updateCartSelection({commit}, item) {
			commit('SET_ALL_CART_SELECTED', item)
			commit('SET_CART_ITEMS_LS');
		},

		calcCartTotal() {

		}
	},
	getters: {
		getCartItemsLS: (state) => {
			if(window.localStorage.getItem('cart')) {
				state.cartItems = JSON.parse(window.localStorage.getItem('cart'));
				return JSON.parse(window.localStorage.getItem('cart'));
			}
			return state.cartItems
		},
		// getCartTotalLS:(state)=>{
		// 	if(window.localStorage.getItem('total')) {
		// 		return JSON.parse(window.localStorage.getItem('total'));
		// 	}
		// 	return state.cartTotal;
		// },
		getCartTotal: (state) => { return state.cartTotal; },
		getCartItems:(state) => { return state.cartItems;},
	},
}