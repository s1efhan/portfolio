<!-- App.vue -->
<script setup>
import { ref, onMounted } from 'vue';
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';
const isDarkMode = ref(false); // Initialer Wert für Darkmode
import Login from './components/Login.vue';

// Funktion zum Umschalten zwischen Lightmode und Darkmode
function toggleDarkMode() {
  isDarkMode.value = !isDarkMode.value;
  document.body.classList.toggle('darkmode', isDarkMode.value);
}
onMounted(() => {
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    // User prefers dark mode
    toggleDarkMode();

    //prüfen ob User eingeloggt ist (session)
  }
});
const loggedIn = ref(false);

onMounted(() => {

    if (sessionStorage.getItem('loggedIn')) {
        loggedIn.value = true;
    }
});

const handleLogin = () => {
    loggedIn.value = true;
    sessionStorage.setItem('loggedIn', true);
};
</script>
<template>
  <Menu  v-if="loggedIn"></Menu> <!-- Umschalten je nachdem ob Nutzer eingeloggt ist-->
  <router-view  v-if="loggedIn"></router-view>
   <Footer  v-if="loggedIn"></Footer>
   <Login v-else @login-success="handleLogin"></Login> <!-- Änderung hier: auf 'login-success' Event reagieren -->
 </template>
 