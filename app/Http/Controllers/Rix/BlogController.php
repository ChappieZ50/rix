<?php

namespace App\Http\Controllers\Rix;

use App\Helpers\Helper;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use DOMDocument;

class BlogController extends Controller
{
    public function get_posts()
    {
        return view('rix.blog.posts');
    }

    public function new_post(Request $request)
    {
        $images = Gallery::get_gallery(['id','image_name'],config('definitions.NEW_POST_GALLERY_PAGINATE'));
        if($request->ajax())
            return Helper::renderImages($images);
        return view('rix.blog.new_post',compact('images'));
    }

    public function add_new_post(Request $request)
    {
        $summernoteImage = $this->summernoteImage($request);
        print_r($request->all());

    }

    public function summernoteImage($request)
    {
        $message = $request->input('message'); // Summernote Textarea
        $dom = new DomDocument('5.0', 'UTF-8'); // Version 5.0 Encoding UTF8
        $dom->loadHtml(mb_convert_encoding($message, 'HTML-ENTITIES', "UTF-8"), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); // Load Html | Fixed  Character Problem
        $images = $dom->getElementsByTagName('img'); // Getting img tag in summernote textarea
        if (!empty($images)) { // If  found image in summernote textarea, then continue
            foreach ($images as $img) {
                $src = $img->getAttribute('src'); // Getting image src attr
                // if the img source is 'data-url'
                if (preg_match('/data:image/', $src)) {
                    // get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimeType = $groups['mime']; // Getting image mime type
                    // Generating a random imageName
                    $imageName = Helper::uniqImg(['extension' => $mimeType]);
                    $imagePath = config('definitions.PUBLIC_PATH') . "/$imageName";
                    $image = Image::make($src)
                        ->encode($mimeType, 100)// encode file to the specified mimetype
                        ->save(public_path($imagePath));
                    $newSrc = asset($imagePath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $newSrc);
                    $imageData = [
                        'width'     => $image->width(),
                        'height'    => $image->height(),
                        'mime-type' => $image->mime(),
                        'size'      => $image->filesize(),
                        'extension' => $mimeType,
                    ];
                    $create = ['image_name' => $imageName, 'image_data' => $imageData];
                    Gallery::create($create);
                }
            }
            return true;
        }
        return null;
    }
}
