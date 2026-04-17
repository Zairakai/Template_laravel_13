##@ Docker

PHP_SERVICE  ?= php
NODE_SERVICE ?= node

# Container lifecycle

.PHONY: up
up: ## Start all Docker services
	docker compose up -d

.PHONY: down
down: ## Stop all Docker services
	docker compose down

.PHONY: restart
restart: ## Restart all Docker services
	docker compose restart

##

# Shell access

.PHONY: shell
shell: ## Open a shell in the PHP container (PHP_SERVICE=name)
	docker compose exec $(PHP_SERVICE) sh

.PHONY: shell-node
shell-node: ## Open a shell in the Node container (NODE_SERVICE=name)
	docker compose exec $(NODE_SERVICE) sh

.PHONY: logs
logs: ## Follow logs (SERVICE=name to filter)
	docker compose logs -f $(SERVICE)

##

# CI and quality inside containers

.PHONY: docker-ci
docker-ci: ## Run full CI pipeline inside the PHP container
	docker compose exec $(PHP_SERVICE) make ci

.PHONY: docker-quality
docker-quality: ## Run quality checks inside the PHP container
	docker compose exec $(PHP_SERVICE) make quality

.PHONY: docker-test
docker-test: ## Run PHP tests inside the PHP container
	docker compose exec $(PHP_SERVICE) make test

##

# Front-end

.PHONY: front-dev
front-dev: ## Start Vite dev server in the Node container (HMR)
	docker compose exec $(NODE_SERVICE) npm run dev

.PHONY: front-build
front-build: ## Build front-end assets for production in the Node container
	docker compose exec $(NODE_SERVICE) npm run build
