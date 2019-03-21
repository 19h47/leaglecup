.PHONY: create_project
create_project: vendor/bin/phpcs ## Install wp-coding-standards/wpcs
	composer create-project wp-coding-standards/wpcs:dev-master --no-dev
