<template>
  <ul>
    <li>Lol</li>
    <!-- Dynamisch generierte Breadcrumb-Links -->
    <li v-for="(crumb, index) in breadcrumbs" :key="index">
      <a :href="crumb.route">{{ crumb.label }}</a>
    </li>
  </ul>
</template>

<script>
import { computed } from 'vue';

export default {
  setup() {
    const breadcrumbs = computed(() => {
      // Holen Sie sich die Segmente der aktuellen Route
      const segments = this.$route.value.path.split('/').filter(segment => segment !== '');

      // Erstellen Sie ein Array von Breadcrumbs mit ihren Routen und Labels
      return segments.map((segment, index) => ({
        label: segment.charAt(0).toUpperCase() + segment.slice(1), // Erste Buchstabe groß
        route: `/${segments.slice(0, index + 1).join('/')}` // Konstruiere die Route bis zum aktuellen Segment
      }));
    });

    return { breadcrumbs };
  }
};
</script>
