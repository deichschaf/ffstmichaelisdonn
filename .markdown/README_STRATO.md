# Ausrollen auf dem Strato Server
## Git ausrollen + ggf. Hochgeladene Dateien im Git speichern
```
git fetch; git add .; git checkout master; git pull; git commit -m "After Upload over Backend"; git push;
```
## Composer installieren
```
/usr/bin/php  -d memory_limit=-1 composer.phar install
```

## Fehlerbehebung
```
git fetch --all
```
```
git reset --hard origin/master
```
```
git pull origin master
```
