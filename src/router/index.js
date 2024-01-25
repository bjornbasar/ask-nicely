import { createRouter, createWebHistory } from 'vue-router'
import ListPage from '../views/ListPage.vue';
import UploadPage from '../views/UploadPage.vue';
import EditPage from '../views/EditPage.vue';
import CompanyAveragePageVue from '../views/CompanyAveragePage.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/list' }, // Redirect to list page by default
    { path: '/list', component: ListPage },
    { path: '/upload', component: UploadPage },
    { path: '/edit/:id', component: EditPage },
    { path: '/company-average', component: CompanyAveragePageVue },
  ]
})

export default router
