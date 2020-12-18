<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function fileStorageServe($path)
    {
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(storage_path('app'.DIRECTORY_SEPARATOR.($path)));
    }
}
