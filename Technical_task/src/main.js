// main.js
import Vue from 'vue';
import App from './App.vue';
import router from './router'; // Update the path based on your project structure

new Vue({
  render: h => h(App),
  router, // Add this line to use the router
}).$mount('#app');
