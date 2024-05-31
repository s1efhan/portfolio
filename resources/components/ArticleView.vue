<template>
    <main>
    <section class="article_title_bereich">
        <img class="title_img" :src="article.title_img" @error="handleImageError">
    <h1>{{ article.title }}</h1>
    <button class="secondary-button"@click="downloadPdf">Download PDF</button>
    </section>
    <section class="article_inhalt" v-html="article.content"></section>
    <!-- Je nach aufgerufener URL dynamisch das HTML aus der Datenbank -->
</main>
</template>

<script setup>

import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
const $route = useRoute(); // $route aus useRoute() holen

const article = ref([]);

onMounted(() => {
    showArticle();
});

const downloadPdf = (article_id) => {
    article_id = article.value.id;
    console.log(article_id) // Hier setzen Sie den gewünschten Artikel-URL
    axios.get('/downloadArticle', {
        params: {
            article_id: article_id
        },responseType: 'blob'
    }).then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', article.value.title +".pdf");
        document.body.appendChild(link);
        link.click();
        console.log('download erfolgreich')
    }).catch(error => {
        console.error('Fehler beim Abrufen des Artikels:', error);
        // Behandlung von Fehlern hier
    });
};

const showArticle = () => {
    const article_url = $route.path; // Hier setzen Sie den gewünschten Artikel-URL

    axios.get('/article', {
        params: {
            article_url: article_url
        }
    })
        .then(response => {
            article.value = response.data;
            console.log('Artikel erfolgreich abgerufen:', response.data);
            let metaOgTitle, metaPublished, metaModified, metaType, metaCanonical, metaOgDescription, metaSiteName;
            document.title = article.value.title;
            metaOgTitle = document.createElement('meta');
            metaOgTitle.setAttribute('name', 'og:title');
            document.head.appendChild(metaOgTitle);
            metaOgTitle.setAttribute('content', article.value.title);
            metaPublished = document.createElement('meta');
            metaPublished.setAttribute('name', 'og:article:published_time');
            document.head.appendChild(metaPublished);
            metaPublished.setAttribute('content', article.value.created_at);
            metaModified = document.createElement('meta');
            metaModified.setAttribute('name', 'og:article:modified_time');
            document.head.appendChild(metaModified);
            metaModified.setAttribute('content', article.value.updated_at);
            metaType = document.createElement('meta');
            metaType.setAttribute('name', 'og:type');
            document.head.appendChild(metaType);
            metaType.setAttribute('content', 'article');

            metaCanonical = document.createElement('link');
            metaCanonical.setAttribute('rel', 'canonical');
            document.head.appendChild(metaCanonical);
            metaCanonical.setAttribute('content', 'https://' + article.value.article_url);

            let metaDescription = document.querySelector('meta[name="description"]');
            if (!metaDescription) {
                metaDescription = document.createElement('meta');
                metaDescription.setAttribute('name', 'description');
                document.head.appendChild(metaDescription);
                metaOgDescription = document.createElement('meta');
                metaOgDescription.setAttribute('name', 'og:description');
                document.head.appendChild(metaOgDescription);
            }
            metaOgDescription.setAttribute('content', article.value.description);
            metaDescription.setAttribute('content', article.value.description);
            let metaAuthor = document.querySelector('meta[name="author"]');
            if (!metaAuthor) {
                metaAuthor = document.createElement('meta');
                metaAuthor.setAttribute('name', 'author');
                document.head.appendChild(metaAuthor);
                metaSiteName = document.createElement('meta');
                metaSiteName.setAttribute('name', 'og:site_name');
                document.head.appendChild(metaSiteName);
            }
            metaSiteName.setAttribute('content', "stefan-theissen.de");
            metaAuthor.setAttribute('content', article.value.author);
            let metaRobots = document.querySelector('meta[name="robots"]');
            if (!metaRobots) {
                metaRobots = document.createElement('meta');
                metaRobots.setAttribute('name', 'robots');
                document.head.appendChild(metaRobots);
            }
            metaRobots.setAttribute('content', 'index, follow');
        })
        .catch(error => {
            console.error('Fehler beim Abrufen des Artikels:', error);
            // Behandlung von Fehlern hier
        });
};


</script>