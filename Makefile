.PHONY: install tests coverage-clover coverage-html

install:
	composer update

tests:
	vendor/bin/tester tests/cases -s -p php -c tests/php-unix.ini

coverage-clover:
	vendor/bin/tester -s -p phpdbg --coverage ./coverage.xml --coverage-src ./src tests/cases

coverage-html:
	vendor/bin/tester -s -p phpdbg --coverage ./coverage.html --coverage-src ./src tests/cases
