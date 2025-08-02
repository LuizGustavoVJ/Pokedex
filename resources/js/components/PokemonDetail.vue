<template>
  <div class="pokemon-detail">
    <div class="container">
      <!-- Botão voltar -->
      <button @click="goBack" class="back-btn">
        ← Voltar para lista
      </button>

      <!-- Loading -->
      <div v-if="loading" class="loading">
        <div class="spinner"></div>
        <p>Carregando detalhes do Pokémon...</p>
      </div>

      <!-- Detalhes do Pokémon -->
      <div v-else-if="pokemon" class="pokemon-content">
        <div class="pokemon-header">
          <div class="pokemon-images">
            <img
              :src="pokemon.sprites.front_default"
              :alt="pokemon.name"
              class="main-sprite"
            />
            <div class="sprite-gallery">
              <img
                v-if="pokemon.sprites.back_default"
                :src="pokemon.sprites.back_default"
                :alt="pokemon.name + ' (back)'"
                class="sprite"
              />
              <img
                v-if="pokemon.sprites.front_shiny"
                :src="pokemon.sprites.front_shiny"
                :alt="pokemon.name + ' (shiny)'"
                class="sprite"
              />
              <img
                v-if="pokemon.sprites.back_shiny"
                :src="pokemon.sprites.back_shiny"
                :alt="pokemon.name + ' (shiny back)'"
                class="sprite"
              />
            </div>
          </div>

          <div class="pokemon-info">
            <h1>{{ pokemon.name }}</h1>
            <p class="pokemon-id">#{{ pokemon.id.toString().padStart(3, '0') }}</p>

            <div class="types">
              <span
                v-for="type in pokemon.types"
                :key="type"
                class="type-badge"
              >
                {{ type }}
              </span>
            </div>

            <div class="stats-basic">
              <div class="stat-item">
                <span class="stat-label">Altura:</span>
                <span class="stat-value">{{ pokemon.height }} cm</span>
              </div>
              <div class="stat-item">
                <span class="stat-label">Peso:</span>
                <span class="stat-value">{{ pokemon.weight }} kg</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Habilidades -->
        <div class="section">
          <h2>Habilidades</h2>
          <div class="abilities">
            <span
              v-for="ability in pokemon.abilities"
              :key="ability"
              class="ability-badge"
            >
              {{ ability }}
            </span>
          </div>
        </div>

        <!-- Estatísticas -->
        <div class="section">
          <h2>Estatísticas Base</h2>
          <div class="stats-grid">
            <div
              v-for="stat in pokemon.stats"
              :key="stat.name"
              class="stat-card"
            >
              <div class="stat-header">
                <span class="stat-name">{{ stat.name }}</span>
                <span class="stat-value">{{ stat.value }}</span>
              </div>
              <div class="stat-bar">
                <div
                  class="stat-fill"
                  :style="{ width: (stat.value / 255) * 100 + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Erro -->
      <div v-else-if="error" class="error">
        <p>{{ error }}</p>
        <button @click="loadPokemon" class="retry-btn">Tentar novamente</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'PokemonDetail',
  data() {
    return {
      pokemon: null,
      loading: false,
      error: null
    }
  },
  mounted() {
    this.loadPokemon()
  },
  methods: {
    async loadPokemon() {
      this.loading = true
      this.error = null

      try {
        const name = this.$route.params.name
        const response = await axios.get(`/api/pokemon/${name}`)

        if (response.data.success) {
          this.pokemon = response.data.data
        } else {
          this.error = 'Pokémon não encontrado'
        }
      } catch (error) {
        console.error('Erro:', error)
        this.error = 'Erro ao carregar detalhes do Pokémon'
      } finally {
        this.loading = false
      }
    },

    goBack() {
      this.$router.push('/')
    }
  }
}
</script>

<style scoped>
.pokemon-detail {
  min-height: 100vh;
  width: 100vw;
  background-image: url('/images/Pokefundo.jpg');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
  background-repeat: no-repeat;
  padding: 20px 0;
  position: relative;
  margin: 0;
  left: 0;
  right: 0;
}

.pokemon-detail::before {
  content: '';
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  z-index: 1;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
  z-index: 2;
}

.back-btn {
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  border: none;
  padding: 18px 30px;
  border-radius: 15px;
  cursor: pointer;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 30px;
  transition: all 0.3s ease;
  box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
}

.back-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(0, 123, 255, 0.5);
}

.loading {
  text-align: center;
  padding: 60px 20px;
  color: #fff;
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

.pokemon-content {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 25px;
  padding: 50px;
  box-shadow:
    0 20px 40px rgba(0, 0, 0, 0.4),
    0 0 0 3px rgba(255, 255, 255, 0.2),
    0 0 30px rgba(0, 123, 255, 0.3);
  backdrop-filter: blur(15px);
  border: 2px solid rgba(255, 255, 255, 0.3);
  position: relative;
  overflow: hidden;
}

.pokemon-content::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
  z-index: -1;
}

