<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Cart;
use Illuminate\Support\Str;
class ShopController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query("page") ?: -1;
        $size = $request->query("size") ?: 12;

        $order = $request->query("order") ?: -1;
        $o_column = "";
        $o_order = "";

        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "regular_price";
                $o_order = "ASC";
                break;
            case 4:
                $o_column = "regular_price";
                $o_order = "DESC";
                break;
            default:
                $o_column = "id";
                $o_order = "DESC";
        }

        $brands = Brand::orderBy("name", "ASC")->get();
        $q_brands = $request->query("brands");
        $categories = Category::orderBy("name", "ASC")->get();
        $q_categories = $request->query("categories");
        $q_brands_array = $q_brands ? explode(',', $q_brands) : [];
        $prange = $request->query("prange");
        if(!$prange)
        $prange = "0,500";
        $q_categories_array = $q_categories ? explode(',', $q_categories) : [];
        $from = explode(",",$prange)[0];
        $to = explode(",",$prange)[1];

        $products = Product::when($q_brands, function ($query) use ($q_brands_array) {
                $query->whereIn('brand_id', $q_brands_array);
            })
            ->when($q_categories, function ($query) use ($q_categories_array) {
                $query->whereIn('category_id', $q_categories_array);
            })
            ->whereBetween('regular_price',array($from,$to))
            ->orderBy('created_at', 'DESC')
            ->orderBy($o_column, $o_order)
            ->paginate($size);

        return view('shop', [
            'products' => $products,
            'page' => $page,
            'size' => $size,
            'order' => $order,
            'brands' => $brands,
            'q_brands' => $q_brands,
            'categories' => $categories,
            'q_categories' => $q_categories,
            'from'=>$from,
            'to'=>$to
        ]);
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $rproducts = Product::where('slug', '!=', $slug)->inRandomOrder()->limit(8)->get();
        return view('details', ['product' => $product, 'rproducts' => $rproducts]);
    }

    public function getCartWishlistCount()
    {
        $cartCount = Cart::instance("cart")->content()->count();
        $wishlistCount = Cart::instance("wishlist")->content()->count();
        return response()->json(['status' => 200, 'cartCount' => $cartCount, 'wishlistCount' => $wishlistCount]);
    }

    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->slug = Str::slug($request->input('name')); 
        $product->regular_price = $request->input('price');
        $product->brand_id = $request->input('brand_id');
        $product->category_id = $request->input('category_id');

        $product->save();
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->slug = Str::slug($request->input('name')); 
        $product->regular_price = $request->input('price');
        $product->brand_id = $request->input('brand_id');
        $product->category_id = $request->input('category_id');

        $product->save();
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
