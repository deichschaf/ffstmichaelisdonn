```
c:\php\php.exe c:\php\composer.phar clear-cache
```

```
npm cache clean --force
```

```
npm cache verify
```

```
git clone https://github.com/deichschaf/ffstmichaelisdonn.git .
```

```
git branch --merged | grep -v "\*" | grep -v master | grep -v dev | xargs -n 1 git branch -d
```

```
cd /ferienhof_git && git fetch && git checkout $(git describe --tags `git rev-list --tags --max-count=1`)
```

```
docker-compose run --rm ffstmichaelisdonn-composer php -d memory_limit=2G /usr/local/bin/composer update ek24/*
```

```
docker-compose run --rm ffstmichaelisdonn-node 'sh -c cd /app && yarn && yarn deploy'
```

```
git config --global user.name "From Webspace"
```

```
git config --global user.email git@j-mh.de
```

```
docker stop $(docker ps -a -q)
```

```
docker rm $(docker ps -a -q)
```

```
docker system prune --all --force --volumes
```

```
docker container prune
```

```
docker stop $(docker ps -a -q); docker rm $(docker ps -a -q); docker system prune --all --force --volumes; docker container prune
```

```
dstop() { docker stop $(docker ps -a -q); } alias dstop=dstop
```

~/.bashsc or ~/.profile

# Use `docker-cleanup --dry-run` to see what would be deleted

```
function docker-cleanup {
EXITED=$(docker ps -q -f status=exited)
DANGLING=$(docker images -q -f "dangling=true")

if [ "$1" === "--dry-run" ]; then
echo "==> Would stop containers:"
echo $EXITED
echo "==> And images:"
echo $DANGLING
else
if [ -n "$EXITED" ]; then
docker rm $EXITED
else
echo "No containers to remove."
fi
if [ -n "$DANGLING" ]; then
docker rmi $DANGLING
else
echo "No images to remove."
fi
fi
}
```
