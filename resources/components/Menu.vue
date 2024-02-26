<template>
  <div class="fixed-wrapper">
    <nav class="desktop-nav">
      <ul>
        <li @mouseleave="checkActiveRoute" :class="isActive('/projekte')">
          <router-link to="/projekte" @mouseover="removeActiveClass">Projekte</router-link>
        </li>
        <li @mouseleave="checkActiveRoute" :class="isActive('/wissen')">
          <router-link to="/wissen" class="desktop-menu" @mouseover="removeActiveClass">
            Wissen
          </router-link>
        </li>
        <li @mouseleave="checkActiveRoute" class="home" :class="isActive('/')">
          <router-link to="/" @mouseover="removeActiveClass" class="desktop-menu">Home
          </router-link>
        </li>
        <li @mouseleave="checkActiveRoute" :class="isActive('/kontakt')">
          <router-link to="/kontakt" @mouseover="removeActiveClass">Kontakt</router-link>
        </li>
      </ul>
    </nav>

    <nav class="mobile-nav">
      <ul class="hamburger">
        <li @click="toggleHamburger" class="visible toggleHamburger"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 122.879 103.609" width="122.879px" height="103.609px"
            enable-background="new 0 0 122.879 103.609">
            <g>
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M10.368,0h102.144c5.703,0,10.367,4.665,10.367,10.367v0 c0,5.702-4.664,10.368-10.367,10.368H10.368C4.666,20.735,0,16.07,0,10.368v0C0,4.665,4.666,0,10.368,0L10.368,0z M10.368,82.875 h102.144c5.703,0,10.367,4.665,10.367,10.367l0,0c0,5.702-4.664,10.367-10.367,10.367H10.368C4.666,103.609,0,98.944,0,93.242l0,0 C0,87.54,4.666,82.875,10.368,82.875L10.368,82.875z M10.368,41.438h102.144c5.703,0,10.367,4.665,10.367,10.367l0,0 c0,5.702-4.664,10.368-10.367,10.368H10.368C4.666,62.173,0,57.507,0,51.805l0,0C0,46.103,4.666,41.438,10.368,41.438 L10.368,41.438z" />
            </g>
          </svg>

        </li>
        <li @click="toggleHamburger" class="invisible toggleHamburger"> <svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 122.878 122.88" width="122.878px" height="122.88px" enable-background="new 0 0 122.878 122.88">
            <g>
              <path
                d="M1.426,8.313c-1.901-1.901-1.901-4.984,0-6.886c1.901-1.902,4.984-1.902,6.886,0l53.127,53.127l53.127-53.127 c1.901-1.902,4.984-1.902,6.887,0c1.901,1.901,1.901,4.985,0,6.886L68.324,61.439l53.128,53.128c1.901,1.901,1.901,4.984,0,6.886 c-1.902,1.902-4.985,1.902-6.887,0L61.438,68.326L8.312,121.453c-1.901,1.902-4.984,1.902-6.886,0 c-1.901-1.901-1.901-4.984,0-6.886l53.127-53.128L1.426,8.313L1.426,8.313z" />
            </g>
          </svg>

        </li>
      </ul>
      <ul @click="toggleHamburger" class="hamburger-items">
        <li class="invisible hamburger-menu-item">
          <router-link to="/projekte">Projekte
          </router-link>
        </li>
        <li class="invisible hamburger-menu-item">

          <router-link to="/wissen">Wissen</router-link>
        </li>
        <li class="invisible hamburger-menu-item">


          <router-link to="/">
            Home</router-link>
        </li>
        <li class="invisible hamburger-menu-item">

          <router-link to="/kontakt">Kontakt
          </router-link>
        </li>
      </ul>
    </nav>
  </div>
</template>
  
<script>
import { useRoute } from 'vue-router';

export default {
  setup() {
    const route = useRoute();

    const isActive = (url) => {
      return route.path === url ? 'menu_active' : 'menu_inactive';
    }
    const toggleHamburger = () => {
  const invisibleElements = document.querySelectorAll('.invisible');
  const visibleElements = document.querySelectorAll('.visible');

  // Toggle visibility for elements with class invisible
  invisibleElements.forEach(element => {
    element.classList.remove('invisible');
    element.classList.add('visible');
  });

  // Toggle visibility for elements with class visible
  visibleElements.forEach(element => {
    element.classList.remove('visible');
    element.classList.add('invisible');
  });

  // Toggle background class for hamburger element
  const hamburger = document.querySelector('.mobile-nav');
  hamburger.classList.toggle('background');
};


    const removeActiveClass = () => {

      const activeItems = document.querySelectorAll('.menu_active');
      activeItems.forEach(item => {
        item.classList.remove('menu_active');
        item.classList.add('menu_inactive');
      });
    }
    const checkActiveRoute = () => {
      const activeItems = document.querySelectorAll('.menu_active');
      activeItems.forEach(item => {
        item.classList.remove('menu_active');
        item.classList.add('menu_inactive');
      });

      const currentPath = route.path;
      const currentMenuItem = document.querySelector(`[href="${currentPath}"]`);
      if (currentMenuItem) {
        currentMenuItem.parentNode.classList.add('menu_active');
        currentMenuItem.parentNode.classList.remove('menu_inactive');
      }
    };
    return {
      isActive,
      removeActiveClass,
      checkActiveRoute, toggleHamburger
    };
  }
}
</script>