# Short Mongo ID for PHP
Generates a short string identifier from a MongoId value.

This repository is a PHP port of the npm/javascript library created by treygriffith.
The usage and preamble of the following documentation is taken from that repository and modified for use with PHP.
The original repo can be found here: https://github.com/treygriffith/short-mongo-id

========

Id's are generated from the timestamp and counter of the MongoDB Id, with some slight variation. They should be reasonably unique.

This is, unfortunately, a one-way function. It will reliably produce the same short id for the same MongoDB Id, but the operation can't be reversed (it is missing information about the machine id, process id, and most of the counter).

Install
-------
Use Composer:

```bash
$ composer require as3/short-mongo-id
```

Usage
-----

Pass a PHP MongoId object (or a string that can be converted to one) and it will return a reasonably unique short id made of `[-_a-zA-Z0-9]`.

```php
use As3\ShortMongoId\Shortener;

$shortener = new Shortener();
$shortId   = $shortener->shorten('507f191e810c19729de860ea'); // returns "iTxuMF"

```

License
-------
MIT (see [License](LICENSE))
