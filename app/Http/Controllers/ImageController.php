<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function uploadImage(Request $request, $user_id) {
        $validatedData = $request->validate([
            'image-file' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $user = User::where('id', '=', $user_id)->firstOrFail();

        $image = $request->file('image-file');
        $destinationPath = public_path('storage');
        $img = Image::make($image->path());

        $img->resize(null, 960, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
            ->save($destinationPath.'/'. $request->file('image-file')->hashName(), 90);

        $user->id_attachment = Storage::url($request->file('image-file')->hashName());
        $user->save();

        return \response()->json([
            'image' => Storage::url($request->file('image-file')->hashName()),
        ]);
    }

}
