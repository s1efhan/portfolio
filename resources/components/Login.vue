<template>
    <main style="margin-top:10vh;">
    <div class="form-container">
        <form class="login-form" @submit.prevent="login">
            <legend :style="legendStyle" v-html="legend"></legend>
            <label for="email">Email:</label>
            <input id="email" type="email" v-model="email">
            <label for="password">Passwort:</label>
            <input id="password" type="password" v-model="password">
            <button class="primary_button" type="submit">Anmelden</button>
            <button class="secondary_button" type="button" @click="register">Registrieren</button>
        </form>
    </div>
</main>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            legendStyle: '',
            email: '',
            password: '',
            legend: 'Login'
        };
    },
    methods: {
        login() {
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                this.handleResponse(response);
            })
            .catch(error => {
                this.handleErrorResponse(error);
            });
        },
        register() {
            axios.post('/api/register', {
                email: this.email,
                password: this.password
            })
            .then(response => {
                this.handleResponse(response);
            })
            .catch(error => {
                this.handleErrorResponse(error);
            });
        },
        handleResponse(response) {
            // Setze die Nachricht aus der Antwort in das message Attribut
            this.legend = response.data.message;
            // Setze den legendStyle zurück
            this.legendStyle = '';
            // Emittiere das 'success'-Event, wenn erforderlich
            this.$emit('login-success');
        },
        handleErrorResponse(error) {
            // Setze die Fehlermeldung aus der Fehlerantwort in das message Attribut
            this.legend = error.response.data.message;
            // Setze den legendStyle entsprechend
            this.legendStyle = 'color: var(--primary-color);';
        }
    }
};
</script>
