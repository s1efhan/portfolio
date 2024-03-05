<template>
    <h1>Login</h1>
    <form class="login-form" @submit.prevent="login">
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="email">
        <label for="password">Passwort:</label>
        <input id="password" type="password" v-model="password">
        <button class="primary-button" type="submit">Anmelden</button>
        <button class="secondary-button" type="button" @click="register">Registrieren</button>
        <p :style="errorStyle">{{ errorMessage }}</p>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    emits: ['login'],
    data() {
        return {
            errorMessage: '',
            email: '',
            password: '',
            errorStyle: 'color: var(--text);',
            user:''
        };
    },
    methods: {
        login() {
    axios.post('/login', {
        email: this.email,
        password: this.password
    })
    .then(response => {
        this.user = response.data.user;
        setTimeout(() => {
          window.location.href = '/';
        }, 1000); // 5000 Millisekunden entsprechen 5 Sekunden
        this.$emit('login', this.user); // 'login' Ereignis emittieren und user Daten übergeben
        this.errorMessage = 'erfolgreich angemeldet'; // Leere Fehlermeldung
    })
    .catch(error => {
        this.errorMessage = 'Anmeldung fehlgeschlagen';
        console.log(error);
    });
},
        register() {
            axios.post('/register', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                console.log(error)
            });},
    }
};
</script>
