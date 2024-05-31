<template>
      <section class="alterArticle">
        <div class="form-container">
          <form class="addArticle-form" @submit.prevent="alterArticle">
            <legend :style="legendStyle" v-html="legendArticle"></legend>
            <label for="title">Meta Title:</label>
            <input id="title" type="text" v-model="title" placeholder="Max. 60 characters">
            <label for="article_url">Url: </label>
            <input id="article_url" type="text" v-model="article_url" placeholder="z.B /article-name">
            <label for="description">Meta Description:</label>
            <input id="description" type="text" v-model="description" placeholder="Max. 160 characters">
            <label for="author">Author:</label>
            <select id="author" v-model="author">
              <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
            </select>
            <label for="topic_id">Thema:</label>
            <select id="topic_id" v-model="topic_id">
              <option v-for="knowledge_topic in knowledge_topics" :key="knowledge_topic.id" :value="knowledge_topic.id">
                {{ knowledge_topic.topic_name }}
              </option>
            </select>
            <label for="title_img">Titelbild:</label>
            <input id="title_img" type="file" accept=".png, .jpg, .jpeg" @change="handleFileChange">
            <label for="quill-editor">Inhalt des Artikels:</label>
            <div id="quill-editor">
              <QuillEditor id="content" @input="updateLength" :toolbar="toolbarOptions" theme="snow" v-model:content="content" contentType="html" />
              <label for="length">Länge</label>
              <input id="length" type="text" :value="length + ' Wörter'" readonly>
            </div>
            <button class="secondary_button" type="submit">Speichern</button>
          </form>
        </div>
      </section>

  </template>
  
  <script>
  import { ref, watch, onMounted } from 'vue';
  import axios from 'axios';
  import { QuillEditor } from '@vueup/vue-quill'
  import '@vueup/vue-quill/dist/vue-quill.snow.css';
  
  export default {
    components: {
      QuillEditor
    },
    props: {
      selectedArticle: {
        type: Object,
        default: null
      }
    },
    setup(props, context) {
      const toolbarOptions = ref([
        [{ 'header': [2, 3, 4, false] }, 'bold', 'italic', 'underline'],
        [, { 'list': 'ordered' }, { 'list': 'bullet' }, { 'indent': '+1' }, 'clean', { 'align': [] }, 'video', 'link'],
      ]);
      const title = ref('');
      const description = ref('');
      const author = ref('');
      const title_img = ref(null);
      const content = ref('');
      const length = ref(0);
      const topic_id = ref('');
      const topic_name = ref('');
      const knowledge_category_id = ref('');
      const knowledge_categories = ref([]);
      const knowledge_topics = ref([]);
      const article_url = ref('');
      const knowledge_category_name = ref('');
      const nav_item = ref('');
      const legendArticle = ref('');
      const legendCategory = ref('');
      const legendTopic = ref('');
      const legendStyle = ref('color: var(--primary);');
      const legend = ref('');
      const users = ref([]);
  
      watch(title, (newTitle) => {
  // Entferne alle ungültigen Zeichen aus dem Titel
  const cleanedTitle = newTitle // neue Titelzeichenfolge
  .toLowerCase() // in Kleinbuchstaben umwandeln
  .replace(/[^a-z0-9\s-]/g, '') // Zeichen außer a-z, 0-9, Leerzeichen und Bindestrich entfernen
  .replace(/\s+/g, '-'); // Leerzeichen durch Bindestriche ersetzen


  // Überprüfe, ob die generierte URL gültig ist
  const urlPattern = /^\/([a-z0-9-]+\/)*[a-z0-9-]+$/;
  if (urlPattern.test(`/${cleanedTitle}`)) {
    article_url.value = `/${cleanedTitle}`;
  }
});
  
      const updateLength = () => {
        length.value = content.value.split(/\s+/).filter(word => word).length;
      };
  
      const handleFileChange = (event) => {
        title_img.value = event.target.files[0];
      };
  
      const alterArticle = () => {
  let formData = new FormData();
  console.log(article_url.value);
  formData.append('id', props.selectedArticle.id);
  formData.append('article_url', article_url.value);
  formData.append('title', title.value);
  formData.append('description', description.value);
  formData.append('author', author.value);
  formData.append('topic_id', topic_id.value);
  formData.append('content', content.value);
  formData.append('length', length.value);

  // Nur das Titelbild hinzufügen, wenn ein neues ausgewählt wurde
  if (title_img.value) {
    formData.append('title_img', title_img.value);
  }

  axios.post('/alterArticle', formData, {
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
  .then(response => {
    legendArticle.value = response.data.message;
    console.log("Erfolgreich gespeichert!");
    fetchArticleTitles();
  })
  .catch(error => {
    if (error.response.status === 422) {
      let errors = error.response.data.errors;
      let errorMessage = '';
      for (let key in errors) {
        errorMessage += `${errors[key][0]}\n`;
      }
      legendArticle.value = errorMessage;
      legendStyle.value = 'color: var(--primary);';
      fetchArticleTitles();
    } else {
      legendArticle.value = 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.';
      legendStyle.value = 'color: var(--primary);';
    }
  });
};
  
      const fetchUsers = () => {
        axios.get('/users')
          .then(response => {
            users.value = response.data;
            if (props.selectedArticle && props.selectedArticle.author) {
              author.value = props.selectedArticle.author;
            } else {
              author.value = users.value.length > 0 ? users.value[0].id : '';
            }
          })
          .catch(error => {
            console.error('Error fetching users', error);
          });
      };
  
      const fetchTopics = () => {
        axios.get('/knowledge_topic')
          .then(response => {
            knowledge_topics.value = response.data;
            if (props.selectedArticle && props.selectedArticle.topic_id) {
              topic_id.value = props.selectedArticle.topic_id;
            } else {
              topic_id.value = knowledge_topics.value.length > 0 ? knowledge_topics.value[0].id : '';
            }
          })
          .catch(error => {
            console.error('Error fetching knowledge topics', error);
          });
      };
  
      const fetchArticleTitles = () => {
        context.emit('fetchArticleTitles');
      };
  
      watch(
        () => props.selectedArticle,
        (newValue) => {
          if (newValue) {
            title.value = newValue.title;
            description.value = newValue.description;
            author.value = newValue.author;
            topic_id.value = newValue.topic_id;
            content.value = newValue.content;
            length.value = newValue.length;
            article_url.value = newValue.article_url;
            title_img.value = newValue.title_img;
          }
        },
        { immediate: true }
      );
  
      onMounted(() => {
        fetchUsers();
        fetchTopics();
      });
  
      return {
        toolbarOptions,
        title,
        description,
        author,
        title_img,
        content,
        length,
        topic_id,
        topic_name,
        knowledge_category_id,
        knowledge_categories,
        knowledge_topics,
        article_url,
        knowledge_category_name,
        nav_item,
        legendArticle,
        legendCategory,
        legendTopic,
        legendStyle,
        legend,
        users,
        updateLength,
        handleFileChange,
        alterArticle,
        fetchArticleTitles
      }
    }
  }
  </script>