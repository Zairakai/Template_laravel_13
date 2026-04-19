# {{APP_NAME}}

> {{APP_DESCRIPTION}}

## Requirements

- Docker
- Make

## Setup

### 1. Replace placeholders

Search and replace the following across the project before anything else:

| Placeholder | Example | Files |
| :--- | :--- | :--- |
| `{{VENDOR}}` | `zairakai` | `composer.json` |
| `{{APP_SLUG}}` | `my-app` | `composer.json`, `package.json`, `.env.example`, `.env.production` |
| `{{APP_NAME}}` | `My App` | `README.md`, `composer.json`, `.env.example`, `.env.production` |
| `{{APP_DESCRIPTION}}` | `Short description` | `README.md`, `package.json` |
| `{{GITLAB_PATH}}` | `zairakai/apps/my-app` | `composer.json`, `package.json` |

> **Also update manually:** `composer.json` → `keywords[]`, `authors[]` — prefilled with template values.

### 2. Configure environment

```bash
cp .env.example .env
# Edit .env — fill in DB, Redis, and any required values
```

> **Seeding variables** (used by `php artisan db:seed`):
>
> | Variable | Default | Description |
> | :--- | :--- | :--- |
> | `ADMIN_EMAIL` | `admin@example.com` | Email of the admin account created by `Common/UserSeeder` |
> | `ADMIN_PASSWORD` | value of `DEFAULT_PASSWORD` | Password override for the admin account |
> | `DEFAULT_PASSWORD` | `password` | Default password applied to all seeded accounts |

### 3. Start & install

```bash
make up
make shell          # enter PHP container
composer install    # also runs dev-tools setup automatically
exit
make shell-node     # enter Node container
npm install         # also runs js-dev-tools setup automatically
exit
```

### 4. Initialize

```bash
make shell
php artisan key:generate
php artisan migrate
exit
```

> **Note:** `composer install` and `npm install` automatically configure dev-tools
> (Makefile targets, quality configs, git hooks) via their respective `postinstall` hooks.
> Run `make help` to see all available targets.
>
> **JS targets** (`package-install`, `package-update`, ESLint, Stylelint, Knip, TypeScript…)
> are only available after `npm install` — `fullstack.mk` loads them conditionally from
> `node_modules/@zairakai/js-dev-tools`. Run `npm install` before using any JS-related make target.

## Usage

```bash
make help           # list all available commands
make up / down      # start / stop Docker services
make quality        # run full quality gate (PHP + JS)
make test           # run tests
make ci             # full CI pipeline
```

## Services

All services start with `make up`. Override any port via `.env`.

| Service | URL | Override variable | Credentials |
| :--- | :--- | :--- | :--- |
| Application | `http://localhost:80` | `APP_PORT` | — |
| Vite (HMR) | `http://localhost:5173` | `VITE_PORT` | — |
| Adminer (MySQL) | `http://localhost:8080` | `FORWARD_ADMINER_PORT` | System: `MySQL` · Server: `mysql` · User / Password / DB: see `DB_*` in `.env` |
| RedisInsight | `http://localhost:5540` | `FORWARD_REDISINSIGHT_PORT` | Host: `redis` · Port: `6379` · No password |
| Mailpit | `http://localhost:8025` | `FORWARD_MAILPIT_DASHBOARD_PORT` | No authentication |
| MinIO Console | `http://localhost:9001` | `FORWARD_MINIO_CONSOLE_PORT` | `MINIO_ROOT_USER` / `MINIO_ROOT_PASSWORD` |
