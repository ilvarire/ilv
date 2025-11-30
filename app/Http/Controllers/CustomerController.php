<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Ad;
use App\Models\Contact;
use App\Models\General;
use App\Models\Hero;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function home()
    {
        $heroData = Hero::all();
        $bannerData = Ad::all();
        return view('pages.index', [
            'heroData' => $heroData,
            'bannerData' => $bannerData
        ]);
    }
    public function products()
    {
        return view('pages.product-page');
    }

    public function productDetails($slug)
    {

        $product = Product::with('images', 'tags')->where('slug', $slug)->first();

        if (!$product) {
            abort(404, 'Page not found');
        }
        return view('pages.product-details', ['product' => $product]);
    }
    public function cart()
    {
        return view('pages.cart-page');
    }
    public function wishlist()
    {
        return view('pages.wishlist-page');
    }
    public function about()
    {
        $about = About::take(1)->first();
        return view('pages.about-page', ['about' => $about]);
    }
    public function policy()
    {
        $policy = General::select('policy')->take(1)->first();
        return view('pages.policy-page', ['policy' => $policy]);
    }
    public function contact()
    {

        return view('pages.contact-page');
    }
}
