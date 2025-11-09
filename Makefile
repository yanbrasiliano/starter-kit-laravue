.PHONY: help up down restart logs shell migrate fresh test front build clean ps install npm composer artisan tinker db-shell cache optimize queue horizon telescope pulse ide pint format check deploy backup restore

# Colors for output
GREEN  := \033[0;32m
YELLOW := \033[0;33m
NC     := \033[0m # No Color

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
	@printf '  make front       - Run Vite dev server\n'
	@printf '  make install     - Install PHP and NPM dependencies\n'
	@printf '  make fresh       - Fresh database with seeds\n'
	@printf '  make cache       - Clear all Laravel caches\n'
	@printf '  make optimize    - Optimize for production\n'
	@printf '\n'
	@printf '${YELLOW}🗄️  Database:${NC}\n'
	@printf '  make migrate     - Run migrations\n'
	@printf '  make rollback    - Rollback last migration\n'
	@printf '  make db-shell    - Enter PostgreSQL shell\n'
	@printf '  make db-reset    - Reset database\n'
	@printf '  make backup      - Backup database\n'
	@printf '  make restore     - Restore database from backup\n'
	@printf '\n'
	@printf '${YELLOW}🧪 Testing:${NC}\n'
	@printf '  make test        - Run all tests\n'
	@printf '  make test-unit   - Run unit tests\n'
	@printf '  make test-feature - Run feature tests\n'
	@printf '  make coverage    - Generate test coverage report\n'
	@printf '\n'
	@printf '${YELLOW}✨ Code Quality:${NC}\n'
	@printf '  make pint        - Run Laravel Pint (code formatting)\n'
	@printf '  make format      - Format code with Pint\n'
	@printf '  make check       - Check code style without fixing\n'
	@printf '  make ide         - Generate IDE helper files\n'
	@printf '\n'
	@printf '${YELLOW}🛠️  Artisan & Tools:${NC}\n'
	@printf '  make artisan     - Run artisan command (e.g., make artisan ARGS="make:model Post")\n'
	@printf '  make tinker      - Open Laravel Tinker\n'
	@printf '  make queue       - Run queue worker\n'
	@printf '  make horizon     - Open Laravel Horizon dashboard\n'
	@printf '  make telescope   - Open Laravel Telescope\n'
	@printf '  make pulse       - Open Laravel Pulse\n'
	@printf '\n'
	@printf '${YELLOW}🔧 Utilities:${NC}\n'
	@printf '  make clean       - Clean temporary files and caches\n'
	@printf '  make npm         - Run npm command (e.g., make npm ARGS="install lodash")\n'
	@printf '  make composer    - Run composer command (e.g., make composer ARGS="require package")\n'
	@printf '\n'
	@printf '${YELLOW}⚡ Quick Shortcuts:${NC}\n'
	@printf '  make m           - migrate\n'
	@printf '  make mf          - fresh\n'
	@printf '  make t           - test\n'
	@printf '  make s           - shell\n'
	@printf '  make l           - logs\n'
	@printf '  make c           - cache\n'
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

logs-app: ## Follow app logs
	docker compose logs -f app

logs-nginx: ## Follow nginx logs
	docker compose logs -f nginx

logs-db: ## Follow database logs
	docker compose logs -f db

# ============================================
# Development
# ============================================

shell: ## Enter app container shell
	docker exec -it starterkit-app sh

shell-root: ## Enter app container as root
	docker exec -u root -it starterkit-app sh

front: ## Run Vite dev server
	docker exec -it starterkit-app npm run dev

build-assets: ## Build production assets
	docker exec starterkit-app npm run build

watch: ## Watch and rebuild assets
	docker exec -it starterkit-app npm run dev

install: ## Install all dependencies
	@printf "${GREEN}📦 Installing dependencies...${NC}\n"
	@docker exec starterkit-app composer install
	@docker exec starterkit-app npm install
	@printf "${GREEN}✓ Dependencies installed!${NC}\n"

npm: ## Run npm command (use: make npm ARGS="install package")
	docker exec starterkit-app npm $(ARGS)

composer: ## Run composer command (use: make composer ARGS="require package")
	docker exec starterkit-app composer $(ARGS)

# ============================================
# Database
# ============================================

migrate: ## Run migrations
	@printf "${GREEN}🔄 Running migrations...${NC}\n"
	@docker exec starterkit-app php artisan migrate
	@printf "${GREEN}✓ Migrations complete!${NC}\n"

rollback: ## Rollback last migration
	docker exec starterkit-app php artisan migrate:rollback

fresh: ## Fresh database with seeds
	@printf "${YELLOW}⚠️  This will drop all tables and reseed!${NC}\n"
	@docker exec starterkit-app php artisan migrate:fresh --seed
	@printf "${GREEN}✓ Database refreshed!${NC}\n"

db-reset: ## Reset database (drop and recreate)
	@printf "${YELLOW}⚠️  Resetting database...${NC}\n"
	@docker compose down
	@docker volume rm starterkit_pg_data || true
	@docker compose up -d db
	@printf "Waiting for database...\n"
	@sleep 5
	@docker compose up -d
	@sleep 5
	@docker exec starterkit-app php artisan migrate
	@printf "${GREEN}✓ Database reset complete!${NC}\n"

db-shell: ## Enter PostgreSQL shell
	docker exec -it starterkit-db psql -U postgres starterkit

backup: ## Backup database to backups/db-backup-TIMESTAMP.sql
	@mkdir -p backups
	@printf "${GREEN}💾 Creating backup...${NC}\n"
	@docker exec starterkit-db pg_dump -U postgres starterkit > backups/db-backup-$(date +%Y%m%d-%H%M%S).sql
	@printf "${GREEN}✓ Backup created in backups/ directory${NC}\n"

restore: ## Restore database from backup (use: make restore FILE=backups/file.sql)
	@if [ -z "$(FILE)" ]; then \
		printf "${YELLOW}Usage: make restore FILE=backups/db-backup-YYYYMMDD-HHMMSS.sql${NC}\n"; \
		exit 1; \
	fi
	@printf "${YELLOW}⚠️  Restoring database from $(FILE)...${NC}\n"
	@docker exec -i starterkit-db psql -U postgres starterkit < $(FILE)
	@printf "${GREEN}✓ Database restored!${NC}\n"

# ============================================
# Testing
# ============================================

test: ## Run all tests
	@printf "${GREEN}🧪 Running tests...${NC}\n"
	@docker exec -it starterkit-app composer tests

test-unit: ## Run unit tests
	docker exec starterkit-app php artisan test --testsuite=Unit

test-feature: ## Run feature tests
	docker exec starterkit-app php artisan test --testsuite=Feature

coverage: ## Generate test coverage report
	docker exec starterkit-app php artisan optimize:clear && php artisan test --coverage

test-watch: ## Watch and run tests on file changes
	docker exec -it starterkit-app php artisan test --watch

# ============================================
# Code Quality
# ============================================

pint: ## Run Laravel Pint (fix code style)
	docker exec starterkit-app ./vendor/bin/pint

format: pint ## Alias for pint

check: ## Check code style without fixing
	docker exec starterkit-app ./vendor/bin/pint --test

ide: ## Generate IDE helper files
	@printf "${GREEN}🔧 Generating IDE helpers...${NC}\n"
	@docker exec starterkit-app php artisan ide-helper:generate
	@docker exec starterkit-app php artisan ide-helper:models --nowrite
	@docker exec starterkit-app php artisan ide-helper:meta
	@printf "${GREEN}✓ IDE helpers generated!${NC}\n"

# ============================================
# Laravel Artisan & Tools
# ============================================

artisan: ## Run artisan command (use: make artisan ARGS="make:model Post")
	docker exec -u root starterkit-app php artisan $(ARGS)

tinker: ## Open Laravel Tinker
	docker exec -it starterkit-app php artisan tinker

queue: ## Run queue worker
	docker exec -it starterkit-app php artisan queue:work

queue-listen: ## Listen to queue
	docker exec -it starterkit-app php artisan queue:listen

horizon: ## View Laravel Horizon
	@printf "${GREEN}🌅 Horizon: http://localhost/horizon${NC}\n"
	@command -v xdg-open > /dev/null && xdg-open http://localhost/horizon 2>/dev/null || \
	 command -v open > /dev/null && open http://localhost/horizon 2>/dev/null || \
	 printf "Open http://localhost/horizon in your browser\n"

telescope: ## View Laravel Telescope
	@printf "${GREEN}🔭 Telescope: http://localhost/telescope${NC}\n"
	@command -v xdg-open > /dev/null && xdg-open http://localhost/telescope 2>/dev/null || \
	 command -v open > /dev/null && open http://localhost/telescope 2>/dev/null || \
	 printf "Open http://localhost/telescope in your browser\n"

pulse: ## View Laravel Pulse
	@printf "${GREEN}💓 Pulse: http://localhost/pulse${NC}\n"
	@command -v xdg-open > /dev/null && xdg-open http://localhost/pulse 2>/dev/null || \
	 command -v open > /dev/null && open http://localhost/pulse 2>/dev/null || \
	 printf "Open http://localhost/pulse in your browser\n"

# ============================================
# Cache Management
# ============================================

cache: ## Clear all caches
	@printf "${GREEN}🧹 Clearing caches...${NC}\n"
	@docker exec starterkit-app php artisan cache:clear
	@docker exec starterkit-app php artisan config:clear
	@docker exec starterkit-app php artisan route:clear
	@docker exec starterkit-app php artisan view:clear
	@docker exec starterkit-app php artisan event:clear
	@printf "${GREEN}✓ Caches cleared!${NC}\n"

cache-config: ## Cache config files
	docker exec starterkit-app php artisan config:cache

cache-routes: ## Cache routes
	docker exec starterkit-app php artisan route:cache

cache-views: ## Cache views
	docker exec starterkit-app php artisan view:cache

optimize: ## Optimize application for production
	@printf "${GREEN}⚡ Optimizing application...${NC}\n"
	@docker exec starterkit-app php artisan optimize
	@docker exec starterkit-app php artisan config:cache
	@docker exec starterkit-app php artisan route:cache
	@docker exec starterkit-app php artisan view:cache
	@printf "${GREEN}✓ Optimization complete!${NC}\n"

# ============================================
# Utilities
# ============================================

clean: ## Clean temporary files and caches
	@printf "${GREEN}🧹 Cleaning up...${NC}\n"
	@docker exec starterkit-app rm -rf storage/framework/cache/data/*
	@docker exec starterkit-app rm -rf storage/framework/sessions/*
	@docker exec starterkit-app rm -rf storage/framework/views/*
	@docker exec starterkit-app rm -rf bootstrap/cache/*.php
	@printf "${GREEN}✓ Cleanup complete!${NC}\n"

permissions: ## Fix permissions
	@printf "${GREEN}🔒 Fixing permissions...${NC}\n"
	@docker exec starterkit-app chown -R www-data:www-data /app/storage /app/bootstrap/cache
	@docker exec starterkit-app chmod -R 775 /app/storage /app/bootstrap/cache
	@printf "${GREEN}✓ Permissions fixed!${NC}\n"

deploy: ## Deploy application (optimize & migrate)
	@printf "${GREEN}🚀 Deploying application...${NC}\n"
	@$(MAKE) down
	@$(MAKE) build
	@$(MAKE) up
	@sleep 5
	@$(MAKE) migrate
	@$(MAKE) optimize
	@printf "${GREEN}✓ Deployment complete!${NC}\n"

status: ## Show application status
	@printf "${GREEN}📊 Application Status:${NC}\n\n"
	@docker compose ps
	@printf "\n${GREEN}Services:${NC}\n"
	@printf "  App:      http://localhost\n"
	@printf "  Mailpit:  http://localhost:8025\n"
	@printf "  Database: localhost:5432\n"
	@printf "  Redis:    localhost:6379\n"

# ============================================
# Quick Commands (Shortcuts)
# ============================================

m: migrate ## Shortcut for migrate
mf: fresh ## Shortcut for fresh
t: test ## Shortcut for test
s: shell ## Shortcut for shell
l: logs ## Shortcut for logs
c: cache ## Shortcut for cache