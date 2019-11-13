<?php

namespace App\Http\Controllers;

use App\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    //
    public function storeImage(Request $request)
    {
        $content_types = [
            'image/jpeg' => 'jpeg',
            'image/png' => 'png'
        ];

        $path_to_file = str_replace('tmp/', '',
            $request->input('key') . '.' . $content_types[$request->content_type]);

        Log::info($request);
        Storage::copy(
            $request->input('key'),
            'images/' . $path_to_file
        );

        $url = env('AWS_URL') . '/images/' . $path_to_file;
        dump($url);

        $mess = new Messages();
        $mess->user = 1;
        $mess->body = "Hi There!";
        $mess->type = "image";
        $mess->save();
        $mess->addMediaFromUrl($url)
            ->toMediaCollection('message-images');
        $mess->save();
        Log::info($mess);

        $path = Storage::disk('s3')->put('messages/'. $path_to_file, 'public');
        dump($path);

        return  $mess->id;
    }
}
