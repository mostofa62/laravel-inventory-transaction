# Laravel Inventory using Database Transaction
---------------------
#### Requirement
- Laravel 5.8
- PHP 7.1 or greater
- MySQL 5.5 or greater
- Git
### Installation

```sh
$ git clone https://github.com/mostofa62/laravel-inventory-transaction
$ cd laravel-inventory-transaction
$ composer install
```
For geenrating Database and Testing Data...

```sh
$ php artisan migrate
$ php artisan db:seed --class=ItemTableSeeder
```

### Testing Example Link
 - A table provied named `items` where you can find the `item_id`
 - A table provide named `stocks` where you can find the `stockid`

| Plugin | README | NOTES
| ------ | ------ |------
| INSERT ITEM STOCK (IN) | [/stock?item={item_id}&optype=1&quantity=4][PlDb] | optype=1 ( 1 = IN )
| PICK ITEM (IN) | [/stock?item={item_id}&optype=2&quantity=2][PlDb] | optype=2 ( 2 = OUT )
| UPDATE STOCK | [/stock/{stockid}?quantity=10][PlDb] | 
| DELETE STOCK | [/stock/d/{stockid}][PlDb] | 

### Some Important Link
- https://laravel.com/docs/5.8/database#database-transactions
- https://laravel.com/docs/5.8/queries#inserts
- https://laravel.com/docs/5.8/queries#updates
- https://laravel.com/docs/5.8/queries#deletes
- https://laravel.com/docs/5.8/queries#debugging
- https://laravel.com/docs/5.8/migrations#running-migrations
- http://arkylus.com
- https://dillinger.io

