<template>
    <Menu :fetchUserData="fetchUserData" @update:user-data="updateUserData" :userData="userData"></Menu>
    <div @click="toggleCookies(showCookies)"class="cookie"><CookieIcon/></div>
    <Cookies :cookieData="cookieData" @save-cookies="showCookies = false" :showCookies="showCookies" v-if="showCookies"/>
<router-view :fetchUserData="fetchUserData" :userData="userData" />
    <Footer></Footer>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Menu from './components/Menu.vue';
import CookieIcon from './components/icons/CookieIcon.vue';
import Cookies from './components/Cookies.vue';
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
const showCookies = ref(true);
const toggleCookies = () => {
  if (showCookies.value){
    showCookies.value = false
  }else  {showCookies.value = true;}
}
const fetchUserData = async () => {
  try {
    const response = await axios.get('/userStatus');
    if (response.data.user) {
      userData.value = response.data.user;
      console.log('User data fetched:', userData.value);
    }
  } catch (error) {
    console.error('Error fetching user data:', error);
  }
};
const cookieData = ref(null);
const checkCookieValue = async () => {
  try {
    const response = await axios.get('/fetch-cookies');
    
    if (response.status === 200 && response.data && response.data.preferences) {
      cookieData.value = response.data.preferences;
      console.log("cookieData", cookieData.value);
      if (cookieData.value) {
        document.querySelector('.cookie').style.zIndex = '2';
        showCookies.value = false;
      }
    } else {
      console.error('Ungültige Antwort vom Server:', response);
    }
  } catch (error) {
    console.error('Fehler beim Abrufen der Cookie-Einstellungen:', error);
  }
};

onMounted(checkCookieValue);
onMounted(fetchUserData);
onMounted(toggleDarkMode);
</script>