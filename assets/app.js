import {createApp} from "vue";
import fakeStore from "./fakestore.vue";
import router from './routes/router.js'
import "./styles/app.css";
import 'bootstrap'
import {createPinia} from "pinia";
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import InputComp from "./Modules/Components/InputComp.vue";


const app = createApp(fakeStore);

app.config.warnHandler = function () {
	return null
}

app.component('InputComp', InputComp)

const store = createPinia();
store.use(piniaPluginPersistedstate)
app.use(router).use(store).mount('#fakestore')