:loop
cls
php artisan schedule:run
timeout /t 60
goto loop