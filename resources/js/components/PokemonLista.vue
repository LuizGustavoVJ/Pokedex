<template>
    <div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Pokémon Explorer</h2>

    <!-- Filtros -->
    <div class="row mb-4 shadow-sm p-3 rounded bg-white">
      <div class="col-md-6 mb-3 mb-md-0">
        <input
          v-model="filters.name"
          type="text"
          class="form-control"
          placeholder="Filtrar por nome..."
        />
      </div>
      <div class="col-md-6">
        <select v-model="filters.type" class="form-select">
          <option value="">Todos os tipos</option>
          <option v-for="type in types" :key="type" :value="type">
            {{ capitalize(type) }}
          </option>
        </select>
      </div>
    </div>

    <!-- Carregamento -->
    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3">Carregando Pokémons...</p>
    </div>

    <!-- Lista -->
    <div v-else class="row">
      <div
        v-for="pokemon in pokemons"
        :key="pokemon.id"
        class="col-sm-6 col-md-4 col-lg-3 mb-4"
      >
        <div class="card shadow-sm h-100 pokemon-card border-0">
          <img
            :src="pokemon.sprite"
            class="card-img-top bg-light p-3"
            alt="pokemon"
          />
          <div class="card-body">
            <h5 class="card-title text-center text-capitalize">
              {{ pokemon.name }}
            </h5>
            <div class="text-center">
              <span
                v-for="type in pokemon.types"
                :key="type"
                class="badge bg-primary me-1 text-capitalize"
              >
                {{ type }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Nenhum resultado -->
    <div v-if="!loading && pokemons.length === 0" class="text-center py-5">
      <p class="text-muted">Nenhum Pokémon encontrado com esses filtros.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const pokemons = ref([])
const loading = ref(true)
const filters = ref({ name: '', type: '' })

// Tipos fixos da PokeAPI
const types = [
  'normal', 'fire', 'water', 'grass', 'electric', 'ice',
  'fighting', 'poison', 'ground', 'flying', 'psychic',
  'bug', 'rock', 'ghost', 'dragon', 'dark', 'steel', 'fairy'
]

const capitalize = (s) => s.charAt(0).toUpperCase() + s.slice(1)

const fetchPokemons = async () => {
  loading.value = true
  try {
    const response = await axios.get('/api/pokemon', {
      params: {
        name: filters.value.name,
        type: filters.value.type
      }
    })
    pokemons.value = response.data.pokemon
  } catch (error) {
    console.error('Erro ao carregar pokémons', error)
    pokemons.value = []
  } finally {
    loading.value = false
  }
}

// Recarrega ao alterar filtros
watch(filters, fetchPokemons, { deep: true })

onMounted(fetchPokemons)
</script>

<style scoped>
.pokemon-card {
  transition: all 0.2s ease-in-out;
  border-radius: 16px;
}

.pokemon-card:hover {
  transform: scale(1.03);
  box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
}

.card-img-top {
  height: 120px;
  object-fit: contain;
}

body {
  background-color: #f8f9fa;
}
</style>
