<template>
    <nav>
      <ul>
        <li @mouseleave="checkActiveRoute"  :class="isActive('/')"><router-link to="/" @mouseover="removeActiveClass">Home</router-link></li>
        <li @mouseleave="checkActiveRoute"  :class="isActive('/projekte')" ><router-link to="/projekte" @mouseover="removeActiveClass">Projekte</router-link></li>
        <li @mouseleave="checkActiveRoute"  :class="isActive('/wissen')"><router-link to="/wissen" @mouseover="removeActiveClass">Wissen</router-link></li>
        <li @mouseleave="checkActiveRoute"  :class="isActive('/kontakt')"><router-link to="/kontakt" @mouseover="removeActiveClass">Kontakt</router-link></li>
      </ul>
    </nav>
  </template>
  
  <script>
  import { useRoute } from 'vue-router';
  
  export default {
    setup() {
      const route = useRoute();
  
      const isActive = (url) => {
        return route.path === url ? 'menu_active' : 'menu_inactive';
      }

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
        checkActiveRoute
      };
    }
  }
  </script>