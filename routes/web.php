<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RuleController;

Route::get('/', function () {
    return redirect()->route('products.index');
});



// Products
Route::resource('products', ProductController::class);

// Rules
Route::resource('rules', RuleController::class);
Route::post('rules/{rule}/apply', [RuleController::class, 'applyRule'])->name('rules.apply');