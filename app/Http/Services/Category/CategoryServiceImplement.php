<?php

namespace App\Http\Services\Category;

use LaravelEasyRepository\Service;
use App\Http\Repositories\Category\CategoryRepository;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryServiceImplement extends Service implements CategoryService
{

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected $mainRepository;

    public function __construct(CategoryRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function create($attributes)
    {
        $category = $this->mainRepository->create($attributes);

        return $category;
    }

    public function update($id, $attributes)
    {
        $category = $this->mainRepository->update($id, $attributes);

        return $category;
    }

    public function delete($id)
    {
        $category = $this->mainRepository->delete($id);

        return $category;
    }
}
