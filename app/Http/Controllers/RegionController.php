<?php

// RegionController.php
namespace App\Http\Controllers;


use App\Models\Region;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class RegionController extends Controller
{
    public function show($name)
    {
        // Mapping of aliases to full region names
        $regionMapping = [
            'camnorte' => 'Camarines Norte',
            'camsur' => 'Camarines Sur',
            'albay' => 'Albay',
            'sorsogon' => 'Sorsogon',
            'catanduanes' => 'Catanduanes',
            'masbate' => 'Masbate',
        ];

        // Get the full region name using the alias
        $regionName = $regionMapping[$name] ?? null;

        if (!$regionName) {
            abort(404); // Handle case where the alias does not exist
        }

        // Fetch the region information
        $region = Region::where('name', $regionName)->firstOrFail();

        // Define dimensions for the six provinces
        $dimensions = [
            'camnorte' => [
                'width' => '420px',
                'height' => 'auto',
                'top' => '360px',
                'right' => 'auto',
                'bottom' => 'auto',
                'left' => '40px',
            ],
            'camsur' => [
                'width' => '600px',
                'height' => 'auto',
                'top' => '350px',
                'right' => '10px',
                'bottom' => 'auto',
                'left' => '40px',
            ],
            'albay' => [
                'width' => '600px',
                'height' => 'auto',
                'top' => '100px',
                'right' => '10px',
                'bottom' => '10px',
                'left' => '120px',
            ],
            'sorsogon' => [
                'width' => '420px',
                'height' => 'auto',
                'top' => '300px',
                'right' => 'auto',
                'bottom' => '10px',
                'left' => '50px',
            ],
            'catanduanes' => [
                'width' => '460px',
                'height' => 'auto',
                'top' => '40px',
                'right' => '5%',
                'bottom' => 'auto',
                'left' => '25px',
            ],
            'masbate' => [
                'width' => '420px',
                'height' => 'auto',
                'top' => '100px',
                'right' => '50%',
                'bottom' => '50%',
                'left' => '250px',
            ],
        ];

        // Get dimensions for the region or use defaults
        $width = $dimensions[$name]['width'] ?? '800px';  // Default width if not found
        $height = $dimensions[$name]['height'] ?? '600px'; // Default height if not found

        // Get position values
        $top = $dimensions[$name]['top'] ?? 'auto';
        $right = $dimensions[$name]['right'] ?? 'auto';
        $bottom = $dimensions[$name]['bottom'] ?? 'auto';
        $left = $dimensions[$name]['left'] ?? 'auto';
        // Fetch shops located in the selected province
        $shops = Shop::where('province', $regionName)->get();

        if ($shops->isEmpty()) {
            Log::info("No shops found for region: {$regionName}");
        }

        // Fetch merchants from those shops
        $merchantIds = $shops->pluck('merchant_id');

        // Fetch products from those merchants
        $products = Product::whereIn('merchant_id', $merchantIds)->get();

        // Get the product list from the region (assuming it’s comma-separated)
        $productList = explode(',', $region->products_list);

        // Fetch categories based on the product list
        $categories = Category::whereIn('category_id', $productList)->get();

        if ($categories->isEmpty()) {
            Log::info("No categories found for region: {$regionName}");
        }

        // Pass data to the view
        return view('map.partials.region-details', [
            'regionName' => $regionName,
            'width' => $width,
            'region' => $region,
            'height' => $height,
            'shops' => $shops,
            'products' => $products,
            'categories' => $categories,
            'top' => $top,
            'right' => $right,
            'bottom' =>$bottom ,
            'left' => $left

        ]);
    }

}
