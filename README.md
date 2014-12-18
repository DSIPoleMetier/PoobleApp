PoobleApp
=========

Application de gestion de participation à un évenement.


Installation
------------

Clone the project:
```sh
$ git clone https://github.com/DSIPoleMetier/PoobleApp.git
```

Go inside the cloned folder and use Composer to install all the application dependencies:
```sh
$ php composer.phar update
```

Create the database schema:
```sh
$ php app/console doctrine:schema:update --force
```

Clear the cache:
```sh
$ php app/console cache:clear (--env=prod --no-debug)
```

Set the right permissions:
```sh
$ chown www-data -R app/cache/ app/logs/ && chmod 775 -R app/cache/ app/logs/
```


Tests
-----

To execute units and functionals tests:
```sh
$ phpunit -c app
```
