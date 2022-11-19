<?php

namespace App\Http\Services\Product;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Product\ProductRepository;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductServiceImplement extends Service implements ProductService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(ProductRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($attributes)
    {
        if ($attributes['created_by'] == null) {
            $attributes['created_by'] = auth()->user()->id;
        }

        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                $attributes['image'] = $attributes['image']->store('products');
            }
        }

        $attributes['slug'] = Str::slug($attributes['title']);

        $product = $this->mainRepository->create($attributes);

        return $product;
    }

    public function update($id, $attributes)
    {
        $product = $this->mainRepository->findOrFail($id);

        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                if ($product->image != null) {
                    Storage::delete($product->image);
                }
                $attributes['image'] = $attributes['image']->store('products');
            }
        }

        $attributes['slug'] = Str::slug($attributes['title']);

        $product = $product->update($attributes);

        return $product;
    }

    public function updateStatus($id, $attributes)
    {
        $attributes['status'] = $attributes['status'] ? Product::ACTIVE : Product::DEACTIVE;

        $product = $this->mainRepository->update($id, $attributes);

        return $product;
    }

    public function delete($id)
    {
        $product = $this->mainRepository->findOrFail($id);

        if ($product->image != null) {
            Storage::delete($product->image);
        }

        $product->delete();

        return $product;
    }
}
