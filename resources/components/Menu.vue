<template>
    <nav>
      <ul> <li v-if= "userData" class="invisible login" @click="logout">{{userData.name  }} <br>Abmelden</li>
    
       <li v-else= "!userData" ><RouterLink to="/login" @click="toggleHamburger" class="invisible login">Anmelden
          </RouterLink></li></ul>
      <ul class="toggleHamburger">
        <li @click="toggleHamburger" class="visible"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 122.879 103.609" width="122.879px" height="103.609px"
            enable-background="new 0 0 122.879 103.609">
            <g>
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M10.368,0h102.144c5.703,0,10.367,4.665,10.367,10.367v0 c0,5.702-4.664,10.368-10.367,10.368H10.368C4.666,20.735,0,16.07,0,10.368v0C0,4.665,4.666,0,10.368,0L10.368,0z M10.368,82.875 h102.144c5.703,0,10.367,4.665,10.367,10.367l0,0c0,5.702-4.664,10.367-10.367,10.367H10.368C4.666,103.609,0,98.944,0,93.242l0,0 C0,87.54,4.666,82.875,10.368,82.875L10.368,82.875z M10.368,41.438h102.144c5.703,0,10.367,4.665,10.367,10.367l0,0 c0,5.702-4.664,10.368-10.367,10.368H10.368C4.666,62.173,0,57.507,0,51.805l0,0C0,46.103,4.666,41.438,10.368,41.438 L10.368,41.438z" />
            </g>
          </svg>

        </li>
        <li @click="toggleHamburger" class="invisible"> <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 122.878 122.88" width="122.878px" height="122.88px" enable-background="new 0 0 122.878 122.88">
            <g>
              <path
                d="M1.426,8.313c-1.901-1.901-1.901-4.984,0-6.886c1.901-1.902,4.984-1.902,6.886,0l53.127,53.127l53.127-53.127 c1.901-1.902,4.984-1.902,6.887,0c1.901,1.901,1.901,4.985,0,6.886L68.324,61.439l53.128,53.128c1.901,1.901,1.901,4.984,0,6.886 c-1.902,1.902-4.985,1.902-6.887,0L61.438,68.326L8.312,121.453c-1.901,1.902-4.984,1.902-6.886,0 c-1.901-1.901-1.901-4.984,0-6.886l53.127-53.128L1.426,8.313L1.426,8.313z" />
            </g>
          </svg>

        </li>
      </ul>
      <ul class="nav-links" >
        <SearchComponent/>
        <li @click="toggleHamburger" class="home invisible">
          <RouterLink to="/">Home
          </RouterLink>
        </li>
        <li @click="toggleHamburger" class=" projekte invisible">
          <RouterLink to="/projekte" >Projekte</RouterLink>
        </li>
        <li @click="toggleHamburger" class="wissen invisible">
          <RouterLink to="/wissen">
            Wissen
          </RouterLink>
        </li>
       <li @click="toggleHamburger" class="kontakt invisible nav-cta"> <RouterLink to="/kontakt"><button class="primary-button">Kontaktiere mich!</button></RouterLink></li>
       <li @click="downloadCensoredCv" class="lebenslauf invisible nav-cta"> <RouterLink to="/lebenslauf"><button class="secondary-button">Download CV!</button></RouterLink></li>

      </ul>
    </nav>
    
    
</template>
  
<script setup>
import axios from 'axios';
import { defineEmits } from 'vue';
import SearchComponent from '../components/SearchComponent.vue';
const emit = defineEmits(['update:user-data']);

const downloadCensoredCv = () => {
    axios.get('/download-censoredCV', {
       responseType: 'blob'
    }).then(response => {
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'Lebenslauf_Stefan_Theissen_zensiert.pdf');
        document.body.appendChild(link);
        link.click();
    }).catch(error => {
        console.error('Fehler beim Abrufen des Lebenslauf:', error);
    });
}

const props = defineProps({
  userData: Object,
  fetchUserData: Function
});
    const logout = () => {
      axios.post('/logout')
        .then(response => {
          props.fetchUserData();
          console.log("Erfolgreich abgemeldet");
          toggleHamburger();
          emit('update:user-data', null);
        })
        .catch(error => {
          console.error("Ausloggen fehlgeschlagen:", error);
        });
    };
  const  toggleHamburger = () =>{

      const invisibleElements = document.querySelectorAll('.invisible');
      const visibleElements = document.querySelectorAll('.visible');

      // Sichtbarkeit der Elemente mit Klasse "invisible" umschalten
      invisibleElements.forEach(element => {
        element.classList.remove('invisible');
        element.classList.add('visible');
      });
      const nav = document.querySelector('nav');
    if (nav.style.zIndex === '1') {
    nav.style.zIndex = '0';
  } else {
    nav.style.zIndex = '1';
  }
      // Sichtbarkeit der Elemente mit Klasse "visible" umschalten
      visibleElements.forEach(element => {
        element.classList.remove('visible');
        element.classList.add('invisible');
      });

      // Hintergrundklasse für das Hamburger-Element umschalten
      const hamburger = document.querySelector('nav');
      hamburger.classList.toggle('backgroundOn');
    };
</script>
