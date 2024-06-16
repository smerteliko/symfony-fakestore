import {createApp} from "vue";
import fakeStore from "./fakestore.vue";
import router from './routes/router.js'
import "./styles/app.css";
import 'bootstrap'
import {createPinia} from "pinia";
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import InputComp from "./Modules/Components/InputComp.vue";
// DO NOT USE, HACK TO LOAD THIS COMPONENT ONCE, USE OWN SelectComp
import vSelect from 'vue-select';
// DO NOT USE, HACK TO LOAD THIS COMPONENT ONCE, USE OWN SelectComp
import fileUploader from "./Modules/Components/FileUploader.vue";


const app = createApp(fakeStore);

app.config.warnHandler = function () {
	return null
}
// DO NOT USE, HACK TO LOAD THIS COMPONENT ONCE, USE OWN SelectComp
app.component('SelectComp',vSelect)
// DO NOT USE, HACK TO LOAD THIS COMPONENT ONCE, USE OWN SelectComp

app.component('InputComp', InputComp)
app.component('FileUploader', fileUploader)


const store = createPinia();
store.use(piniaPluginPersistedstate)




app.use(router).use(store).mount('#fakestore')
