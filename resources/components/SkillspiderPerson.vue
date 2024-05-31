<template>
    <section class="tile skillspider">
      <h2>Persönlichkeit</h2>
      <canvas id="skillSpiderChart"></canvas>
    </section>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  
  const compassionValue = ref(72);
  const politenessValue = ref(21);
  const diligenceValue = ref(67);
  const orderlinessValue = ref(84);
  const enthusiasmValue = ref(36);
  const abilityValue = ref(52);
  const withdrawalValue = ref(67);
  const volatilityValue = ref(38);
  const opennessValue = ref(67);
  const intellectValue = ref(84);
  
  const data = {
    labels: [
      'Mitgefühl',
      'Höflichkeit',
      'Fleiß',
      'Ordentlichkeit',
      'Enthusiasmus',
      'Durchsetzungsvermögen',
      'Rückzug',
      'Volatilität',
      'Offenheit',
      'Intellekt'
    ],
    datasets: [{
      label: [],
      data: [
        compassionValue.value,
        politenessValue.value,
        diligenceValue.value,
        orderlinessValue.value,
        enthusiasmValue.value,
        abilityValue.value,
        withdrawalValue.value,
        volatilityValue.value,
        opennessValue.value,
        intellectValue.value
      ],
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
          suggestedMax: 100,
          ticks: {
            display: false
          }
        }
      },
      color: 'white',
      responsive: true
    }
  };
  
  let chart;
  
  onMounted(() => {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
    script.onload = () => {
      const ctx = document.getElementById('skillSpiderChart').getContext('2d');
      chart = new Chart(ctx, config);
    };
    document.head.appendChild(script);
  });
  </script>