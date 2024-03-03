<template>
    <h1>Login</h1>
    <form class="login-form" @submit.prevent="login">
        <label for="email">Email:</label>
        <input id="email" type="email" v-model="email">
        <label for="password">Passwort:</label>
        <input id="password" type="password" v-model="password">
        <button class="primary_button" type="submit">Anmelden</button>
        <button class="secondary_button" type="button" @click="register">Registrieren</button>
        <p :style="errorStyle">{{ errorMessage }}</p>
    </form>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            errorMessage: '',
            email: '',
            password: '',
            errorStyle: ''
        };
    },
    methods: {
        login() {
            axios.post('/login', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                this.handleResponse(response);
                this.errorMessage = ''; // Leere Fehlermeldung
            })
            .catch(error => {
                this.handleErrorResponse(error);
            });
        },
        register() {
            axios.post('/register', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                this.handleResponse(response);
                this.errorMessage = ''; // Leere Fehlermeldung
            })
            .catch(error => {
                this.handleErrorResponse(error);
            });
        },
        handleResponse(response) {
            // Setze die Nachricht aus der Antwort in das errorMessage Attribut
            this.errorMessage = response.data.message;
            // Setze den errorStyle zurück
            this.errorStyle = '';
            // Emittiere das 'login-success'-Event, wenn erforderlich
            this.$emit('login-success');
        },
        handleErrorResponse(error) {
            // Setze die Fehlermeldung aus der Fehlerantwort in das errorMessage Attribut
            this.errorMessage = error.response.data.message;
            // Setze den errorStyle entsprechend
            this.errorStyle = 'color: var(--primary);';
        }
    }
};
</script>
