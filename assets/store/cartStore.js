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

		SET_CART_ITEMS(state, value) {
			state.cartItems = value;
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
		},

		SET_ALL_CART_UNSELECTED(state, value) {
			state.cartItems.forEach((valueC, key)=>{
				valueC.checked = value;
			});
		},

		SET_CART_ITEM_SELECTED(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value.item.id);
			state.cartItems[index].checked = value.checked;
		},

		ADD_CART_ITEM_QUANTITY(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value.id);
			state.cartItems[index].quantity++;
		},
		REMOVE_CART_ITEM_QUANTITY(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value.id);
			state.cartItems[index].quantity--;
		},

		SET_CART_ITEM_TOTAL(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value.id);
			state.cartItems[index].totalPrice = state.cartItems[index].price * state.cartItems[index].quantity;
		},
		SET_CART_ITEM_FIXED_PRICE(state, value) {
			const index = state.cartItems.findIndex(item=>item.id === value.id);
			state.cartItems[index].totalPrice = state.cartItems[index].price;
		},

		REMOVE_SELECTED_CART_ITEM(state, value) {
			state.cartItems.splice(value,1);
		}

	},
	actions: {
		addToCart({commit},item) {
			commit('SET_NEW_CART_ITEMS', item);
			commit('ADD_CART_ITEM_QUANTITY', item);
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

		addCartItemQuantity({commit}, item){
			commit('ADD_CART_ITEM_QUANTITY', item);
			commit('SET_CART_ITEM_QUANTITY', item)
			commit('SET_CART_ITEMS_LS');
		},
		removeCartItemQuantity({commit}, item){
			commit('REMOVE_CART_ITEM_QUANTITY', item);
			commit('SET_CART_ITEM_QUANTITY', item)
			commit('SET_CART_ITEMS_LS');
		},

		updateCartItemSelection({commit}, item) {
			commit('SET_CART_ITEM_SELECTED', item);
			//commit('SET_CART_ITEMS_LS');
		},

		updateCartListFromLS({commit}, item) {
			commit('SET_CART_ITEMS',JSON.parse(window.localStorage.getItem('cart')))
		},

		removeSelectedCartItems({commit}, items) {
			items.sort(function(a,b){ return a-b; });
			for(let i = items.length -1; i >= 0; i--) {
				commit('REMOVE_SELECTED_CART_ITEM',items[i]);
			}
			commit('SET_CART_ITEMS_LS');
		},
	},
	getters: {
		getCartItemsLS: (state) => {
			if(window.localStorage.getItem('cart')) {
				return JSON.parse(window.localStorage.getItem('cart'));
			}
		},

		getCartTotal: (state) => {
			return state.cartTotal;
		},
		getCartItems:(state) => {
			return state.cartItems;
		},
	},
}