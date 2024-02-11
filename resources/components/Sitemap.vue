<template>
  <main>
      <h1>Sitemap</h1>
      <ul v-for="(category, categoryName) in categorizedRoutes" :key="categoryName">
        <template v-if="category.length > 1">
          <h2>{{ categoryName.charAt(0).toUpperCase() + categoryName.slice(1) }}</h2>
        </template>
        <li v-for="(route, index) in category" :key="index">
          <router-link :to="route.path">{{ (route.path.includes('/') ? (route.path.indexOf('/', route.path.indexOf('/') + 1) !== -1 ? route.path.slice(route.path.indexOf('/', route.path.indexOf('/') + 1) + 1).charAt(0).toUpperCase() + route.path.slice(route.path.indexOf('/', route.path.indexOf('/') + 1) + 2) : route.path.replace('/', '')) : route.path).charAt(0).toUpperCase() + (route.path.includes('/') ? (route.path.indexOf('/', route.path.indexOf('/') + 1) !== -1 ? route.path.slice(route.path.indexOf('/', route.path.indexOf('/') + 1) + 1) : route.path.replace('/', '')) : route.path).slice(1) }}</router-link>
        </li>
      </ul>
    </main>
  </template>
  
  
  <script>
import router from "../js/router.js";
  
  export default {
    data() {
      return {
        categorizedRoutes: {},
      };
    },
    created() {
      this.categorizeRoutes();
    },
    methods: {
  categorizeRoutes() {
    router.options.routes.forEach(route => {
      if (route.path !== "/") {
        const pathParts = route.path.split('/').filter(part => part !== '');
        const categoryName = pathParts[0];
        if (!this.categorizedRoutes[categoryName]) {
          this.categorizedRoutes[categoryName] = [];
        }
        this.categorizedRoutes[categoryName].push(route);
      }
    });
  },
},

  };
  </script>
  