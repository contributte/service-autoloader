<?php

/**
 * Test boostrap.
 */


if (@!include __DIR__ . '/../vendor/autoload.php') {
    echo 'Install Nette Tester using `composer update --dev`';
    exit(1);
}

// configure environment
Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');


// create temporary directory
define('TESTER_DIR', __DIR__);
define('TEMP_DIR', __DIR__ . '/tmp/' . getmypid());
@mkdir(dirname(TEMP_DIR)); // @ - directory may already exist
Tester\Helpers::purge(TEMP_DIR);


function test(\Closure $function)
{
    $function();
}