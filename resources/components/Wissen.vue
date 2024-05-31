<template>

  <main>
    <h1 v-if="selected_topic">{{ selected_topic.topic_name }}</h1>
    <h1 v-else> Wissen</h1>
    <button @click="active_category_id = 0;" v-if ="active_category_id != 0"class="accent-button">Alle Kategorien</button>
    <ul v-if="active_category_id ===0"class="categories">
  <li @click="active_category_id = 1;" class="Medien">
    <a>
      <h3><MedienIcon/></h3>
      <p>Medien</p>
    </a>
  </li>
  <li @click="active_category_id = 2;" class="Management">
    <a>
      <h3><ManagementIcon/></h3>
      <p>Management</p>
    </a>
  </li>
  <li @click="active_category_id = 3;" class="Software">
    <a>
      <h3><Software-Icon/></h3>
      <p>Software</p>
    </a>
  </li>
</ul>
<ul v-if="active_category_id != 0"class="knowledge_categories">
  <li v-for="topic in filteredTopics" :key="topic.id" :class="categories.find((category) => category.id === topic.category_id)?.name">
    <p class="category-icon">
      <MedienIcon/>
    </p>
    <router-link @click="active_category_id = 0" :to="{ path: topic.topic_url }">
      <h3><component v-if="loadComponent(topic.icon)" :is="loadComponent(topic.icon)"></component></h3>
      <p class="topic_name">{{ topic.topic_name }}</p>
    </router-link>
  </li>
</ul>
    <table v-if="route.path === '/wissen'">
      <tbody>
        <tr v-for="article in articles" :key="`admin-${article.id}`">
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
      </tbody>
    </table>
    <section v-if="userData && userData.email === 'stefan.theissen@mail.de' && route.path === '/wissen'">
      <h2>{{ addArticleH2 }}</h2>
      <button class="accent-button" @click="switchAction">{{ action }}</button>
      <label v-show="action === 'Artikel hinzufügen'" for="article_name">Artikel:</label>
      <form>
        <select v-show="action === 'Artikel hinzufügen'" id="article_name" v-model="selectedArticleId">
          <option v-for="article in articles" :key="article.id" :value="article.id">
            {{ article.title }}
          </option>
        </select>
      </form>
      <AlterArticle v-show="action === 'Artikel hinzufügen'" :selected-article="selectedArticle"
        @fetchArticleTitles="fetchArticleTitles"></AlterArticle>
      <AddArticle v-show="action === 'Artikel bearbeiten'" @fetchArticleTitles="fetchArticleTitles"></AddArticle>
    </section>
 
  <PillarPage  v-if="$route.path != '/wissen' && $route.path != '/medien' && $route.path != '/management' && $route.path != '/software'"></PillarPage>
</main>
</template>

<script setup>
import { useRoute } from 'vue-router'; // useRoute aus vue-router importieren
import axios from 'axios';
import { onMounted, ref, computed, watch} from 'vue';
import AddArticle from './AddArticle.vue';
import AlterArticle from './AlterArticle.vue';
import PillarPage from './PillarPage.vue';
import MedienIcon from './icons/MedienIcon.vue';
import ManagementIcon from './icons/ManagementIcon.vue';
import SoftwareIcon from './icons/SoftwareIcon.vue';

import { defineAsyncComponent } from 'vue'

const loadComponent = (componentName) => {
  const componentPath = `./icons/${componentName}.vue`

  return defineAsyncComponent(() =>
    import(/* @vite-ignore */ componentPath)
  )
}
const route = useRoute();
const filteredTopics = computed(() => {
  return topics.value.filter(topic => topic.category_id === active_category_id.value);
});
const props = defineProps({
  userData: Object, // Annahme: userData ist ein Objekt, das als Prop übergeben wird
}); 


onMounted(() => {

  fetchArticleTitles();
  fetchCategories();
  fetchTopics();
  if (route.path === "/medien")
  {
    active_category_id.value = 1;
  }else if (route.path === "/management")
  {
  active_category_id.value = 2;
  }
  else if (route.path === "/software"){
    active_category_id.value = 3;
  }
});

const categories = ref([]);
const topics = ref([]);
const active_category_id = ref(0);


const fetchCategories = () => {
  axios
    .get('/knowledge_categories')
    .then((response) => {
      categories.value = response.data;
    })
    .catch((error) => {
      console.error('Error fetching knowledge categories', error);
    });
};

const fetchTopics = () => {
  axios
    .get('/knowledge_topic')
    .then((response) => {
      topics.value = response.data;
      topics.value.forEach(topic => {
        if(topic.category_id === 1){
        topic.category_name = "Medien";
      }
      else if (topic.category_id === 2){
        topic.category_name = "Management";
      }
    else {
      topic.category_name = "Software";
    }
        topic.topic_url = "/" + topic.category_name.toLowerCase().split(' ').join('-') + "/" + topic.topic_name.toLowerCase().split(' ').join('-');
      });
    })
    
    .catch((error) => {
      console.error('Error fetching knowledge categories', error);
    });
};

const articles = ref([]);
const selectedArticleId = ref(null);
const selectedArticle = computed(() => {
  if (articles.value.length > 0 && selectedArticleId.value === null) {
    selectedArticleId.value = articles.value[0].id; // Setze die erste Option als Standardwert
  }
  return articles.value.find((article) => article.id === selectedArticleId.value);
});

const addArticleH2 = ref('Artikel hinzufügen');
const action = ref('Artikel bearbeiten');

const switchAction = () => {
  if (action.value === 'Artikel hinzufügen') {
    action.value = 'Artikel bearbeiten';
    addArticleH2.value = 'Artikel hinzufügen';
  } else {
    addArticleH2.value = 'Artikel bearbeiten';
    action.value = 'Artikel hinzufügen';
  }
};

const formatDate = (dateString) => {
  const options = { day: '2-digit', month: 'long', year: 'numeric' };
  const date = new Date(dateString);
  return date.toLocaleDateString('de-DE', options);
};

const setDefaultImage = (event) => {
  event.target.src = '/storage/images/404.png';
};
const selected_topic = ref(null);
const fetchArticleTitles = () => {
  axios
    .get('/articles')
    .then((response) => {
      articles.value = response.data;
      console.log('Artikel erfolgreich abgerufen:', response.data);
    })
    .catch((error) => {
      console.error('Fehler beim Abrufen der Artikel:', error);
      // Behandlung von Fehlern hier
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
</script>