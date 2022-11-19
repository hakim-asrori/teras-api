<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductDetail;
use App\Http\Searches\ProductSearch;
use App\Http\Services\Product\ProductService;
use App\Http\Traits\MessageFixer;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use MessageFixer;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $factory = app()->make(ProductSearch::class);
        $products = $factory->apply()->inRandomOrder()->paginate($request->per_page);

        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Product\CreateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();

        try {
            DB::commit();
            $result = $this->productService->create($request->all());
            return $this->createSuccess('Product', $result);
        } catch (Exception $e) {
            DB::rollback();
            return $this->error($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->productService->findOrFail($id);

        return new ProductDetail($product);
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
     * @param  \App\Http\Requests\Product\UpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            DB::commit();
            $result = $this->productService->update($id, $request->all());
            return $this->updateSuccess('Product', $result);
        } catch (Exception $e) {
            DB::rollback();
            return $this->error($e);
        }
    }

    /**
     * Update the specified for status
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            DB::commit();
            $result = $this->productService->updateStatus($id, $request->all());
            return $this->statusSuccess('Product', $result);
        } catch (Exception $e) {
            DB::rollback();
            return $this->error($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            DB::commit();
            $result = $this->productService->delete($id);
            return $this->deleteSuccess('Product', $result);
        } catch (Exception $e) {
            DB::rollback();
            return $this->error($e);
        }
    }
}
