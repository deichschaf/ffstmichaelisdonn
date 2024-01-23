@echo off
echo EditorConfig Linter Start
call eclint fix 'app/**/*'
call eclint fix 'resources/**/*'
call eclint fix '.docker/**/*'
call eclint fix '.markdown/**/*'
call eclint fix '.github/**/*'
call eclint fix 'config/**/*'
call eclint fix 'public/**/*'
call eclint fix 'routes/**/*'
call eclint fix 'tests/**/*'
echo EditorConfig Linter END
