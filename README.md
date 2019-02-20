# La LEAGLE CUP

LEAGLE CUP is a website for golf lovers.

![leaglecup](screenshot.png)

## PHPCS

### Install the WordPress rules

Add __PHP_CodeSniffer__ to the `composer.json` file

```json
{
    "require": {
        "squizlabs/php_codesniffer": "*"
    }
}
```

Then update dependencies

```bash
composer update
```

Create the project

```bash
composer create-project wp-coding-standards/wpcs:dev-master --no-dev
```

### Add the Rules to PHP CodeSniffer

```bash
vendor/bin/phpcs --config-set installed_paths wpcs
```
