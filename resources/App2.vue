<template>
  <div>
    <Menu2 @update:user-data="updateUserData" :userData="userData"></Menu2>
    <router-view :fetch-user-data="fetchUserData" :userData="userData" />
    <Footer></Footer>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted} from 'vue';
import Menu2 from './components/Menu2.vue';
import Footer from './components/Footer.vue';

const userData = ref(null);
const isDarkMode = ref(false);

const updateUserData = (newUserData) => {
  userData.value = newUserData;
};

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  document.body.classList.toggle('darkmode', isDarkMode.value);
};

const fetchUserData = async () => {
  try {
    const response = await axios.get('/userStatus');
    if (response.data.user) {
      userData.value = response.data.user;
      console.log("hallo", response.data.user.name);
    }
  } catch (error) {
    console.error('Error fetching user data:', error);
  }
};

// Überprüfen des eingeloggten Zustands beim Laden der App
onMounted(async () => {
  console.log('mounted ');
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    toggleDarkMode(); // Darkmode aktivieren, falls bevorzugt
  }
  await fetchUserData();
});
</script>
