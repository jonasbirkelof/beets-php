<?php

namespace App\Controllers;

use App\Models\Product;
use function App\Helpers\view;

class ProductController
{
	public static function index()
	{
		return view('products.index', [
			'title' => 'Products'
		], Product::getAll());
	}
}