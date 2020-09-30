php artisan queue:work --queue=local:payments,local:emails,local:general --tries=3 --sleep=3
