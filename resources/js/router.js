import { createRouter, createWebHistory } from 'vue-router';
import Impressum from '../components/Impressum.vue';
import Datenschutz from '../components/Datenschutz.vue';
import Home from '../components/Home.vue';
import Kontakt from '../components/Kontakt.vue';
import Sitemap from '../components/Sitemap.vue';
import Lebenslauf from '../components/Lebenslauf.vue';
import Projekte from '../components/Projekte.vue';
import Login from '../components/Login.vue';
import Wissen from '../components/Wissen.vue';
import NichtGefunden from '../components/NichtGefunden.vue';
import ArticleView from '../components/ArticleView.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
      { name: 'article', path: '/medien/:category/:url', component: ArticleView },
      { path: '/software/:category/:url', component: ArticleView },
      { path: '/management/:category/:url', component: ArticleView },
      { path: '/impressum', component: Impressum, name: 'impressum' },
      { path: '/datenschutz', component: Datenschutz, name: 'datenschutz' },
      { path: '/', component: Home, name: 'home' },
      { path: '/kontakt', component: Kontakt, name: 'kontakt' },
      { path: '/sitemap', component: Sitemap, name: 'sitemap' },
      { path: '/lebenslauf', component: Lebenslauf, name: 'lebenslauf' },
      { path: '/wissen', component: Wissen, name: 'wissen' },
      { path: '/login', component: Login, name: 'login' },
      { path: '/projekte', component: Projekte, name: 'projekte' },
      { path: '/:catchAll(.*)', component: NichtGefunden, name: 'nichtgefunden' },
    ],
});

export default router;
