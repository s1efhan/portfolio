<template>
  <main>
    <h1>Kontakt</h1>
    <form @submit.prevent="submitForm">
      <label for="name">Name:</label>
      <input type="text" id="name" v-model="formData.name" autocomplete="name" required>

      <label for="email">E-Mail:</label>
      <input type="email" id="email" v-model="formData.email" autocomplete="email" required>

      <label for="topic">Thema:</label>
      <select id="topic" v-model="formData.thema" required>
        <option value="">Bitte wählen</option>
        <option value="Datenschutz">Datenschutz</option>
        <option value="Fehler">Fehler gefunden?</option>
        <option value="Sonstiges">Sonstiges</option>
        <!-- Weitere Optionen können hier hinzugefügt werden -->
      </select>

      <label for="message">Nachricht:</label>
      <textarea required id="message" v-model="formData.message"></textarea>

      <button class="secondary-button" type="submit">Absenden</button>
    </form>
  </main>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
    const formData = ref({
      name: '',
      email: '',
      message: '',
      thema: ''
    });

    async function submitForm() {
      try {
        const response = await axios.post('/contact', formData.value);
        console.log(response.data); // Wenn die Anfrage erfolgreich ist
        // Hier können Sie eine Erfolgsmeldung anzeigen oder eine Weiterleitung vornehmen
      } catch (error) {
        console.error(error); // Wenn ein Fehler auftritt
        // Hier können Sie eine Fehlermeldung anzeigen
      }
    }


</script>
