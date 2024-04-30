import Vue from "vue";
import fakeStore from "./fakestore.vue";
import router from './routes/router.js'
import "./styles/app.css";
import store from "./store/store";
import 'bootstrap'
Vue.config.productionTip = false;
Vue.prototype.$log = console.log;     //debug log
Vue.prototype.$logt = console.table;  //debug log

let FakeStore = new Vue({
	el: "#fakestore",
	store: store,
	router: router,
	data() {
		return {
		};
	},
	beforeMount: function () {
	},
	render: function (h) {
		return h(fakeStore);
	},
})