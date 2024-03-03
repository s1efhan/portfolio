<template>
                <h1>Lebenslauf Download</h1>
    <form  @submit.prevent="csvDownload">
        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" v-model="email" required>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" v-model="name">
        
        <label for="company">Unternehmen:</label>
        <input type="text" id="company" name="company" v-model="company">
        
        <select id="position" name="position" v-model="selectedPosition">
            <option value="Personaler/HR">Personaler/HR</option>
            <option value="Geschäftsführer">Geschäftsführer</option>
            <option value="Teamleiter/Projektmanager">Teamleiter/Projektmanager</option>
            <option value="Headhunter/Recruiter">Headhunter/Recruiter</option>
            <option value="Andere">Sonstige</option>
        </select>

        <input type="text" id="anderePosition" name="anderePosition" v-model="anderePosition" v-show="selectedPosition === 'Andere'">
        <button class= "primary_button_full" type="submit" name="submit">Download</button>
        <p :style="fieldsetStyle">{{ errorMessage }}</p>
  </form>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            email: '',
            name: '',
            company: '',
            selectedPosition: '',
            anderePosition: '',
            errorMessage:'',
            fieldsetStyle: 'color: var(--text);'
        };
    },
    methods: {
        checkPosition() {
            if (this.selectedPosition === 'Andere') {
                document.getElementById('anderePosition').style.display = 'block';
            } else {
                document.getElementById('anderePosition').style.display = 'none';
            }
        },
        csvDownload() {
            // Daten validieren
            if (!this.email) {
                this.fieldsetStyle="color: var(--primary);"
                this.errorMessage = 'Bitte geben Sie Ihre E-Mail-Adresse ein.';
                return;
            }
            
            // Hier weitere Validierungen hinzufügen...
            
            // Senden der Daten
            axios.post('/cv-download', {
                email: this.email,
                name: this.name,
                company: this.company,
                position: this.selectedPosition === 'Andere' ? this.anderePosition : this.selectedPosition
            })
            .then(response => {
                // Erfolgreiche Antwort
                console.log(response.data);
                this.fieldsetStyle="color: var(--primary);"
                this.errorMessage = 'Erfolgreicher Download - Eine unzensierte Version erhältst du sobald deine Eingabedaten verifiziert wurden per Email';
            })
            .catch(error => {
                // Fehlerbehandlung
                console.error(error);
                this.fieldsetStyle="color: var(--primary);"
                this.errorMessage = 'Beim Download ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.';
            });
        }
    }
}
</script>
