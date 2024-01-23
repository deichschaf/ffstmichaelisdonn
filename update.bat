@echo off
color 0A
echo ................Composer Update wird gestartet.
color 0F
call c:\php\php.exe composer.phar self-update
color 0A
echo ................Composer Update wird beendet.

@echo off
color 0A
echo ................Composer Update wird gestartet.
color 0F
call c:\php\php.exe -d memory_limit=-1  composer.phar update -vvv
color 0A
echo ................Composer Update wird beendet.

@echo off
color 0A
echo ................Remove NodeModules start
color 0F
call rmdir node_modules /s /q
color 0A
echo ................Remove NodeModules beendet.

@echo off
color 0A
echo ................NPM Outdated wird gestartet.
color 0F
call npm outdated
color 0A
echo ................NPM Outdated wird beendet.

@echo off
color 0A
echo ................NPM Update wird gestartet.
color 0F
call npm update
color 0A
echo ................NPM Update wird beendet.

@echo off
color 0A
echo ................Remove NodeModules start
color 0F
call rmdir node_modules /s /q
color 0A
echo ................Remove NodeModules beendet.

@echo off
color 0A
echo ................NPM Update wird gestartet.
color 0F
call npm i
color 0A
echo ................NPM Update wird beendet.

@echo off
color 0A
echo ................NPM Fix starten.
color 0F
call npm audit fix
color 0A
echo ................NPM Fix wird beendet.

@echo off
color 0A
echo ................PHP Cache starten.
color 0F
call phpcache.bat
color 0A
echo ................PHP Cache wird beendet.

@echo off
color 0A
echo ................PHP Publish starten.
color 0F
call phppublish.bat
color 0A
echo ................PHP Publish wird beendet.

@echo off
color 0A
echo ................PHP CS FIX starten.
color 0F
call phpcsfix.bat
color 0A
echo ................PHP CS FIX wird beendet.
