<template>
    <h1>Test</h1>
    <form @submit.prevent="test">
       <button class="primary-button">Test</button>
        <p>{{ errorMessage }}</p>
        <img src="https://i.imgur.com/B2PRGSF.png">
    </form>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            errorMessage: '',
        };
    },
    mounted() {
        this.test();
    },
    methods: {
        test() {
            axios.get('/articles')
                .then(response => {
                    console.log("response.data ", response.data);

                    // Setzen Sie errorMessage auf den Fehlermeldungstext oder ähnliches
                    this.errorMessage = response.data;

                    console.log('Artikel erfolgreich abgerufen:', response.data);
                })
                .catch(error => {
                    console.error('Fehler beim Abrufen der Artikel:', error);
                    // Setzen Sie errorMessage auf den Fehlerobjekt oder eine benutzerdefinierte Fehlermeldung
                    this.errorMessage = error.response.data || 'Netzwerkfehler';
                });
        }
    }
}
</script>
