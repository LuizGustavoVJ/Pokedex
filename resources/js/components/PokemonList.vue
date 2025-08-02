<template>
  <div class="pokemon-list">
    <header class="header">
      <h1>🎮 Pokédex</h1>
      <p>Explore o mundo dos Pokémon</p>
    </header>

    <!-- Filtros -->
    <div class="filters">
      <div class="search-box">
        <input
          v-model="searchName"
          @input="debouncedSearch"
          type="text"
          placeholder="Buscar por nome..."
          class="search-input"
        />
      </div>

      <div class="type-filter">
        <select v-model="selectedType" @change="loadPokemon" class="type-select">
          <option value="">Todos os tipos</option>
          <option v-for="type in types" :key="type.name" :value="type.name">
            {{ type.name }}
          </option>
        </select>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading" class="loading">
      <div class="spinner"></div>
      <p>Carregando Pokémon...</p>
    </div>

    <!-- Lista de Pokémon -->
    <div v-else-if="pokemonList.length > 0" class="pokemon-grid">
      <div
        v-for="pokemon in pokemonList"
        :key="pokemon.id"
        @click="goToDetail(pokemon.name)"
        class="pokemon-card-container"
      >
        <div class="pokemon-card">
          <img
            :src="pokemon.sprites.front_default"
            :alt="pokemon.name"
            class="pokemon-sprite"
          />
          <h3>{{ pokemon.name }}</h3>
          <div class="types">
            <span
              v-for="type in pokemon.types"
              :key="type"
              class="type-badge"
            >
              {{ type }}
            </span>
          </div>
          <p class="pokemon-info">
            Altura: {{ pokemon.height }}cm | Peso: {{ pokemon.weight }}kg
          </p>
        </div>
      </div>
    </div>

    <!-- Paginação -->
    <div v-if="pokemonList.length > 0" class="pagination">
      <button
        @click="previousPage"
        :disabled="!hasPrevious"
        class="pagination-btn"
      >
        Anterior
      </button>
      <span class="page-info">Página {{ currentPage }}</span>
      <button
        @click="nextPage"
        :disabled="!hasNext"
        class="pagination-btn"
      >
        Próximo
      </button>
    </div>

    <!-- Mensagem de erro -->
    <div v-if="error" class="error">
      <p>{{ error }}</p>
      <button @click="loadPokemon" class="retry-btn">Tentar novamente</button>
    </div>

    <!-- Sem resultados -->
    <div v-else-if="!loading && pokemonList.length === 0" class="no-results">
      <p>Nenhum Pokémon encontrado.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { debounce } from 'lodash'

export default {
  name: 'PokemonList',
  data() {
    return {
      pokemonList: [],
      types: [],
      loading: false,
      error: null,
      searchName: '',
      selectedType: '',
      currentPage: 1,
      limit: 20,
      hasNext: false,
      hasPrevious: false
    }
  },
  mounted() {
    this.loadTypes()
    this.loadPokemon()
  },
  methods: {
    async loadPokemon() {
      this.loading = true
      this.error = null

      try {
        const params = {
          limit: this.limit,
          offset: (this.currentPage - 1) * this.limit
        }

        if (this.searchName) {
          params.name = this.searchName
        }

        if (this.selectedType) {
          params.type = this.selectedType
        }

        const response = await axios.get('/api/pokemon', { params })

        if (response.data.success) {
          this.pokemonList = response.data.data.pokemon || []
          this.hasNext = !!response.data.data.next
          this.hasPrevious = !!response.data.data.previous
        } else {
          this.error = 'Erro ao carregar Pokémon'
        }
      } catch (error) {
        console.error('Erro:', error)
        this.error = 'Erro ao carregar Pokémon. Tente novamente.'
      } finally {
        this.loading = false
      }
    },

    async loadTypes() {
      try {
        const response = await axios.get('/api/pokemon-types')
        if (response.data.success) {
          this.types = response.data.data
        }
      } catch (error) {
        console.error('Erro ao carregar tipos:', error)
      }
    },

    debouncedSearch: debounce(function() {
      this.currentPage = 1
      this.loadPokemon()
    }, 500),

    nextPage() {
      this.currentPage++
      this.loadPokemon()
    },

    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.loadPokemon()
      }
    },

    goToDetail(name) {
      this.$router.push(`/pokemon/${name}`)
    }
  }
}
</script>

<style scoped>
.pokemon-list {
  min-height: 100vh;
  width: 100vw;
  background-image: url('/images/Pokefundo.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  background-repeat: no-repeat;
  padding: 20px;
  position: relative;
  margin: 0;
  left: 0;
  right: 0;
}

.pokemon-list::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  z-index: 1;
}

.header {
  text-align: center;
  margin-bottom: 30px;
  position: relative;
  z-index: 2;
}

.header h1 {
  font-size: 3rem;
  color: #fff;
  margin-bottom: 10px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
  font-weight: bold;
}

.header p {
  color: #fff;
  font-size: 1.2rem;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
}

