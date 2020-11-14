<?php

// This file is referenced by the opcache.preload ini option
// Your preloader may contain additional code

// Require the autoloader
require_once __DIR__ . '/autoload.php';

// Start the preloading
\Opis\Closure\SerializableClosure::preload();

