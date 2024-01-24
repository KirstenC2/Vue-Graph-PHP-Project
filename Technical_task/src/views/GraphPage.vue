<template>
    <div>
      <h2>Graph Page</h2>
      <div>
        <label for="country">Select Country:</label>
        <select v-model="selectedCountry" @change="fetchGraphData">
          <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
        </select>
      </div>
      <GraphComponent :graphData="graphData" />
    </div>
  </template>
  
  <script>
  import GraphComponent from '@/components/GraphComponent.vue';
  
  export default {
    data() {
      return {
        graphData: [],
        selectedCountry: '',
        countries: [], // Populate this array with available countries
      };
    },
    components: {
      GraphComponent,
    },
    methods: {
      async fetchGraphData() {
        try {
          const response = await fetch(`http://localhost/Technical_task/backend/database.php?endpoint=getGraphData&country=${this.selectedCountry}`);
          const data = await response.json();
          this.graphData = data.data;
        } catch (error) {
          console.error('Error fetching graph data:', error);
        }
      },
      async fetchCountries() {
        try {
          const response = await fetch(`http://localhost/Technical_task/backend/database.php?endpoint=getCountries`);
          const data = await response.json();
          this.countries = data.data;
        } catch (error) {
          console.error('Error fetching countries:', error);
        }
      },
    },
    mounted() {
      // Fetch initial list of countries and graph data when the component is mounted
      this.fetchCountries();
      this.fetchGraphData();
    },
  };
  </script>
  