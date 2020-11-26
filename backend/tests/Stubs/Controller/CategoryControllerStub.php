<?php

namespace Tests\Stubs\Controller;


use App\Http\Controllers\Api\GenericCrudController;
use Tests\Stubs\Model\CategoryStub;

class CategoryControllerStub extends GenericCrudController
{
  protected function model()
  {
      return CategoryStub::class;
  }
  protected function rulesStore()
  {
      return[
          'name' => 'required|max:255',
          'description' => 'nullable'
  ];
  }
}

