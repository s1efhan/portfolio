<template>
  <div class="drehbuchAutor">
    <ul class="progress_nav">
      <li @click="isActive = 'expose'" :class="{ 'active': isActive === 'expose', 'inactive': isActive !== 'expose' }">
        Exposé
      </li>
      <li @click="isActive = 'treatment'" :class="{ 'active': isActive === 'treatment', 'inactive': isActive !== 'treatment' }">
        Treatment
      </li>
      <li @click="isActive = 'script'" :class="{ 'active': isActive === 'script', 'inactive': isActive !== 'script' }">
        Script
      </li>
    </ul>
  </div>
  <main>
    <Expose v-if="isActive === 'expose'"></Expose>
    <Treatment v-if="isActive === 'treatment'"></Treatment>
    <Drehbuch v-if="isActive === 'script'"></Drehbuch>
  </main>
</template>

<script setup>
import { ref } from 'vue';
import Expose from './drehbuch/Expose.vue';
import Treatment from './drehbuch/Treatment.vue';
import Drehbuch from './drehbuch/Drehbuch.vue';

const isActive = ref('expose');
</script>
