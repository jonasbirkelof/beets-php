<?php

namespace App\Controllers;

use App\Models\Product;
use function App\Helpers\view;

class ProductController
{
	public static function index()
	{
		return view('products/index.php', [
			'title' => 'Products',
			'productsList' => Product::getAll()
		]);
	}
}