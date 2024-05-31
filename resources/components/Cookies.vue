<template>
  <div class="Cookie-Banner">
    <h2>Cookie-Einstellungen </h2>
    <div>
      <div class="notwendige-cookies">
        <label>Notwendige Cookies</label>
        <input type="checkbox" checked disabled />
        <input type="hidden" />
      </div>
      <div class="statistik-cookies">
        <label>Statistik Cookies</label>
        <input type="checkbox" v-model="allowStatisticCookies" />
      </div>
    </div>
    <div class="buttons-cookies">
      <button @click="saveCookies(allowStatisticCookies ? 'allow-all' : 'allow-necessary')" class="accent-button">Speichern</button>
      <button @click="saveCookies('allow-all')" class="primary-button">Alle akzeptieren</button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import axios from "axios";
const emit = defineEmits(['save-cookies']);
const props = defineProps({
  showCookies: Boolean,
  cookiePreferences: Object,
  cookieData: String
});

const showCookies = ref(props.showCookies);
const allowStatisticCookies = ref(false);

const saveCookies = (preferences) => {
  console.log("Cookie Präferenzen aktualisiert", preferences);
  emit('save-cookies');
  axios.post('/save-cookies', {
    preferences: preferences
  })
  .catch(error => {
    console.log(error);
  });
  // Cookie Status abrufen in der Elternkomponente
}

watch(() => props.cookiePreferences, (newValue) => {
  allowStatisticCookies.value = newValue?.preferences === 'allow-all';
});
</script>