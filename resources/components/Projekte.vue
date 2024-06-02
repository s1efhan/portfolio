<template>
    <main>
        <h1>Projekte</h1>
        <ul class="projekte">
            <li v-if="!showDetails"  class="ki-autor">
                <p class="jahreszahl">2024</p><a href="/story-telling">
                    <h3>KI Drehbuch Autor</h3>
                    <p>eigenes Projekt</p>
                </a>
            </li>
            <li @click="showDetails = !showDetails" class="chocobrain">
                <p class="jahreszahl">2023</p>
                <h3>ChocoBRAIN</h3>
                <p v-if="!showDetails">Werkstudent im Online Marketing
                </p>
                <p v-if="showDetails">270% Steigerung der CTR & 35% höhere Platzierung im Google Ranking
                </p>   
            </li>
         
            <div v-if="showDetails" class="project-details">
                    <a href="https://chocobrain.com/learning-center">
                        <canvas id="chocobrainChart1"></canvas>
                    </a>
  
                </div>
                <div v-if="showDetails" class="project-details">
                  
                    <a href="https://chocobrain.com/learning-center">
                        <canvas id="chocobrainChart2"></canvas>
                    </a>
                </div> <li class="onlyDesktop" v-if="showDetails"></li>
                
                <li v-if="showDetails"  class="ki-autor">
                <p class="jahreszahl">2024</p><a href="/story-telling">
                    <h3>KI Drehbuch Autor</h3>
                    <p>eigenes Projekt</p>
                </a>
            </li> <li class="onlyDesktop" v-if="showDetails"></li> <li class="onlyDesktop" v-if="showDetails"></li><li class="onlyDesktop" v-if="showDetails"></li>
                <li class="emensa">
                <p class="jahreszahl">2022</p><a href="/emensa">
                    <h3>E-Mensa </h3>
                    <p>Uni Projekt - Datenbanken und Webtechnologien</p>
                </a>
            </li>
            <li class="onlyDesktop" v-if="showDetails"></li><li class="onlyDesktop" v-if="showDetails"></li><li class="onlyDesktop" v-if="showDetails"></li>
            <li class="finanzwissen">
                <p class="jahreszahl">2021</p><a href="https://finanzwissen.de/autor/stefan">
                    <h3>Finanzwissen</h3>
                    <p>Freiberufliche Autorentätigkeit</p>
                </a>
            </li>
            <li class="onlyDesktop" v-if="showDetails"></li><li class="onlyDesktop" v-if="showDetails"></li><li class="onlyDesktop" v-if="showDetails"></li>
            <li class="onlyDesktop" v-if="!showDetails"></li><li class="onlyDesktop" v-if="!showDetails"></li><li class="onlyDesktop" v-if="!showDetails"></li><li class="onlyDesktop" v-if="!showDetails"></li>
          </ul>
 
    </main>
</template>

<script setup>
import { ref, watch } from 'vue';

const showDetails = ref(false);
let chart; // declare chart variable

// Declare data before using it in config
const months = ['APR', 'JUN', 'AUG', 'OKT', 'DEZ', 'FEB'];

// Get the current month index
const currentMonthIndex = new Date().getMonth();

// Generate labels for the last 7 months
const labels = [];
for (let i = 0; i < 7; i++) {
  const index = (currentMonthIndex - i + 12) % 12; // Ensure positive index
  labels.unshift(months[index]);
}

const data = {
  labels: labels,
  datasets: [{
    label: 'CTR',
    data: [0.4, 0.4, 0.9, 1.1, 1.4, 1.99, 1.6],
    fill: false,
    borderColor: 'white',
    tension: 0.1
  }]
};

const data2 = {
  labels: labels,
  datasets: [{
    label: 'SEO Ranking',
    data: [63, 63, 57, 50, 52, 50, 41],
    fill: false,
    borderColor: '#f32a5f',
    tension: 0.1
  }]
};

const config = {
  type: 'line',
  data: data,options: {
    plugins: {legend: { display:false}},
    
  }
};
const config2 = {
  type: 'line',
  data: data2,
  options: {
    plugins: {legend: { display:false}},
    scales: {
      y: {
        reverse: true // Reverse the Y-axis
      }
    }
  }
};

function initializeChart() {
  const ctx = document.getElementById('chocobrainChart1').getContext('2d');
  const ctx2 = document.getElementById('chocobrainChart2').getContext('2d');
  chart = new Chart(ctx, config);
  chart = new Chart(ctx2, config2);
}

watch(showDetails, (newVal) => {
  if (newVal) {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
    script.onload = initializeChart;
    document.head.appendChild(script);
  }
});
</script>
