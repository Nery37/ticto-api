CONTAINER_NAME=ticto-api

git-hooks:
	@cp tools/pre-commit.sh .git/hooks/pre-commit
	@chmod +x .git/hooks/pre-commit

install:
	make force-recreate
	make composer-install
	make migrate
	make seed
	make clear

up:
	docker-compose up -d

down:
	docker-compose down

bash:
	make up
	docker exec -it $(CONTAINER_NAME) sh

build:
	docker-compose build

force-recreate:
	docker-compose up -d --force-recreate --build
	docker exec -it $(CONTAINER_NAME) chown -R www-data:www-data /var/www/bootstrap/cache
	docker exec -it $(CONTAINER_NAME) chmod -R 775 /var/www/bootstrap/cache

	docker exec -it $(CONTAINER_NAME) chown -R www-data:www-data /var/www/storage
	docker exec -it $(CONTAINER_NAME) chmod -R 775 /var/www/storage

composer-install:
	make up
	docker exec $(CONTAINER_NAME) composer install

migrate:
	make up
	docker exec $(CONTAINER_NAME) php artisan migrate --seed

seed:
	make up
	docker exec $(CONTAINER_NAME) php artisan db:seed

logs:
	make up
	docker-compose logs --follow

clear:
	make up
	docker exec $(CONTAINER_NAME) sh -c "php artisan optimize:clear"

format:
	make up
	docker exec -t $(CONTAINER_NAME) composer lint-fix

test:
	make up
	docker exec $(CONTAINER_NAME) sh -c "php artisan test"

migrate-fresh:
	make up
	docker exec $(CONTAINER_NAME) php artisan migrate:fresh
	docker exec $(CONTAINER_NAME) php artisan migrate --seed

queue:
	docker exec $(CONTAINER_NAME) php artisan queue:work --memory=1024 --timeout=900
