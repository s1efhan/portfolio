<template>
  <div>
    <Menu @update:user-data="updateUserData" :userData="userData"></Menu>
<router-view :fetch-user-data="fetchUserData" :userData="userData" />
    <Footer></Footer>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';
function updateUserData(newUserData) {
    userData.value = newUserData;
    }
const isDarkMode = ref(false);
const userData = ref(null);
// Funktion zum Umschalten zwischen Lightmode und Darkmode
function toggleDarkMode() {
  isDarkMode.value = !isDarkMode.value;
  document.body.classList.toggle('darkmode', isDarkMode.value);
}
// Funktion zum Überprüfen des eingeloggten Zustands beim Laden der App
onMounted(async () => {
console.log('mounted ')
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    toggleDarkMode(); // Darkmode aktivieren, falls bevorzug
  }
  userData.value = await fetchUserData();
});
const fetchUserData = async () => {
  axios.get('/userStatus')
    .then(response => {
      if (response.data.user) {
        userData.value = response.data.user;
        console.log("hallo", response.data.user.name);

      }
    })
}

</script>
