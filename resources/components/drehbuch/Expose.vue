<template>
  <form action="/generate-script" method="post">

    <div class="zeitstrahl">
      <label class="act" for="act">
        <ul>
          <li>I.</li>
          <li>II.</li>
          <li>III.</li>
        </ul>
      </label>
      <input @input="updateSlider" value="16" type="range" id="act" name="act" min="0" max="100">

      <div class="lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
    </div>

    <input type="submit" value="Weiter">

  </form>


  <div class="drop-zone" @drop="onDrop($event, 1)" @dragenter.prevent @dragover.prevent>
    <div v-for="item in getList(1)" :key="item.id" class="drag-el" draggable="true"
      @dragstart="startDrag($event, item)">
      <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.96 122.88">
        <title>3-vertical-dots</title>
        <path fill-rule="evenodd"
          d="M15,0A15,15,0,1,1,0,15,15,15,0,0,1,15,0Zm0,92.93a15,15,0,1,1-15,15,15,15,0,0,1,15-15Zm0-46.47a15,15,0,1,1-15,15,15,15,0,0,1,15-15Z" />
      </svg>
      <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.96 122.88">
        <title>3-vertical-dots</title>
        <path fill-rule="evenodd"
          d="M15,0A15,15,0,1,1,0,15,15,15,0,0,1,15,0Zm0,92.93a15,15,0,1,1-15,15,15,15,0,0,1,15-15Zm0-46.47a15,15,0,1,1-15,15,15,15,0,0,1,15-15Z" />
      </svg>
      {{ item.title }}
    </div>
  </div>
  <div class="drop-zone" @drop="onDrop($event, 2)" @dragenter.prevent @dragover.prevent>
    <div v-for="item in getList(2)" :key="item.id" class="drag-el" draggable="true"
      @dragstart="startDrag($event, item)">
      <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.96 122.88">
        <title>3-vertical-dots</title>
        <path fill-rule="evenodd"
          d="M15,0A15,15,0,1,1,0,15,15,15,0,0,1,15,0Zm0,92.93a15,15,0,1,1-15,15,15,15,0,0,1,15-15Zm0-46.47a15,15,0,1,1-15,15,15,15,0,0,1,15-15Z" />
      </svg>
      <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.96 122.88">
        <title>3-vertical-dots</title>
        <path fill-rule="evenodd"
          d="M15,0A15,15,0,1,1,0,15,15,15,0,0,1,15,0Zm0,92.93a15,15,0,1,1-15,15,15,15,0,0,1,15-15Zm0-46.47a15,15,0,1,1-15,15,15,15,0,0,1,15-15Z" />
      </svg>
      {{ item.title }}
    </div>
  </div>
</template>
<script setup>
import { ref } from 'vue';
const items = ref([
  { id: 0, title: 'Item A', list: 1 },
  { id: 1, title: 'Item B', list: 1 },
  { id: 2, title: 'Item C', list: 2 },
]);
const getList = (list) => {
  return items.value.filter((item) => item.list === list);
};
const updateSlider = () => {
  var slider = document.getElementById("act");
  var value = parseInt(slider.value);

  if (value < 25) {
    slider.value = 16;
  } else if (value > 70) {
    slider.value = 84;
  } else {
    slider.value = 50;
  }
}

const startDrag = (event, item) => {
  console.log(item);
  event.dataTransfer.dropEffect = 'move';
  event.dataTransfer.effectAllowed = 'move';
  event.dataTransfer.setData('itemID', item.id);
};

const onDrop = (event, list) => {
  const itemID = event.dataTransfer.getData('itemID');
  const item = items.value.find((item) => item.id == itemID);
  item.list = list;
};
</script>