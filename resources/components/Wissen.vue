<!-- Wissen.vue-->
<script setup>
import Breadcrumps from './Breadcrumps.vue';
import AddArticle from './AddArticle.vue';
</script>
<template>
                <h1>Wissen</h1>
                <section class="blog">
                        <table v-for="article in articles" :key="article.id">
                                <thead>
                                        <tr class="only_desktop">
                                                <th>Titelbild</th>
                                                <th>Titel</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                                <td> <img class="table_title_img" :src="article.title_img" :alt="article.title_img">
                                                </td>
                                                <td>{{ article.title }}</td>
                                        </tr>

                                </tbody>
                                <thead  class="only_desktop">
                                        <tr>
                                                <th>Beschreibung</th>
                                                <th>Länge</th>
                                                <th>Erstellt am</th>
                                                <th>Thema ID</th>
                                                <th>Autor</th>
                                        </tr>
                                </thead>
                                <tbody>    <tr>
                                                <td class="only_desktop">{{ article.description }}</td>
                                                <td>{{ article.length }} Wörter</td>
                                                <td>{{ formatDate(article.created_at) }}</td>
                                                <td class="only_desktop">{{ article.topic_id }}</td>
                                                <td class="only_desktop">{{ article.author }}</td>

                                                <!-- Weitere Spalten nach Bedarf -->
                                        </tr></tbody>
                        </table>

                </section>
                <AddArticle @fetchArticleTitles="fetchArticleTitles"></AddArticle>
</template>

<script>
export default {
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
                                        this.articles = response.data;
                                })
                                .catch(error => {
                                        console.error('Error fetching users', error);
                                });
                },
        }
}
</script>