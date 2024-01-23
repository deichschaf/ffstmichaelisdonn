@echo off
echo Artisan Config Clear wird gestartet.
call c:\php\php.exe artisan config:clear
echo Artisan Config Clear wird beendet.

@echo off
echo Artisan Cache Clear wird gestartet.
call c:\php\php.exe artisan cache:clear
echo Artisan Cache Clear wird beendet.

@echo off
echo Artisan View Clear wird gestartet.
call c:\php\php.exe artisan view:clear
echo Artisan View Clear wird beendet.

@echo off
echo Artisan Vendor Publish wird gestartet.
call c:\php\php.exe artisan vendor:publish --force --all
echo Artisan Vendor Publish wird beendet.

@echo off
echo Composer DU wird gestartet.
call c:\php\php.exe composer.phar dump-autoload
echo Composer DU wird beendet.
