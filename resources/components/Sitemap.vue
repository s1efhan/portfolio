<template>
  <main>
    <h1>Sitemap</h1>
    <ul v-for="(category, categoryName) in categorizedRoutes" :key="categoryName">
      <template v-if="category.length > 1">
        <h2>{{ categoryName.charAt(0).toUpperCase() + categoryName.slice(1) }}</h2>
      </template>
      <li v-for="(route, index) in category" :key="index">
        <router-link :to="route.path">{{ formatRouteLabel(route.path) }}</router-link>
      </li>
    </ul>
  </main>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  setup() {
    const categorizedRoutes = categorizeRoutes();

    function categorizeRoutes() {
      const router = useRouter();
      const categorizedRoutes = {};

      router.options.routes.forEach(route => {
        if (route.path !== "/") {
          const pathParts = route.path.split('/').filter(part => part !== '');
          const categoryName = pathParts[0];
          if (!categorizedRoutes[categoryName]) {
            categorizedRoutes[categoryName] = [];
          }
          categorizedRoutes[categoryName].push(route);
        }
      });

      return categorizedRoutes;
    }

    function formatRouteLabel(path) {
      const parts = path.split('/');
      const label = parts.length > 1 ? parts.slice(-1)[0] : parts[0];
      return label.charAt(0).toUpperCase() + label.slice(1);
    }

    return { categorizedRoutes, formatRouteLabel };
  },
};
</script>
