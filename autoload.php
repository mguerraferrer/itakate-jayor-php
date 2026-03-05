<?php

spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);
    $possiblePaths = [
        __DIR__ . '/app/classes/' . $className . '.php',
        __DIR__ . '/app/controllers/admin/' . $className . '.php',
        __DIR__ . '/app/controllers/web/' . $className . '.php',
        __DIR__ . '/app/helpers/' . $className . '.php',
        __DIR__ . '/app/services/admin/' . $className . '.php',
        __DIR__ . '/app/services/web/' . $className . '.php',
        __DIR__ . '/app/traits/' . $className . '.php',
        __DIR__ . '/app/config/' . $className . '.php'
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});