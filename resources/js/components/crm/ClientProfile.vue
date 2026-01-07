<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="mb-6">
      <router-link to="/leads" class="text-gray-500 hover:text-gray-800 text-sm">
        &larr; Back to Leads
      </router-link>
    </div>

    <div v-if="client" class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Profile Card -->
      <div class="bg-white p-6 rounded shadow-sm">
        <div class="flex items-center gap-4 mb-6">
          <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl font-bold">
            {{ client.first_name[0] }}{{ client.last_name[0] }}
          </div>
          <div>
            <h2 class="text-xl font-bold text-gray-800">{{ client.first_name }} {{ client.last_name }}</h2>
            <p class="text-gray-500 text-sm">{{ client.email }}</p>
          </div>
        </div>
        
        <div class="space-y-4">
          <div>
            <label class="text-xs text-gray-500 uppercase">Phone</label>
            <p class="text-gray-800">{{ client.phone || 'N/A' }}</p>
          </div>
          <div>
            <label class="text-xs text-gray-500 uppercase">Status</label>
            <p>
              <span class="px-2 py-1 text-xs bg-gray-100 rounded text-gray-700 border border-gray-200">
                {{ client.status }}
              </span>
            </p>
          </div>
        </div>
        
        <button class="mt-6 w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          Edit Profile
        </button>
      </div>

      <!-- Sales Processes -->
      <div class="md:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded shadow-sm">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Sales Processes</h3>
            <button class="text-sm text-blue-600 font-medium">+ New Sale</button>
          </div>

          <div v-if="client.sales_processes && client.sales_processes.length > 0">
             <div v-for="process in client.sales_processes" :key="process.id" class="border p-4 rounded mb-2">
                <p class="font-bold">Property: {{ process.property ? process.property.name : 'Unknown' }}</p>
                <p class="text-sm text-gray-600">Status: {{ process.status }}</p>
             </div>
          </div>
          <p v-else class="text-gray-500 italic text-sm">No active sales processes.</p>
        </div>
      </div>
    </div>
    <div v-else class="text-center p-12 text-gray-500">
      Loading client profile...
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const client = ref(null);

onMounted(async () => {
  try {
    const response = await axios.get(`/api/clients/${route.params.id}`);
    client.value = response.data;
  } catch (error) {
    console.error('Error fetching client:', error);
  }
});
</script>
