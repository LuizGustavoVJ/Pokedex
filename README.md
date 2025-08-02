<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Sistema Laravel + Vue.js + Pokémon API

Sistema completo para exibição de Pokémon usando Laravel 11, Vue.js 3 e PokeAPI.

## 📋 Índice
1. [Visão Geral](#visão-geral)
2. [Arquitetura Implementada](#arquitetura)
3. [Funcionalidades](#funcionalidades)
4. [Tecnologias Utilizadas](#tecnologias)
5. [Instalação e Configuração](#instalação)
6. [Docker](#docker)
7. [API de Pokémon](#api-pokemon)
8. [Frontend Vue.js](#frontend)
9. [Testes](#testes)
10. [Padrões de Design](#padrões)

---

## 🎯 Visão Geral

### Funcionalidades Principais
- ✅ API RESTful para Pokémon (sem autenticação)
- ✅ Interface moderna com Vue.js 3
- ✅ Listagem de Pokémon com paginação
- ✅ Detalhamento completo de Pokémon
- ✅ Filtros por nome e tipo
- ✅ Conversão automática de unidades
- ✅ Testes unitários
- ✅ Layout responsivo (4 cards por linha)
- ✅ Docker completo

---

## 🏗️ Arquitetura Implementada

### Backend (Laravel 11)
```
app/
├── Http/Controllers/API/
│   └── PokemonController.php       # API de Pokémon
├── Services/
│   └── PokemonService.php          # Lógica de negócio
└── Models/
    └── User.php                    # Model básico
```

### Frontend (Vue.js 3)
```
resources/js/
├── components/
│   ├── App.vue                     # Componente principal
│   ├── PokemonList.vue             # Listagem de Pokémon
│   └── PokemonDetail.vue           # Detalhes do Pokémon
├── router/
│   └── index.js                    # Configuração de rotas
└── bootstrap.js                    # Configuração do Axios
```

### Docker
```
├── Dockerfile                      # Multi-stage build
├── docker-compose.yml              # Produção e desenvolvimento
├── docker/
│   ├── nginx.conf                 # Configuração Nginx
│   └── start.sh                   # Script de inicialização
└── .dockerignore                   # Otimização de build
```

---

## ⚙️ Funcionalidades

### **1. API de Pokémon**
- ✅ Listagem com paginação
- ✅ Filtros por nome e tipo
- ✅ Detalhes completos de Pokémon
- ✅ Conversão de unidades (altura/peso)
- ✅ Integração direta com PokeAPI
- ✅ Tratamento de erros robusto

### **2. Frontend Vue.js**
- ✅ Interface moderna e responsiva
- ✅ Listagem com 4 cards por linha
- ✅ Página de detalhes completa
- ✅ Filtros em tempo real
- ✅ Paginação
- ✅ Navegação entre Pokémon
- ✅ Loading states
- ✅ Tratamento de erros

### **3. Docker**
- ✅ Multi-stage build otimizado
- ✅ Nginx + PHP-FPM
- ✅ Configuração para produção e desenvolvimento
- ✅ Hot reload em desenvolvimento
- ✅ Otimizações de performance

---

## 🛠️ Tecnologias Utilizadas

### **Backend**
- **Laravel 11** - Framework PHP
- **PHP 8.2** - Linguagem
- **HTTP Client** - Integração com PokeAPI

### **Frontend**
- **Vue.js 3** - Framework JavaScript
- **Vue Router** - Roteamento
- **Axios** - Cliente HTTP
- **Lodash** - Utilitários (debounce)
- **Vite** - Build tool

### **DevOps**
- **Docker** - Containerização
- **Docker Compose** - Orquestração
- **Nginx** - Servidor web
- **PHP-FPM** - Processador PHP

### **Testes**
- **PHPUnit** - Testes unitários
- **Laravel Testing** - Testes de feature

---

## 🚀 Instalação e Configuração

### **1. Pré-requisitos**
- Docker e Docker Compose (recomendado)
- Node.js 18+ (para desenvolvimento local)
- PHP 8.2+ (para desenvolvimento local)
- Composer (para desenvolvimento local)

### **2. Instalação com Docker (Recomendado)**

```bash
# Clonar repositório
git clone [url-do-repositorio]
cd laravel-vue-test

# Construir e iniciar
docker-compose up -d --build

# Acessar aplicação
# http://localhost:8000
```

**✅ Vantagens do Docker:**
- ✅ Configuração automática
- ✅ Ambiente isolado
- ✅ Sem conflitos de dependências
- ✅ Fácil deploy
- ✅ Multi-stage build otimizado

### **3. Instalação Local (Desenvolvimento)**

```bash
# Clonar repositório
git clone [url-do-repositorio]
cd laravel-vue-test

# Instalar dependências PHP
composer install

# Instalar dependências Node.js
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar .env (sem banco de dados)
CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Build do frontend
npm run build

# Iniciar servidor
php artisan serve
npm run dev
```

### **4. Verificação da Instalação**

#### **Com Docker:**
```bash
# Verificar status
docker-compose ps

# Testar aplicação
curl http://localhost:8000

# Testar API
curl http://localhost:8000/api/pokemon
```

#### **Local:**
```bash
# Testar aplicação
curl http://localhost:8000

# Testar API
curl http://localhost:8000/api/pokemon
```

---

## 🐳 Docker

### **Estrutura Docker**
```
├── Dockerfile                      # Multi-stage build
├── docker-compose.yml              # Produção e desenvolvimento
├── docker/
│   ├── nginx.conf                 # Configuração Nginx
│   └── start.sh                   # Script de inicialização
└── .dockerignore                   # Otimização de build
```

### **Serviços Docker**
- **app**: Laravel + Vue.js + PHP-FPM + Nginx
- **redis**: Redis 7 (cache opcional)

### **Comandos Docker**

#### **Produção e Desenvolvimento**
```bash
# Construir e iniciar
docker-compose up -d --build

# Ver logs
docker-compose logs -f app

# Parar serviços
docker-compose down

# Reconstruir
docker-compose up -d --build --force-recreate
```

#### **Comandos Úteis**
```bash
# Executar comandos Laravel
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Executar testes
docker-compose exec app php artisan test

# Acessar container
docker-compose exec app sh

# Ver logs em tempo real
docker-compose logs -f

# Copiar arquivo .env para container (se necessário)
docker cp .env laravel-vue-test-app-1:/var/www/html/.env
```

### **Configurações Docker**

#### **Configuração Docker (docker-compose.yml)**
- ✅ Multi-stage build otimizado
- ✅ Nginx + PHP-FPM
- ✅ Cache otimizado
- ✅ Headers de segurança
- ✅ Rate limiting
- ✅ Volumes para desenvolvimento
- ✅ Debug habilitado
- ✅ Logs detalhados

### **Otimizações Docker**
- ✅ **Multi-stage build** - Reduz tamanho da imagem
- ✅ **Dockerignore** - Exclui arquivos desnecessários
- ✅ **Nginx otimizado** - Gzip, cache, segurança
- ✅ **PHP-FPM** - Performance otimizada
- ✅ **Volumes** - Persistência de dados

### **Troubleshooting**

#### **Problemas Comuns e Soluções:**

1. **Erro 500 - Arquivo .env não encontrado:**
```bash
# Copiar .env do host para o container
docker cp .env laravel-vue-test-app-1:/var/www/html/.env

# Limpar cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

2. **Erro de permissões:**
```bash
# Ajustar permissões
docker-compose exec app chown -R www-data:www-data /var/www/html
docker-compose exec app chmod -R 755 /var/www/html/storage
```

3. **Container não inicia:**
```bash
# Ver logs detalhados
docker-compose logs app

# Reconstruir sem cache
docker-compose build --no-cache
docker-compose up -d
```

4. **Build do frontend não atualiza:**
```bash
# Reconstruir frontend
docker-compose exec app npm run build

# Ou reconstruir container completo
docker-compose up -d --build
```

### **Verificação de Status**

#### **Verificar se está funcionando:**
```bash
# Status dos containers
docker-compose ps

# Testar aplicação
curl http://localhost:8000

# Testar API
curl http://localhost:8000/api/pokemon

# Verificar logs
docker-compose logs -f app
```

#### **Informações do Sistema:**
```bash
# Verificar uso de recursos
docker stats

# Verificar imagens
docker images

# Verificar volumes
docker volume ls
```

---

## 🎮 API de Pokémon

### **Endpoints Disponíveis**

#### **1. Listar Pokémon**
```bash
GET /api/pokemon
```

**Parâmetros:**
- `limit` (opcional): número de resultados (padrão: 10)
- `offset` (opcional): paginação (padrão: 0)
- `name` (opcional): filtrar por nome
- `type` (opcional): filtrar por tipo

**Exemplo:**
```bash
curl "http://localhost:8000/api/pokemon?limit=10&type=fire"
```

#### **2. Detalhes de Pokémon**
```bash
GET /api/pokemon/{name}
```

**Exemplo:**
```bash
curl "http://localhost:8000/api/pokemon/pikachu"
```

#### **3. Tipos de Pokémon**
```bash
GET /api/pokemon-types
```

### **Exemplo de Resposta**
```json
{
  "success": true,
  "data": {
    "id": 25,
    "name": "pikachu",
    "height": 40,
    "weight": 6.0,
    "types": ["electric"],
    "abilities": ["static", "lightning-rod"],
    "stats": [
      {"name": "hp", "value": 35},
      {"name": "attack", "value": 55}
    ],
    "sprites": {
      "front_default": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/25.png",
      "back_default": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/back/25.png",
      "front_shiny": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/25.png",
      "back_shiny": "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/back/shiny/25.png"
    }
  },
  "message": "Pokémon encontrado com sucesso"
}
```

---

## 🎨 Frontend Vue.js

### **Componentes Implementados**

#### **1. PokemonList.vue**
- ✅ Listagem com grid responsivo (4 cards por linha)
- ✅ Filtros por nome e tipo
- ✅ Paginação
- ✅ Loading states
- ✅ Debounce na busca (500ms)
- ✅ Cards com hover effects
- ✅ Layout responsivo (4→3→2→1 colunas)

#### **2. PokemonDetail.vue**
- ✅ Detalhes completos do Pokémon
- ✅ Estatísticas com barras visuais
- ✅ Habilidades
- ✅ Navegação entre Pokémon
- ✅ Responsivo

#### **3. Funcionalidades**
- ✅ Busca em tempo real
- ✅ Filtros dinâmicos
- ✅ Paginação
- ✅ Navegação SPA
- ✅ Tratamento de erros
- ✅ Loading states

### **Como Usar**

1. **Acessar Pokédex:**
   - Vá para http://localhost:8000
   - A página inicial mostra a listagem de Pokémon

2. **Buscar Pokémon:**
   - Use o campo de busca por nome
   - Selecione tipo no dropdown
   - Os filtros funcionam em tempo real

3. **Ver Detalhes:**
   - Clique em qualquer card de Pokémon
   - Navegue entre Pokémon com botões "Anterior/Próximo"

---

## 🧪 Testes

### **Executar Testes**
```bash
# Local
php artisan test

# Docker
docker-compose exec app php artisan test

# Testes específicos
docker-compose exec app php artisan test --filter=PokemonTest
```

### **Testes Implementados**
- ✅ Listagem de Pokémon
- ✅ Busca por nome
- ✅ Filtro por tipo
- ✅ Detalhes de Pokémon
- ✅ Conversão de unidades
- ✅ Estrutura de dados
- ✅ Tratamento de erros
- ✅ Paginação
- ✅ Filtros por tipo

### **Cobertura de Testes**
- ✅ **API Endpoints** - Todos os endpoints testados
- ✅ **Service Layer** - Lógica de negócio testada
- ✅ **Error Handling** - Tratamento de erros testado
- ✅ **Data Structure** - Estrutura de resposta validada
- ✅ **Unit Conversion** - Conversão de unidades testada

---

## 🎯 Padrões de Design

### **1. SOLID Principles**
- ✅ **Single Responsibility**: Cada classe tem uma responsabilidade
- ✅ **Open/Closed**: Extensível sem modificação
- ✅ **Liskov Substitution**: Substituição de tipos
- ✅ **Interface Segregation**: Interfaces específicas
- ✅ **Dependency Inversion**: Inversão de dependências

### **2. Design Patterns**
- ✅ **Service Pattern**: PokemonService
- ✅ **Repository Pattern**: Preparado para implementação
- ✅ **Factory Pattern**: Preparado para implementação

### **3. DRY (Don't Repeat Yourself)**
- ✅ Componentes Vue reutilizáveis
- ✅ Helpers e utilitários
- ✅ Configurações centralizadas

### **4. Object Calisthenics**
- ✅ Um nível de indentação por método
- ✅ Não usar ELSE
- ✅ Encapsular primitivos
- ✅ Coleções de primeira classe
- ✅ Um ponto por linha
- ✅ Não abreviar
- ✅ Manter entidades pequenas
- ✅ Não mais que duas variáveis de instância
- ✅ Sem getters/setters/properties

---

## 📊 Métricas e Performance

### **Otimizações Implementadas**
- ✅ Debounce na busca (500ms)
- ✅ Loading states
- ✅ Error handling robusto
- ✅ Layout responsivo otimizado
- ✅ Componentes Vue otimizados
- ✅ Docker multi-stage build
- ✅ Nginx otimizado

### **Monitoramento**
- ✅ Logs estruturados
- ✅ Error handling
- ✅ Performance monitoring

---

## 🔧 Comandos Úteis

### **Laravel**
```bash
# Local
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Docker
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### **Vue.js**
```bash
# Local
npm run dev
npm run build

# Docker
docker-compose up -d --build
```

### **Docker**
```bash
# Produção e desenvolvimento
docker-compose up -d --build

# Logs
docker-compose logs -f

# Parar
docker-compose down

# Reconstruir sem cache
docker-compose build --no-cache
docker-compose up -d

# Verificar status
docker-compose ps

# Executar comandos no container
docker-compose exec app sh
```

### **Testes**
```bash
# Local
php artisan test

# Docker
docker-compose exec app php artisan test

# Testes específicos
docker-compose exec app php artisan test --filter=PokemonTest
```

### **Troubleshooting**
```bash
# Ver logs
docker-compose logs -f app

# Copiar .env para container
docker cp .env laravel-vue-test-app-1:/var/www/html/.env

# Ajustar permissões
docker-compose exec app chown -R www-data:www-data /var/www/html
docker-compose exec app chmod -R 755 /var/www/html/storage
```

---

## 🚀 Deploy

### **Produção com Docker (Recomendado)**
```bash
# Build para produção
docker-compose up -d --build

# Configurar .env
APP_ENV=production
APP_DEBUG=false

# Otimizar Laravel
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache

# Verificar status
docker-compose ps

# Ver logs
docker-compose logs -f app
```

### **Produção Local (Alternativo)**
```bash
# Build para produção
npm run build

# Configurar .env
APP_ENV=production
APP_DEBUG=false

# Otimizar Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Deploy em Servidor**
```bash
# 1. Clonar repositório
git clone [url-do-repositorio]
cd laravel-vue-test

# 2. Configurar .env
cp .env.example .env
# Editar .env com configurações de produção

# 3. Deploy com Docker
docker-compose up -d --build

# 4. Verificar aplicação
curl http://seu-servidor:8000
```

---

## 📝 Checklist de Implementação

### **Backend ✅**
- [x] API RESTful
- [x] Integração com PokeAPI
- [x] Conversão de unidades
- [x] Testes unitários
- [x] Tratamento de erros

### **Frontend ✅**
- [x] Vue.js 3
- [x] Listagem responsiva (4 cards)
- [x] Detalhamento completo
- [x] Filtros dinâmicos
- [x] Paginação
- [x] Loading states

### **Docker ✅**
- [x] Multi-stage build
- [x] Nginx + PHP-FPM
- [x] Configuração produção/desenvolvimento
- [x] Hot reload
- [x] Otimizações

### **Qualidade ✅**
- [x] SOLID principles
- [x] DRY
- [x] Object Calisthenics
- [x] Testes unitários
- [x] Documentação

---

## 📄 Licença

Este projeto está sob a licença MIT.

---

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature
3. Commit suas mudanças
4. Push para a branch
5. Abra um Pull Request

---

Este projeto demonstra uma implementação completa e profissional de um sistema Laravel + Vue.js com API de Pokémon, seguindo as melhores práticas de desenvolvimento e padrões de design modernos.
