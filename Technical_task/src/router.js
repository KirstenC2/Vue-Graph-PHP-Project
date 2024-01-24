// router.js
import Vue from 'vue';
import VueRouter from 'vue-router';
import DataTable from './components/DataTable.vue';
import GraphPage from './views/GraphPage.vue'; // Adjust the path

Vue.use(VueRouter);

const routes = [
  { path: '/', component: DataTable },
  { path: '/graph', component: GraphPage },
];

const router = new VueRouter({
  routes,
});

export default router;
