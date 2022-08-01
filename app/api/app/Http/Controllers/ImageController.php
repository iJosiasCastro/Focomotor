<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'file' => 'required|max:1024|mimes:jpg,jpeg,png'
        ]);
        $url = 'storage/' . Storage::put('images', $request->file('file'));
        return $url;
    }
}
