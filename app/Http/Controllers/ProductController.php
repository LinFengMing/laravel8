<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use App\Http\Services\ShortUrlService;
use App\Http\Services\AuthService;

class ProductController extends Controller
{
    private $shortUrlService;

    private $authService;

    public function __construct(ShortUrlService $shortUrlService, AuthService $authService)
    {
        $this->shortUrlService = $shortUrlService;
        $this->authService = $authService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = DB::table('products')->get();
        $data = json_decode(Redis::get('products'));

        return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkProduct(Request $request)
    {
        $id = $request->all()['id'];
        $product = Product::find($id);

        if($product->quantity > 0) {
            return response(true);
        }

        return response(false);
    }

    public function sharedUrl($id)
    {
        $this->authService->fakeReturn();
        // $service = new ShortUrlService();
        $url = $this->shortUrlService->makeShortUrl("http://127.0.0.1:8000/products/$id");

        return response(['url' => $url]);
    }
}
