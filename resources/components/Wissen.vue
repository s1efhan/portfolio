<template>
<main>
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
                        <router-link :to="article.article_url">
                        <td v-if="!article.title_img">
                            <img src="/storage/app/public/images/404.png" alt="Standardbild">
                        </td>  
                        <td v-else> 
                            <img :src="article.title_img" alt="Bild des Artikels">
                        </td>  
                        <td v-else> 
                            <img :src="article.title_img" alt="Bild des Artikels">
                        </td>
                        <td>{{ article.description }}</td>
                        <td>{{ article.length }} Wörter</td>
                        <td>{{ formatDate(article.created_at) }}</td>
                        <td>{{ article.topic_id }}</td>
                        <td>{{ article.author }}</td>
                    </router-link>
                    </tr>
                </tbody>
            </table>
        <AddArticle v-if ="userData && userData.email === 'stefan.theissen@mail.de'" @fetchArticleTitles="fetchArticleTitles"></AddArticle>
    </main>
</template>

<script setup>
import axios from 'axios';
import {onMounted} from 'vue';
import {ref} from 'vue';
import AddArticle from './AddArticle.vue';
import { defineProps } from 'vue';
const props = defineProps({
  userData: Object // Annahme: userData ist ein Objekt, das als Prop übergeben wird
});
const articles = ref([]);

onMounted(() => {
    fetchArticleTitles();
});

const formatDate = (dateString) => {
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('de-DE', options);
}

const fetchArticleTitles = () => {
    axios.get('/articles')
        .then(response => {
            articles.value = response.data;
            console.log('Artikel erfolgreich abgerufen:', response.data);
        })
        .catch(error => {
            console.error('Fehler beim Abrufen der Artikel:', error);
            // Behandlung von Fehlern hier
        });}
</script>

