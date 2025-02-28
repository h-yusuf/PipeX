<h5>Laravel Version : 8</h5>

### check ip local linux
`ip a`

### connection to ip local
`php artisan serve --host=192.168.5.234 --port=8000`

### running ip + port
`http://192.168.5.234:8000`

## cronJob 

`crontab -e`

### path 

* * * * * /usr/bin/php /home/sach/Dokumen/maintenance_plan/artisan schedule:run >> /dev/null 2>&1

### date changes

sudo date -s "last week"
sudo date -s "now"# PipeX
