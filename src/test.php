<?php

require __DIR__ . '/../vendor/autoload.php';

use Respect\Validation\Validator;
use Respect\Validation\Rules;
use Respect\Validation\Rules\Core\Simple;

Validator::create( new Rules\File() )->check( __DIR__ . '/test.php' ); // Example usage
