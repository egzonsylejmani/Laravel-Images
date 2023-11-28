<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->get();

        return view('images', compact('posts'));
    }

    public function downloadImages($postId)
    {
        $post = Post::findOrFail($postId);

        // Create a zip file
        $zipFileName = $post->title  .  '_images'. '.zip';
        $zip = new \ZipArchive();
        $zip->open(public_path($zipFileName), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($post->images as $image) {
            $filePath = public_path('storage/images/' . $image->path);
            $zip->addFile($filePath, $image->name);
        }

        $zip->close();

        // Download the zip file
        return response()->download(public_path($zipFileName))->deleteFileAfterSend();
    }
}
