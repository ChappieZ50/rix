<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Rix;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{

    public function get_gallery(Request $request)
    {
        $images = Gallery::get_gallery(['id','image_name','image_data','created_at'],config('definitions.MODAL_GALLERY_PAGINATE'));
        if ($request->ajax())
            return Helper::renderImages($images);
        return view('rix.media.gallery', compact('images'));
    }

    public function new_media(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:3072',
            ]);
            $file = $request->file('image');
            $noExtensionName = Helper::uniqImg();
            $imageName = Helper::uniqImg(['extension' => $file->getClientOriginalExtension()],$noExtensionName);


            $imageData = json_encode([
                'width'                 => getimagesize($file)[0],
                'height'                => getimagesize($file)[1],
                'mime-type'             => $file->getClientMimeType(),
                'size'                  => $file->getSize(),
                'extension'             => $file->getClientOriginalExtension(),
                'url'                   => Helper::srcImage($imageName),
                'formatedDate'          => Helper::changeDateFormat(),
                'noExtensionName'       => $noExtensionName,
                'imageSizeHumanReadable'=> Helper::fileSize($file->getSize()),
            ]);
            $upload = $file->move(public_path(config('definitions.PUBLIC_PATH')), $imageName);
            if ($upload) {
                $insert = Gallery::create([
                    'image_name'          => $imageName,
                    'image_data'          => $imageData
                ]);
                if (!$insert) {
                    File::delete(public_path(config('definitions.PUBLIC_PATH') . $imageName));
                    return ['status' => false, 'message' => 'Yükleme Başarısız'];
                }
                return null;
            } else {
                return ['status' => false, 'message' => 'Yükleme Başarısız'];
            }
        }
        return view('rix.media.new_media');
    }

    public function delete_image(Request $request)
    {
        $images = Gallery::select(['id', 'image_name'])->whereIn('id', $request->input('image_id'))->get()->toArray();
        if (Helper::deleteImage($images)) {
            if (Gallery::destroy($request->input('image_id')))
                return ['status' => true, 'message' => 'Resim Silindi'];
        }
        return ['status' => false, 'message' => 'Resim Silinemedi'];
    }
}
