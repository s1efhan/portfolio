<template>
  <main>
    <h1>Login</h1>
    <form v-if="!user" class="login-form" @submit.prevent="login">
      <label for="email">Email:</label>
      <input id="email" type="email" v-model="email">
      <label for="password">Passwort:</label>
      <input id="password" type="password" v-model="password">
      <button class="primary-button" type="submit">Anmelden</button>
      <button class="secondary-button" type="button" @click="register">Registrieren</button>
      <p :class="{ 'error-message': errorMessage }">{{ errorMessage }}</p>
    </form>
  </main>
</template>

<script setup>
import axios from 'axios';
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps({
  userData: Object,
  fetchUserData: Function
});

const router = useRouter();
const email = ref('');
const password = ref('');
const errorMessage = ref('');
const user = ref(null);


watch(
  () => props.userData,
  (newUserData) => {
    if (newUserData) {
      user.value = newUserData;
      console.log('login-mounted ', user.value);
    }
  },
  { immediate: true }
);


const login = () => {
  axios.post('/login', {
    email: email.value,
    password: password.value
  })
  .then(response => {
    user.value = response.data.user;
    setTimeout(() => {
      router.go(-1);
    }, 1500);
    props.fetchUserData();
    errorMessage.value = 'erfolgreich angemeldet';
  })
  .catch(error => {
    errorMessage.value = 'Anmeldung fehlgeschlagen';
    console.log(error);
  });
};

const register = () => {
  axios.post('/register', {
    email: email.value,
    password: password.value
  })
  .then(response => {
    console.log(response);
    login();
  })
  .catch(error => {
    console.log(error);
  });
};
</script>