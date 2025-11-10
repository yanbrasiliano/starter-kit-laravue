.PHONY: help up down restart logs shell migrate fresh test front build clean ps install npm composer artisan tinker db-shell cache optimize queue horizon telescope pulse ide pint format check deploy backup restore \
	test-all test-fresh db-show db-table clear optimize-test ta tf ds dt oc ot test-coverage

# ============================================
# Colors
# ============================================

GREEN  := \033[0;32m
YELLOW := \033[0;33m
NC     := \033[0m # No Color

# ============================================
# Help
# ============================================

help: ## Show this help message
	@printf '\n${GREEN}╔═══════════════════════════════════════════╗${NC}\n'
	@printf '${GREEN}║     Shortcuts for development             ║${NC}\n'
	@printf '${GREEN}╚═══════════════════════════════════════════╝${NC}\n\n'
	@printf '${YELLOW}📦 Container Management:${NC}\n'
	@printf '  make up          - Start all containers\n'
	@printf '  make down        - Stop all containers\n'
	@printf '  make restart     - Restart all containers\n'
	@printf '  make build       - Rebuild containers\n'
	@printf '  make ps          - Show container status\n'
	@printf '  make logs        - Follow all logs\n'
	@printf '\n'
	@printf '${YELLOW}💻 Development:${NC}\n'
	@printf '  make shell       - Enter app container shell\n'
	@printf '  make shell-root  - Enter app container as root\n'
	@printf '  make front       - Run Vite dev server\n'
	@printf '  make install     - Install PHP and NPM dependencies\n'
	@printf '  make fresh       - Fresh database with seeds\n'
	@printf '  make cache       - Clear all Laravel caches\n'
	@printf '  make optimize    - Optimize for production\n'
	@printf '\n'
	@printf '${YELLOW}🗄️  Database:${NC}\n'
	@printf '  make migrate     - Run migrations\n'
	@printf '  make rollback    - Rollback last migration\n'
	@printf '  make db-show     - Show current database info\n'
	@printf '  make db-table TABLE=users - Show table info\n'
	@printf '  make db-shell    - Enter PostgreSQL shell\n'
	@printf '  make backup      - Backup database\n'
	@printf '  make restore FILE=backup.sql - Restore database\n'
	@printf '\n'
	@printf '${YELLOW}🧪 Testing:${NC}\n'
	@printf '  make test        - Run all tests (local)\n'
	@printf '  make test-all    - Run all tests (testing env, parallel)\n'
	@printf '  make test-fresh  - Clear cache + run tests (testing env)\n'
	@printf '  make test-coverage - Generate test coverage report\n'
	@printf '\n'
	@printf '${YELLOW}✨ Code Quality:${NC}\n'
	@printf '  make pint        - Run Laravel Pint (format)\n'
	@printf '  make check       - Check code style without fixing\n'
	@printf '  make ide         - Generate IDE helper files\n'
	@printf '\n'
	@printf '${YELLOW}🛠️  Artisan & Tools:${NC}\n'
	@printf '  make artisan ARGS="make:model Post" - Run artisan command\n'
	@printf '  make tinker      - Open Laravel Tinker\n'
	@printf '  make queue       - Run queue worker\n'
	@printf '  make horizon     - Open Laravel Horizon\n'
	@printf '  make telescope   - Open Laravel Telescope\n'
	@printf '  make pulse       - Open Laravel Pulse\n'
	@printf '\n'
	@printf '${YELLOW}⚡ Shortcuts:${NC}\n'
	@printf '  make ta          - test-all\n'
	@printf '  make tf          - test-fresh\n'
	@printf '  make ds          - db-show\n'
	@printf '  make dt TABLE=x  - db-table\n'
	@printf '  make oc          - optimize:clear\n'
	@printf '\n'

# ============================================
# Container Management
# ============================================

up: ## Start containers
	@printf "${GREEN}🚀 Starting containers...${NC}\n"
	@docker compose up -d
	@printf "${GREEN}✓ Containers started!${NC}\n"

down: ## Stop containers
	@printf "${YELLOW}🛑 Stopping containers...${NC}\n"
	@docker compose down
	@printf "${GREEN}✓ Containers stopped!${NC}\n"

restart: ## Restart containers
	@printf "${YELLOW}🔄 Restarting containers...${NC}\n"
	@docker compose restart
	@printf "${GREEN}✓ Containers restarted!${NC}\n"

build: ## Rebuild containers
	@printf "${GREEN}🔨 Building containers...${NC}\n"
	@docker compose build --no-cache
	@printf "${GREEN}✓ Build complete!${NC}\n"

ps: ## Show container status
	@docker compose ps

logs: ## Follow all logs
	docker compose logs -f

logs-app:
	docker compose logs -f app

logs-db:
	docker compose logs -f db

# ============================================
# Development
# ============================================

shell:
	docker exec -it starterkit-app sh

shell-root:
	docker exec -u root -it starterkit-app sh

front:
	docker exec -it starterkit-app npm run dev

install:
	@printf "${GREEN}📦 Installing dependencies...${NC}\n"
	@docker exec starterkit-app composer install
	@docker exec starterkit-app npm install
	@printf "${GREEN}✓ Dependencies installed!${NC}\n"

npm:
	docker exec starterkit-app npm $(ARGS)

composer:
	docker exec starterkit-app composer $(ARGS)

# ============================================
# Database
# ============================================

migrate:
	@printf "${GREEN}🔄 Running migrations...${NC}\n"
	@docker exec starterkit-app php artisan migrate
	@printf "${GREEN}✓ Migrations complete!${NC}\n"

rollback:
	docker exec starterkit-app php artisan migrate:rollback

fresh:
	@printf "${YELLOW}⚠️  This will drop all tables and reseed!${NC}\n"
	@docker exec starterkit-app php artisan migrate:fresh --seed
	@printf "${GREEN}✓ Database refreshed!${NC}\n"

db-shell:
	docker exec -it starterkit-db psql -U postgres starterkit

backup:
	@mkdir -p backups
	@docker exec starterkit-db pg_dump -U postgres starterkit > backups/db-backup-$(shell date +%Y%m%d-%H%M%S).sql
	@printf "${GREEN}✓ Backup created in backups/ directory${NC}\n"

restore:
	@if [ -z "$(FILE)" ]; then \
		printf "${YELLOW}Usage: make restore FILE=backups/db-backup.sql${NC}\n"; \
		exit 1; \
	fi
	@docker exec -i starterkit-db psql -U postgres starterkit < $(FILE)
	@printf "${GREEN}✓ Database restored!${NC}\n"

db-show:
	@printf "${GREEN}🗂️  Showing current database info...${NC}\n"
	@docker exec starterkit-app php artisan db:show

db-table:
	@if [ -z "$(TABLE)" ]; then \
		printf "${YELLOW}Usage: make db-table TABLE=table_name${NC}\n"; \
		exit 1; \
	fi
	@docker exec starterkit-app php artisan db:table $(TABLE)

# ============================================
# Testing
# ============================================

test:
	@printf "${GREEN}🧪 Running local tests...${NC}\n"
	@docker exec -it starterkit-app php artisan test

test-all:
	@printf "${GREEN}🧪 Running tests in APP_ENV=testing (parallel)...${NC}\n"
	@docker exec -e APP_ENV=testing starterkit-app php artisan optimize:clear
	@docker exec -e APP_ENV=testing starterkit-app php artisan test --env=testing --parallel
	@printf "${GREEN}✓ All tests completed.${NC}\n"

test-fresh:
	@printf "${GREEN}🔄 Clearing cache and running tests (testing env)...${NC}\n"
	@docker exec -e APP_ENV=testing starterkit-app php artisan optimize:clear
	@docker exec -e APP_ENV=testing starterkit-app php artisan test --env=testing
	@printf "${GREEN}✓ Tests executed after cache clear.${NC}\n"

test-coverage:
	@printf "${GREEN}🧪 Generating coverage report (testing env)...${NC}\n"
	@docker exec -e APP_ENV=testing starterkit-app php artisan optimize:clear
	@docker exec -e APP_ENV=testing starterkit-app php artisan test --env=testing --coverage-html storage/coverage
	@printf "${GREEN}✓ Coverage report generated at storage/coverage/index.html${NC}\n"

# ============================================
# Code Quality
# ============================================

pint:
	docker exec starterkit-app ./vendor/bin/pint

check:
	docker exec starterkit-app ./vendor/bin/pint --test

ide:
	@printf "${GREEN}🔧 Generating IDE helpers...${NC}\n"
	@docker exec starterkit-app php artisan ide-helper:generate
	@docker exec starterkit-app php artisan ide-helper:models --nowrite
	@docker exec starterkit-app php artisan ide-helper:meta
	@printf "${GREEN}✓ IDE helpers generated!${NC}\n"

# ============================================
# Laravel Tools
# ============================================

artisan:
	docker exec starterkit-app php artisan $(ARGS)

tinker:
	docker exec -it starterkit-app php artisan tinker

queue:
	docker exec -it starterkit-app php artisan queue:work

horizon:
	@printf "${GREEN}🌅 Horizon: http://localhost/horizon${NC}\n"

telescope:
	@printf "${GREEN}🔭 Telescope: http://localhost/telescope${NC}\n"

pulse:
	@printf "${GREEN}💓 Pulse: http://localhost/pulse${NC}\n"

# ============================================
# Cache & Optimization
# ============================================

cache:
	@docker exec starterkit-app php artisan cache:clear
	@docker exec starterkit-app php artisan config:clear
	@docker exec starterkit-app php artisan route:clear
	@docker exec starterkit-app php artisan view:clear
	@docker exec starterkit-app php artisan event:clear

clear:
	@docker exec starterkit-app php artisan optimize:clear

optimize:
	@docker exec starterkit-app php artisan optimize
	@docker exec starterkit-app php artisan config:cache
	@docker exec starterkit-app php artisan route:cache
	@docker exec starterkit-app php artisan view:cache

optimize-test:
	@docker exec -e APP_ENV=testing starterkit-app php artisan optimize

# ============================================
# Quick Aliases
# ============================================

ta: test-all
tf: test-fresh
ds: db-show
dt: db-table
oc: clear
ot: optimize-test
