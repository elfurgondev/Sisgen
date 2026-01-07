import { createRouter, createWebHistory } from 'vue-router';
import LeadsList from './components/crm/LeadsList.vue';
import ClientProfile from './components/crm/ClientProfile.vue';

const routes = [
    { path: '/leads', component: LeadsList },
    { path: '/clients/:id', component: ClientProfile },
    { path: '/', redirect: '/leads' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
