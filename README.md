# La LEAGLE CUP

LEAGLE CUP is a website for golf lovers.

![leaglecup](screenshot.png)

## PHPCS

### Install the WordPress rules

```json
{
    "require": {
        "squizlabs/php_codesniffer": "2.*"
    }
}
```

```bash
composer update
```

```bash
composer create-project wp-coding-standards/wpcs:dev-master --no-dev
```

### Add the Rules to PHP CodeSniffer

```bash
vendor/bin/phpcs --config-set installed_paths wpcs
```
