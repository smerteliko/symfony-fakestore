import Vue from "vue";
import fakeStore from "./fakestore.vue";
import router from './routes/router.js'
import "./styles/app.css";
import store from "./store/store";

Vue.config.productionTip = false;
Vue.prototype.$log = console.log;     //debug log
Vue.prototype.$logt = console.table;  //debug log

let FakeStore = new Vue({
	el: "#fakestore",
	store: store,
	router: router,
	data() {
		return {
			dataObject: {},
			csrf_token: "",
			lastUser: "",
		};
	},
	beforeMount: function () {
	// this.dataObject = JSON.parse(
	// 		this.$el.attributes["data-dataObject"].value
	// );
	// this.csrf_token = this.$el.attributes["data-token"].value;
	// this.lastUser = this.$el.attributes["data-lastUser"].value;
	},
	render: function (h) {
		return h(fakeStore);
	},
})