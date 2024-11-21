
# —— Variables ——————————————————————————————————————————————————————————————
  DOCKER_COMPOSE 				= docker compose -f ./compose.yaml
  DOCKER_COMPOSE_PHP_FPM_EXEC 	= ${DOCKER_COMPOSE} exec -u www-data symfony-fakestore-php-fpm

  REDIS 		= ${DOCKER_COMPOSE} exec symfony-fakestore-redis
  SYMFONY		= ${DOCKER_COMPOSE_PHP_FPM_EXEC} bin/console

  PHPUNIT       = ./vendor/bin/phpunit
  PHPSTAN       = ./vendor/bin/phpstan
  PHP_CS_FIXER  = ./vendor/bin/php-cs-fixer
  PHPMETRICS    = ./vendor/bin/phpmetrics

  NPM = npm run

.DEFAULT_GOAL := help
.PHONY: help


help: ## List of commands
	@grep -E '(^[a-zA-Z0-9\./_-]+:.*\n?## .*$$)|(^##)' $(MAKEFILE_LIST) \
			| awk 'BEGIN {FS = ":.*?## "};{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2 } ' \
			| sed -e 's/\[32m##/[33m/'
sf: ## List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
	@$(eval c ?=)
	@$(SYMFONY) $(c)

##
## —— Docker ————————————————————————————————————————————————————————————————

dc_build: ## Docker compose build
	${DOCKER_COMPOSE} build

dc_start: ## Docker compose start
	${DOCKER_COMPOSE} start

dc_stop: ## Docker compose stop
	${DOCKER_COMPOSE} stop

dc_up: ## Docker compose up
	${DOCKER_COMPOSE} up -d --remove-orphans

dc_down: ## Docker compose down
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

dc_ps: ## Docker compose containers list
	${DOCKER_COMPOSE} ps

dc_logs: ## Docker compose logs
	${DOCKER_COMPOSE} logs -f

dc_kill: ## Docker compose kill
	${DOCKER_COMPOSE} kill
	${DOCKER_COMPOSE} down --volumes --remove-orphans

dc_fix_perm: ## Fix permissions of docker files
	@chmod -R 777 docker/*

dc_restart: ## Docker compose restart
dc_restart: \
	dc_stop \
	dc_start

dc_rebuild: ## Docker compose rebuild
dc_rebuild: 	\
	dc_down 	\
	dc_build 	\
	dc_up

##
## —— Database ——————————————————————————————————————————————————————————————
db_migrate: ## Migrate doctrine migration
	${SYMFONY} doctrine:migrations:migrate --no-interaction

db_diff: ## Diff doctrine migrations
	${SYMFONY} doctrine:migrations:diff --no-interaction

db_migration: ## Create doctrine migration
	${SYMFONY} make:migration

db_fixtures_load: ## Loads doctrine fixture (only appends data)
	${SYMFONY} doctrine:fixtures:load --append

db_schema_validate: ## Schema validation
	${SYMFONY} doctrine:schema:validate

db_migration_down: ## Doctrine migration down param: ${Version**************}
	${SYMFONY} doctrine:migrations:execute ${MIGRATION} --down --dry-run

db_drop: ## DROP DATABASE!!!!! CREATE BACKUP BEFORE THIS
	${SYMFONY} doctrine:schema:drop --force

db_up: ## Database up and update
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:schema:update --force

##
## —— Cache —————————————————————————————————————————————————————————————————

cache_clear: ## Clear the cache. DID YOU CLEAR YOUR CACHE????
	${SYMFONY} cache:clear
	${SYMFONY} cache:clear --env=test

cache_warmup: ## Warmup the cache
	${SYMFONY} cache:warmup

cache_fix_perm: ## Fix permissions of all var files
	@chmod -R 777 var/*

cache_purge: ## Purge cache and logs
	@rm -rf var/cache/* var/log/*

cache_redis_clear: ## Clear redis cache
	${REDIS} redis-cli FLUSHALL

##
## —— App build && execution ————————————————————————————————————————————————
app_redis: ## Redis cli
	${REDIS} redis-cli

app_bash: ## Exec php
	${DOCKER_COMPOSE_PHP_FPM_EXEC} bash

app_composer_install: ## Install composer
	${DOCKER_COMPOSE_PHP_FPM_EXEC} composer install --no-progress --prefer-dist --optimize-autoloader

app_composer_update: ## Composer updating
	${DOCKER_COMPOSE_PHP_FPM_EXEC} composer update


app_build_prod: ## Build prod env (docker, composer, db, frontend build)
app_build_prod: 			\
	dc_build				\
	dc_up					\
	app_composer_install	\
	db_diff					\
	db_migrate				\

app_down: ## APP DOWN !!!!! DROPPING DB && DOCKER CONTAINERS
app_down:		\
	db_drop		\
	dc_down

##
## —— Coding standards ——————————————————————————————————————————————————————

stan: ## Run PHPStan
	@${SYMFONY} analyse -c configuration/phpstan.neon --memory-limit 1G

psalm: ## Run PSALM
	${DOCKER_COMPOSE_PHP_FPM_EXEC} psalm

lint-yaml: ## Lints YAML coding standarts
	${SYMFONY} lint:yaml config --parse-tags

eslint-js: ## Lints JS coding standarts
	npm run lint-js

php-cs-fixer: ## Lint files with php-cs-fixer
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix src/  --allow-risky=yes --dry-run --diff --verbose

php-cs-fixer-fix: ## Fix files with php-cs-fixer
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix src/  --allow-risky=yes--diff --verbose


##
## —— Project comands ———————————————————————————————————————————————————————

db_command_create_sub_cat: ## Add sub category ${Name} ${CategoryID}
	${SYMFONY} app:create-sub-cat ${Name} ${CategoryID}


db_update_rates: ## Update cur rates for today
	${SYMFONY} app:update-currency-rates