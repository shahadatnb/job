<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function ownedOrFail(string $model, int|string|null $id)
    {
        $record = $model::where('applicant_id', auth('applicant')->id())->findOrFail($id);

        return $record;
    }
}
