<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use DemeterChain\C;
use Illuminate\Http\Request;

class CategoryController extends GenericCrudController
{
    private $rules = [
        'name' => 'required|max:255',
        'description' => 'nullable',
        'is_active' => 'boolean'
    ];

    protected function model()
    {
        return Category::class;
    }

    protected function rulesStore()
    {
        return $this->rules;
    }

    protected function rulesUpdate()
    {
        return $this->rules;
    }
}
