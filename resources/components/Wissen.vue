<template>
    <div>
        <h1>Wissen</h1>
        <section class="blog">
            <table>
                <thead>
                    <tr>
                        <th>Beschreibung</th>
                        <th>Länge</th>
                        <th>Erstellt am</th>
                        <th>Thema ID</th>
                        <th>Autor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="article in articles" :key="article.id">
                        <td v-if="!article.title_img">
                            <img src="/storage/app/public/images/404.png" alt="Standardbild">
                        </td>  <td v-else> <img
                                :src="article.title_img" alt="Bild des Artikels">
                        </td>
                        <td>{{ article.description }}</td>
                        <td>{{ article.length }} Wörter</td>
                        <td>{{ formatDate(article.created_at) }}</td>
                        <td>{{ article.topic_id }}</td>
                        <td>{{ article.author }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <AddArticle @fetchArticleTitles="fetchArticleTitles"></AddArticle>
    </div>
</template>

<script>
import Breadcrumps from './Breadcrumps.vue';
import AddArticle from './AddArticle.vue';
import axios from 'axios';

export default {
    components: {
        AddArticle,
        Breadcrumps,
    },
    data() {
        return {
            articles: [],
        };
    },
    mounted() {
        this.fetchArticleTitles();
    },
    methods: {
        formatDate(dateString) {
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            const date = new Date(dateString);
            return date.toLocaleDateString('de-DE', options);
        },
        fetchArticleTitles() {
            axios.get('/articles')
                .then(response => {
                    // Setzen Sie errorMessage auf den Fehlermeldungstext oder ähnliches
                    this.articles = response.data;

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