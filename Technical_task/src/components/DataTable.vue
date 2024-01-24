<template>
  
    <div>

      <div>
      <label for="countryFilter">Filter by Country:</label>
      <input
        type="text"
        id="countryFilter"
        v-model="filterCountry"
        @input="applyFilter"
      />
    </div>
      <table v-if="filteredData.length > 0">
        <thead>
          <tr>
            <th>Open</th>
            <th>High</th>
            <th>Low</th>
            <th>Close</th>
            <th>Inflation</th>
            <th>Country</th>
            <th>ISO3</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in filteredData" :key="index">
            <td>{{ item.Open }}</td>
            <td>{{ item.High }}</td>
            <td>{{ item.Low }}</td>
            <td>{{ item.Close }}</td>
            <td>{{ item.Inflation }}</td>
            <td>{{ item.country }}</td>
            <td>{{ item.ISO3 }}</td>
            <td>{{ item.date }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else-if="loading">Loading data...</div>
      <div v-else>No data available.</div>
        <pagination-control
        v-if="filteredData.length > 0"
        :current-page="currentPage"
        :total-pages="totalPages"
        @update-page="updatePage"
        ></pagination-control>
    </div>
  </template>
  
<script>
import PaginationControl from './PaginationControl.vue';

export default {
  props: {
    data: Array,
    loading: Boolean,
  },
  data() {
    return {
      itemsPerPage: 20,
      currentPage: 1,
      filterCountry: '', 
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.data.length / this.itemsPerPage);
    },
    filteredData() {
      // Apply the country filter
      const filteredByCountry = this.data.filter(item => {
        return item.country.toLowerCase().includes(this.filterCountry.toLowerCase());
      });

      // Paginate the filtered data
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      return filteredByCountry.slice(startIndex, endIndex);
    },

  },
  methods: {
    updatePage(page) {
      this.currentPage = page;
    },
    applyFilter() {
      // When the filter input changes, update the pagination and reapply the filter
      this.currentPage = 1;
    },
  },
  components: {
    PaginationControl,
  },
};
</script>
  
  <style scoped>
  table {
    border-collapse: collapse;
    width: 100%;
  }
  
  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  
  th {
    background-color: #f2f2f2;
  }
  </style>
  