.filters {
  display: flex;
  gap: 20px;
  margin-bottom: 30px;
  justify-content: center;
  flex-wrap: wrap;
  position: relative;
  z-index: 2;
}

.search-input, .type-select {
  padding: 15px 20px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 12px;
  font-size: 1rem;
  min-width: 250px;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
}

.search-input:focus, .type-select:focus {
  outline: none;
  border-color: #007bff;
  background: rgba(255, 255, 255, 1);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
}

.loading {
  text-align: center;
  padding: 40px;
  position: relative;
  z-index: 2;
}

.spinner {
  border: 4px solid rgba(255, 255, 255, 0.3);
  border-top: 4px solid #007bff;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
  margin: 0 auto 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.pokemon-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 30px;
  margin-bottom: 30px;
  position: relative;
  z-index: 2;
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
}

.pokemon-card-container {
  perspective: 1000px;
}

.pokemon-card {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 25px;
  padding: 30px;
  text-align: center;
  box-shadow:
    0 15px 35px rgba(0, 0, 0, 0.4),
    0 0 0 2px rgba(255, 255, 255, 0.2),
    0 0 20px rgba(0, 123, 255, 0.2);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  cursor: pointer;
  min-height: 380px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  backdrop-filter: blur(15px);
  border: 2px solid rgba(255, 255, 255, 0.3);
  position: relative;
  overflow: hidden;
}

.pokemon-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
  z-index: -1;
}

.pokemon-card::after {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  background: linear-gradient(45deg, #007bff, #00d4ff, #007bff);
  border-radius: 25px;
  z-index: -2;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.pokemon-card:hover {
  transform: translateY(-15px) rotateX(8deg);
  box-shadow:
    0 25px 50px rgba(0, 0, 0, 0.5),
    0 0 0 3px rgba(255, 255, 255, 0.3),
    0 0 30px rgba(0, 123, 255, 0.4),
    0 0 60px rgba(0, 123, 255, 0.2);
  background: rgba(255, 255, 255, 1);
}

.pokemon-card:hover::after {
  opacity: 1;
}

.pokemon-sprite {
  width: 180px;
  height: 180px;
  margin: 0 auto 25px;
  object-fit: contain;
  filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.4));
  transition: transform 0.3s ease;
  border-radius: 15px;
  background: rgba(255, 255, 255, 0.1);
  padding: 10px;
}

.pokemon-card:hover .pokemon-sprite {
  transform: scale(1.15);
  filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5));
}

.pokemon-card h3 {
  margin: 0 0 20px 0;
  color: #333;
  text-transform: capitalize;
  font-size: 1.6rem;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.types {
  display: flex;
  gap: 12px;
  justify-content: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
}

.type-badge {
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  padding: 8px 16px;
  border-radius: 25px;
  font-size: 0.9rem;
  text-transform: capitalize;
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.3);
}

.type-badge:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 123, 255, 0.5);
}

.pokemon-info {
  color: #666;
  font-size: 1rem;
  margin: 0;
  line-height: 1.6;
  font-weight: 500;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  margin-top: 30px;
  position: relative;
  z-index: 2;
}

.pagination-btn {
  padding: 15px 30px;
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  border: none;
  border-radius: 15px;
  cursor: pointer;
  font-size: 1.1rem;
  font-weight: 600;
  box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
  transition: all 0.3s ease;
}

.pagination-btn:disabled {
  background: linear-gradient(135deg, #ccc, #999);
  cursor: not-allowed;
  box-shadow: none;
}

.pagination-btn:hover:not(:disabled) {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(0, 123, 255, 0.5);
}

.page-info {
  font-weight: bold;
  color: #fff;
  font-size: 1.2rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

.error {
  text-align: center;
  padding: 40px;
  color: #dc3545;
  position: relative;
  z-index: 2;
}

.retry-btn {
  margin-top: 15px;
  padding: 15px 30px;
  background: linear-gradient(135deg, #dc3545, #c82333);
  color: white;
  border: none;
  border-radius: 15px;
  cursor: pointer;
  font-weight: 600;
  box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
  transition: all 0.3s ease;
}

.retry-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(220, 53, 69, 0.5);
}

.no-results {
  text-align: center;
  padding: 40px;
  color: #fff;
  position: relative;
  z-index: 2;
  font-size: 1.3rem;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}

/* Responsividade */
@media (max-width: 1400px) {
  .pokemon-grid {
    grid-template-columns: repeat(3, 1fr);
    max-width: 1100px;
  }
}

@media (max-width: 1100px) {
  .pokemon-grid {
    grid-template-columns: repeat(2, 1fr);
    max-width: 800px;
  }
}

@media (max-width: 700px) {
  .pokemon-grid {
    grid-template-columns: 1fr;
    max-width: 400px;
  }

  .filters {
    flex-direction: column;
    align-items: center;
  }

  .search-input, .type-select {
    min-width: 280px;
  }

  .pokemon-card {
    min-height: 350px;
  }

  .pokemon-sprite {
    width: 150px;
    height: 150px;
  }

  .header h1 {
    font-size: 2.5rem;
  }
}
</style>
