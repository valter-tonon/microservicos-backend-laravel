<?php

namespace App\Http\Controllers\Api;

use App\Models\CastMember;
use App\Http\Controllers\Controller;
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
    protected $date = ['deleted_at'];

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
