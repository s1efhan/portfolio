<template>
    <div class="form-container">
        <form class="login-form" @submit.prevent="login">
            <legend :style="legendStyle" v-html="legend"></legend>

            <input id="email" type="hidden" v-model="email">
            <label for="password">Passwort:</label>
            <input id="password" type="password" v-model="password">
            <button class ="primary_button" type="submit">Login</button>

        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            legendStyle: '',
            email: 'stefan.theissen@mail.de',
            password: '',
            legend: 'Privatwebsite! <br> Durch Passwort geschützt'
        };
    },
    methods: {
    login() {
        axios.post('/api/login', {
            email: this.email,
            password: this.password
        })
        .then(response => {
            //bei erfolg
            this.$emit('login-success');
            console.log("erfolg!")

        })
        .catch(error => {
            this.legend = error.response.data.error;
            this.legendStyle = 'color: var(--primary-color);';
        });
    }
}

};
</script>
