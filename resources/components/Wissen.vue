<script setup>
import Breadcrumps from './Breadcrumps.vue';
import AddArticle from './AddArticle.vue';
</script>
<template>
        <header>
                <Breadcrumps></Breadcrumps>
                <h1>Wissen</h1>
        </header>
        <main>

                <section class="blog">
                        <h3>Test-H3</h3>
                        <p>wichtiger Absatz mit einigen Worten um zu testen wie die <a
                                        href="https://instagram.com/stefann.th">Hintergrundfarbe</a> so aussieht in einem</p>
                        <ul>
                                <li>normalen Text</li>
                                <li>mit Liste</li>
                        </ul>
                        <p>und weiteren Worten und Absätzen</p>
                        <button class="primary_button">Button</button>
                        <br>
                        <button class="secondary_button">Button</button>
                        <br>
                        <button class="accent_button">Button</button>
                </section>
                <AddArticle></AddArticle>
        </main>
</template>