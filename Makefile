PHP := php
APP := src/index.php

.DEFAULT_GOAL := help
.PHONY: help install users-show user-add user-delete cs-fix cs-check

help: ## Показать список команд
	@grep -E '^[a-zA-Z_-]+:.*?## ' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-14s\033[0m %s\n", $$1, $$2}'

install: ## Установить зависимости
	composer install

users-show: ## Показать всех пользователей
	$(PHP) $(APP) users:show

user-add: ## Добавить: make user-add name=Anar surname=Guliyev email=anar@mail.ru
	$(PHP) $(APP) user:add "name=$(name)" "surname=$(surname)" "email=$(email)"

user-delete: ## Удалить: make user-delete id=58
	$(PHP) $(APP) user:delete "$(id)"

cs-fix: ## Отформатировать код
	vendor/bin/php-cs-fixer fix

cs-check: ## Проверить стиль кода
	vendor/bin/php-cs-fixer fix --dry-run --diff