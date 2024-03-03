//router.js
import { createRouter, createWebHistory } from 'vue-router';
import Impressum from '../components/Impressum.vue';
import Datenschutz from '../components/Datenschutz.vue';
import Home from '../components/Home.vue';
import Wissen from '../components/Wissen.vue';
import Projekte from '../components/Projekte.vue';
import Kontakt from '../components/Kontakt.vue';
import Lebenslauf from '../components/Lebenslauf.vue';
import Login from '../components/Login.vue';
import Sitemap from '../components/Sitemap.vue';
const router = createRouter({
    history: createWebHistory(),
    routes: [
      { path: '/', component: Home },
      { path: '/impressum', component: Impressum },
      { path: '/datenschutz', component: Datenschutz },
      { path: '/wissen', component: Wissen },
      { path: '/sitemap', component: Sitemap },
      { path: '/kontakt', component: Kontakt },
      { path: '/projekte', component: Projekte },
      { path: '/wissen/medien', component: Wissen },
      { path: '/login', component: Login },
      { path: '/lebenslauf', component: Lebenslauf}
    ],
  });
  export default router;