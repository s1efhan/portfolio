<template>
  <div>
    <Menu :userData="userData"></Menu>
    <main v-if="$route.path === '/'">
      <Home></Home>
    </main>
    <main v-else-if="$route.path === '/wissen'">
      <Wissen :userData="userData"></Wissen>
    </main>
    <main v-else-if="$route.path === '/kontakt'">
      <Kontakt></Kontakt>
    </main>
    <main v-else-if="$route.path === '/sitemap'">
      <Sitemap></Sitemap>
    </main>
    <main v-else-if="$route.path === '/login'">
      <Login @login="handleLogin"></Login>
    </main>
    <main v-else-if="$route.path === '/lebenslauf'">
      <Lebenslauf></Lebenslauf>
    </main>
    <main v-else-if="$route.path === '/datenschutz'">
      <Datenschutz></Datenschutz>
    </main>
    <main v-else-if="$route.path === '/impressum'">
      <Impressum></Impressum>
    </main>
    <main v-else-if="$route.path === '/projekte'">
      <Projekte></Projekte>
    </main>
    <main v-else-if="$route.path === '/test'">
      <Test></Test>
    </main>
    <main v-else="">
      <NichtGefunden></NichtGefunden>
    </main>
    <Footer></Footer>
  </div>
</template>

<script setup>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import Menu from './components/Menu.vue';
import Footer from './components/Footer.vue';
import { useRoute } from 'vue-router';
import Wissen from './components/Wissen.vue';
import NichtGefunden from './components/NichtGefunden.vue';
import Impressum from './components/Impressum.vue';
import Datenschutz from './components/Datenschutz.vue';
import Home from './components/Home.vue';
import Kontakt from './components/Kontakt.vue';
import Sitemap from './components/Sitemap.vue';
import Lebenslauf from './components/Lebenslauf.vue';
import Projekte from './components/Projekte.vue';
import Login from './components/Login.vue';
import Test from './components/Test.vue';

const isDarkMode = ref(false);
const userData = ref(null);
// Funktion zum Umschalten zwischen Lightmode und Darkmode
function toggleDarkMode() {
  isDarkMode.value = !isDarkMode.value;
  document.body.classList.toggle('darkmode', isDarkMode.value);
}

// Funktion zum Überprüfen des eingeloggten Zustands beim Laden der App
onMounted(async () =>{
  
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    toggleDarkMode(); // Darkmode aktivieren, falls bevorzug
  }
  userData.value = await fetchUserData();
});
const fetchUserData = async () => {
axios.get('/userStatus')
    .then(response => {
      if(response.data.user){
        userData.value = response.data.user;
        console.log("hallo",response.data.user.name);

      }
    })}

</script>
