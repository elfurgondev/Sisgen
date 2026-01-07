<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-2xl mx-auto bg-white rounded shadow-sm overflow-hidden">
      <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">{{ isEditing ? 'Edit Property' : 'New Property' }}</h1>
        <router-link to="/properties" class="text-gray-500 hover:text-gray-700">Cancel</router-link>
      </div>
      
      <form @submit.prevent="submit" class="p-6 space-y-6">
        <!-- Display general errors -->
        <div v-if="error" class="bg-red-50 text-red-700 p-4 rounded text-sm mb-4">
          {{ error }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
            <input 
              v-model="form.code" 
              required
              type="text" 
              class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500 transition-colors"
              placeholder="PROP-001"
            >
          </div>
          
          <div class="col-span-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
            <input 
              v-model="form.price" 
              required
              type="number"
              step="0.01" 
              class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500 transition-colors"
              placeholder="0.00"
            >
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input 
            v-model="form.name" 
            required
            type="text" 
            class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500 transition-colors"
            placeholder="Property Name"
          >
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
          <select 
            v-model="form.status" 
            class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500 transition-colors"
          >
            <option value="available">Available</option>
            <option value="reserved">Reserved</option>
            <option value="sold">Sold</option>
          </select>
        </div>

        <div class="pt-4 flex justify-end">
          <button 
            type="submit" 
            :disabled="saving"
            class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow-sm disabled:opacity-50"
          >
            {{ saving ? 'Saving...' : (isEditing ? 'Update Property' : 'Create Property') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const isEditing = computed(() => !!route.params.id);
const saving = ref(false);
const error = ref(null);

const form = ref({
  code: '',
  name: '',
  price: '',
  status: 'available'
});

onMounted(async () => {
  if (isEditing.value) {
    try {
      const { data } = await axios.get(`/api/properties/${route.params.id}`);
      form.value = {
        code: data.code,
        name: data.name,
        price: data.price,
        status: data.status
      };
    } catch (e) {
      error.value = "Failed to load property details.";
      console.error(e);
    }
  }
});

const submit = async () => {
  saving.value = true;
  error.value = null;
  
  try {
    if (isEditing.value) {
      await axios.put(`/api/properties/${route.params.id}`, form.value);
    } else {
      await axios.post('/api/properties', form.value);
    }
    router.push('/properties');
  } catch (e) {
    if (e.response && e.response.data && e.response.data.message) {
      error.value = e.response.data.message;
    } else {
      error.value = "An error occurred while saving.";
    }
    console.error(e);
  } finally {
    saving.value = false;
  }
};
</script>