.pokemon-content::after {
  content: '';
  position: absolute;
  top: -3px;
  left: -3px;
  right: -3px;
  bottom: -3px;
  background: linear-gradient(45deg, #007bff, #00d4ff, #007bff);
  border-radius: 25px;
  z-index: -2;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.pokemon-content:hover::after {
  opacity: 1;
}

.pokemon-header {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 50px;
  margin-bottom: 50px;
}

.pokemon-images {
  text-align: center;
}

.main-sprite {
  width: 300px;
  height: 300px;
  margin-bottom: 30px;
  filter: drop-shadow(0 12px 24px rgba(0, 0, 0, 0.5));
  transition: transform 0.3s ease;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.1);
  padding: 15px;
}

.main-sprite:hover {
  transform: scale(1.08);
  filter: drop-shadow(0 16px 32px rgba(0, 0, 0, 0.6));
}

.sprite-gallery {
  display: flex;
  gap: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.sprite {
  width: 120px;
  height: 120px;
  border: 4px solid rgba(255, 255, 255, 0.8);
  border-radius: 20px;
  transition: all 0.3s ease;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
  background: rgba(255, 255, 255, 0.1);
  padding: 8px;
}

.sprite:hover {
  border-color: #007bff;
  transform: scale(1.15);
  box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
}

.pokemon-info h1 {
  font-size: 3.5rem;
  color: #333;
  margin: 0 0 20px 0;
  text-transform: capitalize;
  font-weight: bold;
  text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.1);
}

.pokemon-id {
  color: #666;
  font-size: 1.6rem;
  margin: 0 0 30px 0;
  font-weight: 600;
}

.types {
  display: flex;
  gap: 15px;
  margin-bottom: 30px;
  flex-wrap: wrap;
}

.type-badge {
  background: linear-gradient(135deg, #007bff, #0056b3);
  color: white;
  padding: 10px 20px;
  border-radius: 25px;
  font-size: 1.1rem;
  text-transform: capitalize;
  font-weight: 600;
  box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
  transition: all 0.3s ease;
  border: 2px solid rgba(255, 255, 255, 0.3);
}

.type-badge:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(0, 123, 255, 0.5);
}

.stats-basic {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 25px;
}

.stat-item {
  display: flex;
  justify-content: space-between;
  padding: 20px;
  background: rgba(248, 249, 250, 0.8);
  border-radius: 15px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.stat-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.stat-label {
  font-weight: bold;
  color: #333;
  font-size: 1.2rem;
}

.stat-value {
  color: #007bff;
  font-weight: 600;
  font-size: 1.2rem;
}

.section {
  margin-bottom: 50px;
}

.section h2 {
  font-size: 2.5rem;
  color: #333;
  margin: 0 0 30px 0;
  border-bottom: 4px solid #007bff;
  padding-bottom: 20px;
  font-weight: bold;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

.abilities {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.ability-badge {
  background: linear-gradient(135deg, #28a745, #20c997);
  color: white;
  padding: 10px 20px;
  border-radius: 25px;
  font-size: 1.1rem;
  text-transform: capitalize;
  font-weight: 600;
  box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
  transition: all 0.3s ease;
  border: 2px solid rgba(255, 255, 255, 0.3);
}

.ability-badge:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(40, 167, 69, 0.5);
}

.stats-grid {
  display: grid;
  gap: 25px;
}

.stat-card {
  background: rgba(248, 249, 250, 0.8);
  padding: 25px;
  border-radius: 20px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(10px);
  transition: all 0.3s ease;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stat-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.stat-name {
  font-weight: bold;
  color: #333;
  text-transform: capitalize;
  font-size: 1.3rem;
}

.stat-value {
  color: #007bff;
  font-weight: bold;
  font-size: 1.3rem;
}

.stat-bar {
  height: 15px;
  background: rgba(233, 236, 239, 0.8);
  border-radius: 10px;
  overflow: hidden;
  box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
}

.stat-fill {
  height: 100%;
  background: linear-gradient(90deg, #007bff, #0056b3);
  transition: width 0.6s ease;
  border-radius: 10px;
  box-shadow: 0 3px 6px rgba(0, 123, 255, 0.4);
}

.error {
  text-align: center;
  padding: 60px 20px;
  color: #dc3545;
  background: rgba(255, 255, 255, 0.95);
  border-radius: 20px;
  backdrop-filter: blur(15px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.retry-btn {
  margin-top: 25px;
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

@media (max-width: 1000px) {
  .pokemon-header {
    grid-template-columns: 1fr;
    gap: 40px;
  }

  .main-sprite {
    width: 250px;
    height: 250px;
  }

  .pokemon-info h1 {
    font-size: 3rem;
  }

  .stats-basic {
    grid-template-columns: 1fr;
  }

  .container {
    padding: 0 15px;
  }

  .pokemon-content {
    padding: 35px;
  }
}

@media (max-width: 700px) {
  .main-sprite {
    width: 200px;
    height: 200px;
  }

  .pokemon-info h1 {
    font-size: 2.5rem;
  }

  .section h2 {
    font-size: 2rem;
  }

  .pokemon-content {
    padding: 25px;
  }

  .sprite {
    width: 100px;
    height: 100px;
  }
}
</style>
