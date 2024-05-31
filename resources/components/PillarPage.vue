<template>

    <table>
      <tbody>
        <tr v-if="articles.length > 0" v-for="article in articles" :key="article.id">
          <td>
            <router-link :to="article.article_url">
              <img :src="article.title_img ? `/storage/${article.title_img}` : '/storage/images/404.png'"
                @error="setDefaultImage" alt="Bild des Artikels" />
              <p>{{ article.title }}</p>
            </router-link>
          </td>
          <td class="onlyDesktop">
            <router-link :to="article.article_url">{{ article.description }}</router-link>
          </td>
          <td>
            <router-link :to="article.article_url">
              <ul>
                <li>{{ article.length }} Wörter</li>
                <li>{{ formatDate(article.created_at) }}</li>
                <li>{{ article.topic_name }}</li>
                <li>{{ article.author_name }}</li>
                <li>
                  <img :src="article.author_img" alt="Bild des Autor" />
                </li>
              </ul>
            </router-link>
          </td>
        </tr>
        <tr v-else >
          <td v-if ="selected_topic">Noch kein Artikel zu {{ selected_topic.topic_name  }} verfügbar</td>
          <td class="onlyDesktop"></td>
          <td></td>
        </tr>
      </tbody>
    </table>

</template>

<script setup>

import axios from 'axios';
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';

const articles = ref([]);
const route = useRoute();
const selected_topic = ref(null);
const topics = ref([]);
const formatDate = (dateString) => {
  const options = { day: '2-digit', month: 'long', year: 'numeric' };
  const date = new Date(dateString);
  return date.toLocaleDateString('de-DE', options);
};
const fetchTopics = () => {
  axios
    .get('/knowledge_topic')
    .then((response) => {
      topics.value = response.data.map(topic => ({ ...topic }));
      topics.value.forEach(topic => {
        if (topic.category_id === 1) {
          topic.category_name = "Medien";
        } else if (topic.category_id === 2) {
          topic.category_name = "Management";
        } else {
          topic.category_name = "Software";
        }
        topic.topic_url = "/" + topic.category_name.toLowerCase().split(' ').join('-') + "/" + topic.topic_name.toLowerCase().split(' ').join('-');
      });
    })
    .catch((error) => {
      console.error('Error fetching knowledge categories', error);
    });
};
watch(
  [() => route.path, () => topics.value],
  ([newPath, newTopics]) => {
    if (newTopics.length > 0) {
      selected_topic.value = newTopics.find(topic => topic.topic_url === newPath);
    
    }
  },
  { immediate: true }
);

const fetchArticleTitles = () => {
  axios
    .get('/articles')
    .then((response) => {
      const filteredArticles = response.data.filter(article => article.topic_id === selected_topic.value.id);
      articles.value = filteredArticles;
    })
    .catch((error) => {
      console.error('Fehler beim Abrufen der Artikel:', error);
      // Behandlung von Fehlern hier
    });
};

onMounted(() => {
  fetchTopics();
  fetchArticleTitles();
});

</script>