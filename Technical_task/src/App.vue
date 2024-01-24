<template>
  <div id="app">
    <header>
      <h1>All Countries Inflation data</h1>
    </header>
    
    <main>
      <!-- Use DataTable and GraphPage components in the template -->
      <DataTable :data="tableData" :loading="loading" />
      <GraphPage :graphData="graphData" />
    </main>
  </div>
</template>

<script>
import DataTable from './components/DataTable.vue';
import GraphPage from './views/GraphPage.vue';

export default {
  name: 'App',
  components: {
    DataTable,
    GraphPage,
  },
  data() {
    return {
      tableData: [],
      graphData: [], // Populate this data with the graph data
      loading: true,
    };
  },
  mounted() {
    // Fetch data from the API endpoint
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await fetch('http://localhost/Technical_task/backend/database.php?endpoint=getItems');
        const data = await response.json();
        this.tableData = data.data;
        this.loading = false;
      } catch (error) {
        console.error('Error fetching data:', error);
        this.loading = false;
      }
    },
  },
};
</script>


