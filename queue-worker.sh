php artisan queue:work --queue=local:payments,local:emails,local:message,local:general --tries=3 --sleep=3
