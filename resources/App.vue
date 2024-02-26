<!-- App.vue -->
<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';
import Login from './components/Login.vue';

// Refs für den Zustand der App
const isDarkMode = ref(false);
const loggedIn = ref(false);
const imageUrl = ref('');

// Funktion zum Umschalten zwischen Lightmode und Darkmode
function toggleDarkMode() {
  isDarkMode.value = !isDarkMode.value;
  document.body.classList.toggle('darkmode', isDarkMode.value);
}

// Funktion zum Überprüfen des eingeloggten Zustands beim Laden der App
onMounted(() => {
  if (sessionStorage.getItem('loggedIn')) {
    loggedIn.value = true;
  }

  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    toggleDarkMode(); // Darkmode aktivieren, falls bevorzugt
  }

  fetchImageUrl(); // Bild-URL abrufen
});

// Handler für den Login
const handleLogin = () => {
  loggedIn.value = true;
  sessionStorage.setItem('loggedIn', true);
};

// Funktion zum Abrufen der Bild-URL
async function fetchImageUrl() {
  try {
    const response = await axios.get('/api/get-image-url/lol.jpg'); // Passen Sie den Endpunkt entsprechend an
    imageUrl.value = response.data.url;
  } catch (error) {
    console.error('Fehler beim Abrufen der Bild-URL:', error);
  }
}
</script>

<template>
  <Menu v-if="loggedIn"></Menu>
  <router-view v-if="loggedIn"></router-view>
  <Footer v-if="loggedIn"></Footer>
  <Login v-else @login-success="handleLogin"></Login>
 
</template>
