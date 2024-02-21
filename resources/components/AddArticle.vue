<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
</script>
<template>
    <section class="addArticle">
        <h2>Artikel hinzufügen</h2>
        <div class="form-container">
            <form class="addArticle-form" @submit.prevent="addArticle">
                <legend :style="legendStyle" v-html="legendArticle"></legend>
                <label for="description">Meta Title:</label>
                <input id="title" type="text" v-model="title" placeholder="Max. 60 characters">
                <label for="description">Meta Description:</label>
                <input id="description" type="text" v-model="description" placeholder="Max. 160 characters">
                <label for="">Author:</label>
                <select id="author" v-model="author">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
                <label for="">Thema:</label>
                <select id="topic_id" v-model="topic_id">
                    <option v-for="knowledge_topic in knowledge_topics" :key="knowledge_topic.id"
                        :value="knowledge_topic.id">
                        {{ knowledge_topic.topic_name }}
                    </option>
                </select>
                <label for="title_img">Titelbild:</label>
                <input id="title_img" type="file" accept=".png, .jpg, .jpeg" @change="handleFileChange">
                <label for="content">Inhalt des Artikels:</label>
                <QuillEditor @input="updateLength" :toolbar="toolbarOptions" theme="snow" v-model:content="content"
                    contentType="html" />
                <label>Länge</label>
                <input type="text" :value="length + ' Wörter'" readonly>
                <button class="secondary_button" type="submit">Speichern</button>
            </form>
        </div>
    </section>
    <section class="addCategory">
        <h2>Kategorie hinzufügen</h2>
        <div class="form-container">

            <form class="addCategory-form" @submit.prevent="addKnowledgeCategory">
                <legend :style="legendStyle" v-html="legendCategory"></legend>
                <label for="knowledge_category_name">Kategorie:</label>
                <input id="knowledge_category_name" type="text" v-model="knowledge_category_name">
                <button class="accent_button" type="submit">Speichern</button>
            </form>
        </div>
    </section>
    <section class="addTopic">
        <h2>Thema hinzufügen</h2>
        <div class="form-container">

            <form class="addTopic-form" @submit.prevent="addTopic">
                <legend :style="legendStyle" v-html="legendTopic"></legend>
                <label for="topic_name">Thema:</label>
                <input id="topic_name" type="text" v-model="topic_name">
                <label for="knowledge_category_id">Kategorie:</label>
                <select id="knowledge_category_id" v-model="knowledge_category_id">
                    <option v-for="knowledge_category in knowledge_categories" :key="knowledge_category.id"
                        :value="knowledge_category.id">
                        {{ knowledge_category.name }}
                    </option>
                </select>
                <button class="accent_button" type="submit">Speichern</button>
            </form>
        </div>
    </section>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            toolbarOptions: [
                [{ 'header': [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'align': [] }],
                ['link', 'video'],
                ['clean']
            ],
            title: '',
            description: '',
            author: null,
            users: [],
            title_img: null,
            content: '',
            length: '0',
            topic_id: '',
            topic_name: '',
            knowledge_category_id: '',
            knowledge_categories: [],
            knowledge_topics: [],
            knowledge_category_name: '',
            nav_item: '',
            legendArticle: '',
            legendCategory: '',
            legendTopic: '',
            legendStyle: 'color: var(--primary-color);',
            legend: ''
        };
    },
    mounted() {
        this.fetchUsers();
        this.fetchCategories();
        this.fetchTopics();
    },
    methods: {
        updateLength() {
            // Berechnen Sie die Länge des Inhalts und aktualisieren Sie das length-Attribut
            this.length = this.content.split(/\s+/).filter(word => word).length;
        },
        handleFileChange(event) {
        this.title_img = event.target.files[0];
    },
    addArticle() {
    // Erstellen Sie ein FormData-Objekt
    let formData = new FormData();

    // Fügen Sie die Formulardaten hinzu
    formData.append('title', this.title);
    formData.append('description', this.description);
    formData.append('author', this.author);
    formData.append('topic_id', this.topic_id);
    formData.append('title_img', this.title_img); // Fügen Sie das Bild hinzu
    formData.append('content', this.content);
    formData.append('length', this.length);

    axios.post('/api/addArticle', formData, {
        headers: {
            'Content-Type': 'multipart/form-data' // Erforderlich für die Übertragung von Dateien
        }
    })
    .then(response => {
        // Bei Erfolg
        this.legendArticle = response.data.message;
        console.log("Erfolgreich gespeichert!");
    })
    .catch(error => {
        if (error.response.status === 422) {
            // Wenn die Validierung fehlschlägt, erhalten Sie die Fehlermeldungen im Fehlerantwortobjekt
            let errors = error.response.data.errors;
            let errorMessage = '';

            // Durchlaufen Sie die Fehler und erstellen Sie eine Nachricht, die sie anzeigt
            for (let key in errors) {
                errorMessage += `${errors[key][0]}\n`;
            }

            // Fehlermeldung anzeigen
            this.legendArticle = errorMessage;
            this.legendStyle = 'color: var(--primary-color);';
        } else {
            // Wenn ein anderer Fehler auftritt, allgemeine Fehlermeldung anzeigen
            this.legendArticle = 'Ein Fehler ist aufgetreten. Bitte versuchen Sie es erneut.';
            this.legendStyle = 'color: var(--primary-color);';
        }
    });
},
        fetchUsers() {
            axios.get('/api/users')
                .then(response => {
                    this.users = response.data;
                    this.author = this.users[0].id;
                    console.log(this.author)
                })
                .catch(error => {
                    console.error('Error fetching users', error);
                });
        },
        fetchCategories() {
            axios.get('/api/knowledge_categories')
                .then(response => {
                    this.knowledge_categories = response.data;
                    if (this.knowledge_categories.length > 0) {
                        this.knowledge_category_id = this.knowledge_categories[0].id;
                    }
                })
                .catch(error => {
                    console.error('Error fetching knowledge categories', error);
                });
        }, fetchTopics() {
            axios.get('/api/knowledge_topic')
                .then(response => {
                    this.knowledge_topics = response.data;
                    this.topic_id = this.knowledge_topics[0].id;
                    console.log(this.topic_id);
                })
                .catch(error => {
                    console.error('Error fetching knowledge categories', error);
                });
        },

        addTopic() {
            axios.post('/api/knowledge_topic', {
                topic_name: this.topic_name,
                knowledge_category_id: this.knowledge_category_id
            })
                .then(response => {
                    //bei erfolg
                    this.legendTopic = response.data.message;
                    console.log("Erfolgreich gespeichert!");

                })
                .catch(error => {
                    this.legendTopic = error.response.data.error
                    this.legendStyle = 'color: var(--primary-color);';
                });
        },
        addKnowledgeCategory() {
            axios.post('/api/knowledge_categories', {
                knowledge_category_name: this.knowledge_category_name,
                nav_item: this.knowledge_category_name
            })
                .then(response => {
                    //bei erfolg
                    this.legendCategory = response.data.message;
                    console.log("Erfolgreich gespeichert!");

                })
                .catch(error => {
                    this.legendCategory = error.response.data.error
                    this.legendStyle = 'color: var(--primary-color);';
                });
        }
    }

};
</script>
