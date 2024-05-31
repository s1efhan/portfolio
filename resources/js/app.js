import { createApp } from 'vue';
import App from '../App.vue';
import App2 from '../App2.vue';
import router from "./router.js";

const app = createApp(App);
const app2 = createApp(App2); // Hier war "app2" klein geschrieben, es sollte jedoch "App2" sein.

app.use(router).mount('#app');
app2.use(router).mount('#app2'); // Hier wurde "app2" klein geschrieben, es sollte jedoch "app2" sein.
