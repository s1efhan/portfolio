<template>
  <main>
    <h1>Skills</h1>
    <div class="skills">
      <div v-for="(categorySkills, category) in sortedSkillsByCategory" :key="category">
        <h3 @click="toggleCategory(category)">{{ category }}</h3>
      </div>
    </div>

    <div class="skills" v-for="(categorySkills, category) in sortedSkillsByCategory" :key="'list-' + category">
        <ul v-show="activeCategory === category">
          <li v-for="skill in categorySkills" :key="skill.id"
            :class="['skill', skill.category, skill.level === 3 ? 'important' : '']">
            {{ skill.name }}
            <span v-for="i in 3" :key="i">
              <span v-if="i <= skill.level">★</span>
              <span v-else>☆</span>
            </span>
          </li>
        </ul>
      </div>
    <SkillspiderPerson v-if="showPersonality" />
    <section v-if="!showPersonality" class="tile skillspider">
      <h2>{{activeCategory}}</h2>
      <canvas id="skillSpiderChart2"></canvas>
    </section>
  </main>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import SkillspiderPerson from './SkillspiderPerson.vue';

const skills = [
  { name: 'JavaScript', category: 'Software', type: "Programmiersprache", id: 1, level: 2 },
  { name: 'Vue.js', category: 'Software', type: "Framework", id: 2, level: 3 },
  { name: 'HTML', category: 'Software', type: "Programmiersprache", id: 3, level: 3 },
  { name: 'CSS', category: 'Software', type: "Programmiersprache", id: 4, level: 2 },
  { name: 'Tableau', category: 'Software', type: "Tool", id: 5, level: 2 },
  { name: 'Laravel', category: 'Software', type: "Framework", id: 6, level: 3 },
  { name: 'KNIME', category: 'Software', type: "Tool", id: 7, level: 2 },
  { name: 'Excel', category: 'Software', type: "Tool", id: 8, level: 2 },
  { name: 'PHP', category: 'Software', type: "Programmiersprache", id: 9, level: 2 },
  { name: 'Rhetorik', category: 'Management', type: "Softskill", id: 10, level: 2 },
  { name: 'SEO', category: 'Medien', type: "Softskill", id: 11, level: 3 },
  { name: 'LateX', category: 'Software', type: "Programmiersprache", id: 12, level: 1 },
  { name: 'Photoshop', category: 'Medien', type: "Tool", id: 13, level: 1 },
  { name: 'Davinci Resolve', category: 'Medien', type: "Tool", id: 14, level: 2 },
  { name: 'Tontechnik', category: 'Medien', type: "Fähigkeit", id: 15, level: 1 },
  { name: 'Kameratechnik', category: 'Medien', type: "Fähigkeit", id: 16, level: 3 },
  { name: 'Videoschnitt', category: 'Medien', type: "Fähigkeit", id: 17, level: 2 },
  { name: 'Python', category: 'Software', type: "Programmiersprache", id: 18, level: 1 },
  { name: 'ASANA', category: 'Management', type: "Tool", id: 19, level: 2 },
  { name: 'Github', category: 'Management', type: "Tool", id: 20, level: 2 },
  { name: 'Requirements Engineering', category: 'Management', type: "Methode", id: 21, level: 2 },
  { name: 'Zeitmanagement', category: 'Management', type: "Methode", id: 22, level: 2 },
  

];
const showPersonality = ref(true)
const sortedSkillsByCategory = computed(() => {
  const grouped = {};
  skills.forEach(skill => {
    if (!grouped[skill.category]) {
      grouped[skill.category] = [];
    }
    grouped[skill.category].push(skill);
  });

  for (const category in grouped) {
    grouped[category].sort((a, b) => b.level - a.level);
  }

  return grouped;
});

const activeCategory = ref(null);

function toggleCategory(category) {
  activeCategory.value = activeCategory.value === category ? null : category;
  showPersonality.value = activeCategory.value === null;

  if (activeCategory.value !== null) {
    const categorySkills = sortedSkillsByCategory.value[activeCategory.value];
    data.labels = categorySkills.map(skill => skill.name);
    data.datasets[0].label = activeCategory.value;

    data.datasets[0].data = categorySkills.map(skill => skill.level);
  } else {
    data.labels = [];
    data.datasets[0].label = [];
    data.datasets[0].data = [];
  }
  const script = document.createElement('script');
  script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
  script.onload = initializeChart;
  document.head.appendChild(script);
}
function initializeChart() {
  const ctx = document.getElementById('skillSpiderChart2').getContext('2d');

  chart = new Chart(ctx, config);
}
const data = {
  labels: [],
  datasets: [{
    label: '',
    data: [],
    fill: true,
    backgroundColor: 'rgba(250, 250, 250, 0.2)',
    borderColor: 'rgb(250, 180, 100)',
    pointBackgroundColor: 'rgb(0,0,0,0)',
    pointBorderColor: 'rgb(0,0,0,0)',
    pointHoverBackgroundColor: 'rgb(0,0,0,0)',
    pointHoverBorderColor: 'rgb(250, 180, 100)'
  }]
};
const config = {
  type: 'radar',
  data: data,
  options: {
    plugins: {
      legend: {
        display: false
      }
    },
    elements: {
      line: {
        borderWidth: 5
      }
    },
    scales: {
      r: {
        grid: {
          display: false
        },
        angleLines: {
          display: true,
          color: 'white'
        },
        pointLabels: {
          color: '#EAEBE7',
        },
        suggestedMin: 0,
        suggestedMax: 3,
        ticks: {
          display: false
        }
      }
    },
    color: 'white',
    responsive: true,
  }
};

let chart;

</script>
