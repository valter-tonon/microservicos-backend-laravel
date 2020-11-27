<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\GenericCrudController;
use App\Models\CastMembers;
use Illuminate\Http\Request;

class CastMembersController extends GenericCrudController
{
    private $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => 'required|max:255',
            'type' => 'required|in:'. implode(',', [CastMembers::TYPE_ACTOR, CastMembers::TYPE_DIRECTOR])
        ];
    }

    protected function model()
    {
        return CastMembers::class;
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
