# Zairakai Laravel Dev Tools - Full-Stack Makefile (PHP + JS)
# Includes unified targets from laravel-dev-tools and npm dev-tools.

LARAVEL_DIRECTORY_TOOLS_PROJECT_ROOT := $(shell pwd)
NPM_DIRECTORY_TOOLS_PROJECT_ROOT := $(shell pwd)

LARAVEL_DIRECTORY_TOOLS_PROJECT_NAME := "{{APP_NAME}}"
NPM_DIRECTORY_TOOLS_PROJECT_NAME := "{{APP_NAME}}"

.DEFAULT_GOAL := help

# Use Pest as test runner
export PHPUNIT_BIN := vendor/bin/pest

# Unified full-stack includes (CI targets: quality, test, ci, help…)
include vendor/zairakai/laravel-dev-tools/tools/make/fullstack.mk

# Project-specific Docker targets
include .make/docker.mk
