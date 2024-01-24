<template>
    <div class="custom-pagination">
      <button @click="goToPage(1)" :disabled="currentPage === 1">First</button>
      <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">Previous</button>
  
      <span>{{ currentPage }} / {{ totalPages }}</span>
  
      <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
      <button @click="goToPage(totalPages)" :disabled="currentPage === totalPages">Last</button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      currentPage: Number,
      totalPages: Number,
    },
    methods: {
      goToPage(page) {
        if (page >= 1 && page <= this.totalPages) {
          this.$emit('update-page', page);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  .custom-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
  }
  
  button {
    padding: 5px 10px;
    cursor: pointer;
  }
  </style>
  