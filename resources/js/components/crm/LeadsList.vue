<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Leads Management</h1>
      <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Add New Lead
      </button>
    </div>

    <div class="bg-white rounded shadow-sm overflow-hidden">
      <div class="p-4 border-b border-gray-100 flex gap-4">
        <input 
          v-model="filters.search" 
          placeholder="Search leads..." 
          class="px-3 py-2 border rounded w-64 focus:outline-none focus:border-blue-500"
        />
        <select v-model="filters.status" class="px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
          <option value="">All Statuses</option>
          <option value="lead">Lead</option>
          <option value="prospect">Prospect</option>
          <option value="customer">Customer</option>
        </select>
      </div>

      <table class="w-full text-left">
        <thead>
          <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
            <th class="p-4">Name</th>
            <th class="p-4">Email</th>
            <th class="p-4">Phone</th>
            <th class="p-4">Status</th>
            <th class="p-4">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="lead in leads" :key="lead.id" class="border-b border-gray-100 hover:bg-gray-50">
            <td class="p-4 font-medium">{{ lead.first_name }} {{ lead.last_name }}</td>
            <td class="p-4 text-gray-600">{{ lead.email }}</td>
            <td class="p-4 text-gray-600">{{ lead.phone }}</td>
            <td class="p-4">
              <span 
                class="px-2 py-1 text-xs rounded-full"
                :class="{
                  'bg-yellow-100 text-yellow-800': lead.status === 'lead',
                  'bg-blue-100 text-blue-800': lead.status === 'prospect',
                  'bg-green-100 text-green-800': lead.status === 'customer'
                }"
              >
                {{ lead.status }}
              </span>
            </td>
            <td class="p-4">
              <router-link :to="`/clients/${lead.id}`" class="text-blue-600 hover:underline">
                View
              </router-link>
            </td>
          </tr>
          <tr v-if="leads.length === 0">
            <td colspan="5" class="p-8 text-center text-gray-500">No leads found.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const leads = ref([]);
const filters = ref({ search: '', status: '' });

onMounted(async () => {
  try {
    const response = await axios.get('/api/leads');
    leads.value = response.data;
  } catch (error) {
    console.error('Failed to fetch leads:', error);
  }
});
</script>
