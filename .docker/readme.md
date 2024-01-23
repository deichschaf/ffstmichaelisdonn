# Create ffstmichaelisdonn-network (once)
docker network create --driver bridge ffstmichaelisdonn-network --subnet 10.120.0.0/24

# Docker usage

### Start docker containers
docker-compose up

### Stop docker containers
docker-compose stop

### Stop and remove docker containers
docker-compose down

### Yarn deploy in docker
yarn deploy-docker

### Yarn dev in docker
yarn dev-docker

### Execute new named docker service with executable
docker run -it {serviceName} {exec}
##### example
docker run -it api bash

### show running docker containers
docker ps

### Execute executable on already running container (-it = interactive)
docker exec -it {containerName} {exec}
##### example
docker exec -it ffstmichaelisdonn bash

### add current user to docker group (no more sudo for linux devs)
sudo usermod -aG docker $USER

### Start yarn dev server in docker container
yarn dev-docker
# or
docker-compose run ffstmichaelisdonn-node 'sh -c cd /app && yarn prod'

### UPDATE an laravel/framework Package
docker-compose run --rm ffstmichaelisdonn-composer php -d memory_limit=2G /usr/local/bin/composer update laravel/framework -vvv


docker-compose run --rm ffstmichaelisdonn-composer php -d memory_limit=2G /usr/local/bin/composer require tinify/tinify -vvv
