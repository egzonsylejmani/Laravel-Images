<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use App\Models\TemporaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StorePostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $title = $request->filled('title') ? $request->input('title') : 'Default Title';
        $description = $request->filled('description') ? $request->input('description') : 'Default Description';

        $validator = Validator::make([
            'title' => $title,
            'description' => $description,
        ], [
            'title' => 'required',
            'description' => 'required',
        ]);

        $temporaryImages = TemporaryImage::all();

        if ($validator->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }

            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        $post = Post::create($validator->validated());
        foreach($temporaryImages as $temporaryImage) {
            Storage::copy('images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file, 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file);
            Image::create([
                'post_id' => $post->id,
                'name' => $temporaryImage->file,
                'path' => $temporaryImage->folder . '/' . $temporaryImage->file
            ]);
            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }
        return redirect('/');
    }
}
