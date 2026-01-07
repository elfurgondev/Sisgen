import { createRouter, createWebHistory } from 'vue-router';
import LeadsList from './components/crm/LeadsList.vue';
import ClientProfile from './components/crm/ClientProfile.vue';
import PropertiesList from './components/crm/PropertiesList.vue';
import PropertyForm from './components/crm/PropertyForm.vue';

const routes = [
    { path: '/leads', component: LeadsList },
    { path: '/clients/:id', component: ClientProfile },
    { path: '/properties', component: PropertiesList },
    { path: '/properties/create', component: PropertyForm },
    { path: '/properties/:id/edit', component: PropertyForm },
    { path: '/', redirect: '/leads' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
