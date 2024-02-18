
import('./bootstrap.js');

import {createApp} from 'vue'

import App from '../App.vue';
import router from "./router.js";
// Vor jedem Routing prüfen, ob die Seite /impressum ist und das Meta-Tag hinzufügen

router.beforeEach((to, from, next) => {
  const metaTag = document.createElement('meta');
  metaTag.setAttribute('name', 'robots');
  metaTag.setAttribute('content', 'noindex');

  if (to.path === '/impressum') {
    document.head.appendChild(metaTag);
  } else {
    const existingMetaTag = document.querySelector('meta[name="robots"]');
    if (existingMetaTag) {
      document.head.removeChild(existingMetaTag);
    }
  }

  

  next();
});

createApp(App).use(router).mount('#app');