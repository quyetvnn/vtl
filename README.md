# Clean CMS Skeleton
This is a clean CMS skeleton for custom project, written in [CakePHP 2.9](http://book.cakephp.org/2.0/en/index.html) framework

-------------------------------------------------------------------------------

## Installation

1. Download and install [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.

2. Update **composer.json** accordingly.

3. Run `php composer.phar install`.

If Composer is installed globally, run `composer install`.

You should now be able to see the default home page or you can go to the dummy page (/pages/dummy).

-------------------------------------------------------------------------------

## Configuration

1. Read and edit `config/env.php`.
- Set values for Core (i.e. core.php)
- Set the credential to connect Database
- Set an unique 'Security.salt' and 'Security.cipherSeed' for encryption
- Set meta values for the site

2. Grant a full access right (0777) to the folders `tmp/` recursively.
```bash
sudo chmod -R 777 tmp/
```
