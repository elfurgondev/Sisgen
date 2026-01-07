<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Properties</h1>
      <router-link to="/properties/create" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow-sm">
        Add Property
      </router-link>
    </div>

    <div class="bg-white rounded shadow-sm overflow-hidden">
      <!-- Filters -->
      <div class="p-4 border-b border-gray-100 flex gap-4">
        <input 
          v-model="filters.search" 
          placeholder="Search properties..." 
          class="px-3 py-2 border rounded w-64 focus:outline-none focus:border-blue-500 transition-colors"
        />
        <select v-model="filters.status" class="px-3 py-2 border rounded focus:outline-none focus:border-blue-500 transition-colors">
          <option value="">All Statuses</option>
          <option value="available">Available</option>
          <option value="reserved">Reserved</option>
          <option value="sold">Sold</option>
        </select>
      </div>

      <!-- Table -->
      <table class="w-full text-left">
        <thead>
          <tr class="bg-gray-50 text-gray-600 text-sm uppercase font-semibold">
            <th class="p-4">Code</th>
            <th class="p-4">Name</th>
            <th class="p-4">Price</th>
            <th class="p-4">Status</th>
            <th class="p-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          <tr v-for="property in filteredProperties" :key="property.id" class="hover:bg-gray-50 transition-colors">
            <td class="p-4 text-gray-600 font-mono text-sm">{{ property.code }}</td>
            <td class="p-4 font-medium text-gray-800">{{ property.name }}</td>
            <td class="p-4 text-gray-600">
              {{ new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(property.price) }}
            </td>
            <td class="p-4">
              <span 
                class="px-2 py-1 text-xs font-semibold rounded-full capitalize"
                :class="{
                  'bg-green-100 text-green-800': property.status === 'available',
                  'bg-yellow-100 text-yellow-800': property.status === 'reserved',
                  'bg-red-100 text-red-800': property.status === 'sold'
                }"
              >
                {{ property.status }}
              </span>
            </td>
            <td class="p-4 text-right">
              <router-link :to="`/properties/${property.id}/edit`" class="text-blue-600 hover:text-blue-800 font-medium text-sm mr-3">
                Edit
              </router-link>
            </td>
          </tr>
          <tr v-if="filteredProperties.length === 0">
            <td colspan="5" class="p-12 text-center text-gray-500">
              <div v-if="loading">Loading...</div>
              <div v-else>No properties found matching your criteria.</div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const properties = ref([]);
const loading = ref(true);
const filters = ref({ search: '', status: '' });

const filteredProperties = computed(() => {
  return properties.value.filter(property => {
    const matchesSearch = property.name.toLowerCase().includes(filters.value.search.toLowerCase()) || 
                          property.code.toLowerCase().includes(filters.value.search.toLowerCase());
    const matchesStatus = filters.value.status ? property.status === filters.value.status : true;
    return matchesSearch && matchesStatus;
  });
});

onMounted(async () => {
  try {
    const response = await axios.get('/api/properties');
    properties.value = response.data;
  } catch (error) {
    console.error('Failed to fetch properties:', error);
  } finally {
    loading.value = false;
  }
});
</script>
