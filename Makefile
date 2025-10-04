# Automate commands

up:
	composer update
	@echo "Cleaning cache"
	symfony console cache:clear
	@echo "Starting containers in development"
	docker compose up -d --build

down:
	@echo "Downing containters"
	@docker compose --profile '*' down --remove-orphans

prune:
	docker volume prune -a
	docker network prune
	docker system prune -a

status:
	@docker ps -a --format 'table {{.ID}}\t{{.Image}}\t{{.RunningFor}}\t{{.Status}}\t{{.Names}}\t{{.State}}\t{{.Size}}\t{{.Mounts}}\t{{.Networks}}'