##@ Docker

PHP_SERVICE  ?= php
NODE_SERVICE ?= node

.PHONY: up down restart shell shell-node logs docker-ci docker-quality docker-test front-dev front-build

up: ## Start all Docker services
	docker compose up -d

down: ## Stop all Docker services
	docker compose down

restart: ## Restart all Docker services
	docker compose restart

shell: ## Open a shell in the PHP container (PHP_SERVICE=name)
	docker compose exec $(PHP_SERVICE) sh

shell-node: ## Open a shell in the Node container (NODE_SERVICE=name)
	docker compose exec $(NODE_SERVICE) sh

logs: ## Follow logs (SERVICE=name to filter)
	docker compose logs -f $(SERVICE)

docker-ci: ## Run full CI pipeline inside the PHP container
	docker compose exec $(PHP_SERVICE) make ci

docker-quality: ## Run quality checks inside the PHP container
	docker compose exec $(PHP_SERVICE) make quality

docker-test: ## Run PHP tests inside the PHP container
	docker compose exec $(PHP_SERVICE) make test

front-dev: ## Start Vite dev server in Node container (HMR)
	docker compose exec $(NODE_SERVICE) npm run dev

front-build: ## Build front-end assets for production in Node container
	docker compose exec $(NODE_SERVICE) npm run build
