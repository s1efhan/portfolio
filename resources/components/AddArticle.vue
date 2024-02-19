<template>
    <section class="addArticle">
        <h2>Artikel hinzufügen</h2>
        <div class="form-container">
            <form class="addArticle-form" @submit.prevent="addArticle">
                <legend :style="legendStyle" v-html="legend"></legend>
                <label for="description">Meta Title:</label>
                <input id="title" type="text" v-model="title" placeholder="Max. 60 characters">
                <label for="description">Meta Description:</label>
                <input id="description" type="text" v-model="description" placeholder="Max. 160 characters">
                <label for="">Author:</label>
                <select id="author" v-model="author">
                    <option v-for="user in users" :key="user.id" :value="user.name">{{ user.name }}</option>
                </select>
                <label for="">Thema:</label>
                <select id="topic_id" v-model="topic_id">
    <option v-for="knowledge_topic in knowledge_topics" :key="knowledge_topic.id"
        :value="knowledge_topic.id">
        {{ knowledge_topic.topic_name }}
    </option>
</select>
                <label for="title_img">Titelbild:</label>
                <input id="title_img" type="file" accept=".png, .jpg, .jpeg" @change="handleFileUpload">
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
            title: '',
            description: '',
            author: '',
            users: [],
            title_img: null,
            content: '',
            length: '',
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
        addArticle() {
            axios.post('/api/addArticle', {
                title: this.title,
                description: this.description,
                author: this.author,
                title_img: this.title_img,
                content: this.content,
                length: this.length,
            })
                .then(response => {
                    //bei erfolg
                    this.legendArticle = response.data.message
                    console.log("Erfolgreich gespeichert!")

                })
                .catch(error => {
                    this.legendArticle = error.response.data.error
                    this.legendStyle = 'color: var(--primary-color);';
                });
        }, handleFileUpload(event) {
            const file = event.target.files[0];
            const allowedTypes = ['image/png', 'image/jpeg'];
            if (!allowedTypes.includes(file.type)) {
                this.legendArticle = 'Nur PNG- und JPEG-Dateien sind erlaubt.';
                this.legendStyle = 'color: var(--error-color);';
                event.target.value = '';
                return;
            }
            if (file.size > 5 * 1024 * 1024) { // Überprüfen Sie die Dateigröße (5 MB)
                this.legendArticle = 'Die Dateigröße darf maximal 5 MB betragen.';
                this.legendStyle = 'color: var(--error-color);';
                event.target.value = '';
                return;
            }
            this.title_img = file;
        },
        compressImage(imageFile) {
            const options = {
                maxSizeMB: 5,
                maxWidthOrHeight: 1920,
                useWebWorker: true
            };
            return imageCompression(imageFile, options);
        },
        fetchUsers() {
            axios.get('/api/users')
                .then(response => {
                    this.users = response.data;
                    this.author = this.users[0].name;
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
},fetchTopics() {
    axios.get('/api/knowledge_topic')
        .then(response => {
            this.knowledge_topics = response.data;
            if (this.knowledge_topics.length > 0) {
                this.topic_id = this.knowledge_topics[0].id;
            }
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
