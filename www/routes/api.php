<?php

use Src\Route;

Route::add('GET', '/products', [Controller\Api::class, 'index']);
Route::add('POST', '/echo', [Controller\Api::class, 'echo']);
Route::add('POST', '/signup', [Controller\Api::class, 'signup']);
Route::add('POST', '/login', [Controller\Api::class, 'login']);