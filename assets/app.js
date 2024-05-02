import {createApp} from "vue";
import fakeStore from "./fakestore.vue";
import router from './routes/router.js'
import "./styles/app.css";
import store from "./store/store";
import 'bootstrap'

const app = createApp(fakeStore);

app.config.warnHandler = function (msg, vm, trace) {
	return null
}


app.use(router).use(store).mount('#fakestore')