<template>
    <main>
        <h1>Lebenslauf</h1>
        <div class="Cv">
            <img :src="'storage/images/censoredCv.png'" max-width="100%" height="400px" />
        </div>

        <form @submit.prevent="csvDownload">
            <h2>Vollständigen Lebenslauf herunterladen (unzensiert)</h2>
            <label for="email">Ihre E-Mail Adresse:</label>
            <input type="email" id="email" name="email" v-model="email" required />
            <label for="name">Ihr Name:</label>
            <input type="text" id="name" name="name" v-model="name" />

            <label for="company">Ihr Unternehmen:</label>
            <input type="text" id="company" name="company" v-model="company" />
            <label for="position">Ihre Position:</label>
            <select id="position" name="position" v-model="selectedPosition">
                <option value="Personaler/HR">Personaler/HR</option>
                <option value="Geschäftsführer">Geschäftsführer</option>
                <option value="Teamleiter/Projektmanager">Teamleiter/Projektmanager</option>
                <option value="Headhunter/Recruiter">Headhunter/Recruiter</option>
                <option value="Andere">Sonstige</option>
            </select>

            <input type="text" id="anderePosition" name="anderePosition" v-model="anderePosition" v-show="selectedPosition === 'Andere'" />
            <button class="primary-button" type="submit" name="submit">Lebenslauf Anfragen</button>
            <p :style="fieldsetStyle">{{ errorMessage }}</p>
            <p v-if="successMessage" style="color: green;">{{ successMessage }}</p>
        </form>
    </main>
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
            errorMessage: '',
            successMessage: '',
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
                this.fieldsetStyle = "color: var(--primary);"
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
                this.fieldsetStyle = "color: var(--primary);"
                this.errorMessage = '';
                this.successMessage = 'Deine Anfrage ist eingegangen';

                // Formularfelder leeren
                this.email = '';
                this.name = '';
                this.company = '';
                this.selectedPosition = '';
                this.anderePosition = '';
            })
            .catch(error => {
                // Fehlerbehandlung
                console.error(error);
                this.fieldsetStyle = "color: var(--primary);"
                this.errorMessage = 'Beim Download ist ein Fehler aufgetreten. Bitte versuchen Sie es erneut.';
                this.successMessage = '';
            });
        }
    }
}
</script>
