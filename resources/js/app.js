

import axios from 'axios';
import {createApp} from 'vue'
import App from '../App.vue';
import router from "./router.js";
//import vuetify vielleicht später
// Vor jedem Routing prüfen, ob die Seite /impressum ist und das Meta-Tag hinzufügen


createApp(App).use(router).mount('#app');
