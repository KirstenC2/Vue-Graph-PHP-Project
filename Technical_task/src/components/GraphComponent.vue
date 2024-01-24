<template>
  <div>
    <h2>Yearly Inflation Graph</h2>
    <v-chart :options="chartOptions" style="width: 95%;height:600px"></v-chart>
  </div>
</template>

<script>
import VueECharts from 'vue-echarts';

export default {
  components: {
    'v-chart': VueECharts,
  },
  props: {
    graphData: Array,
  },
  data() {
    return {
      chartOptions: {},
    };
  },
  watch: {
    graphData: 'updateGraph',
  },
  mounted() {
    // Update the graph when the component is mounted
    this.updateGraph();
  },
  methods: {
    updateGraph() {
      const chartData = this.processDataForChart(this.graphData);
      this.chartOptions = {
        title: {
          text: 'Yearly Inflation by Country',
          x: 'center',
        },
        tooltip: {
          trigger: 'axis',
        },
        legend: {
          data: chartData.legend,
          x: 'center',
          y: 'bottom',
        },
        xAxis: {
          type: 'category',
          data: chartData.xAxis,
          axisLabel: {
            interval: 0,
            rotate: 45,
          },
        },
        yAxis: {
          type: 'value',
          name: 'Yearly Inflation (%)',
        },
        series: chartData.series,
      };
    },
    processDataForChart(rawData) {
      const countries = [...new Set(rawData.map(item => item.country))];
      const years = [...new Set(rawData.map(item => item.year))];
      const legend = countries;
      const xAxis = years;
      const series = countries.map(country => {
        return {
          name: country,
          type: 'bar',
          data: years.map(year => {
            const entries = rawData.filter(item => item.country === country && item.year === year && item.yearly_inflation !== null);
            return entries.length > 0 ? entries[0].yearly_inflation.toFixed(2) : 0;
          }),
        };
      });
      return { legend, xAxis, series };
    },
  },
};
</script>

