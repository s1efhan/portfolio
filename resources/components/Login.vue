<template>
    <div class="login-container">
        <form class="login-form" @submit.prevent="login">
            <legend :style="legendStyle" v-html="legend"></legend>

            <input id="name" type="hidden" v-model="name">
            <label for="password">Passwort:</label>
            <input id="password" type="password" v-model="password">
            <button type="submit">Login</button>

        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: 'root',
            password: '',
            legend: 'Privatwebsite! <br> Durch Passwort geschützt'
        };
    },
    methods: {
    login() {
        axios.post('/api/login', {
            name: this.name,
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
