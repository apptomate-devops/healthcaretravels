php artisan queue:work --queue=local:payments,local:emails --tries=3 --sleep=3
