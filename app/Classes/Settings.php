<?php

namespace App\Classes;


use App\Helpers\Helper;
use App\Models\Settings as ModelSettings;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\File;

class Settings
{

    static function validateSettings($first_segment = null, $second_segment = null, $validate = [])
    {
        // İlk dizi grup adı. for_all alanı bütün hepsi için gerekli olan tanımlamalardır
        // İkinci dizi sekme adı
        // Üçüncü dizi değerler
        $defaultValidate = [
            'general'  => [
                'general_settings' => [
                    'post_per_page' => 'numeric|nullable'
                ],
                'image_settings'   => [
                    'site_logo'    => 'nullable|image|mimes:jpg,jpeg,png,gif',
                    'site_favicon' => 'nullable|image|mimes:jpg,jpeg,png,ico'
                ],
                'contact_settings' => [
                    'email' => 'nullable|email',
                    'phone' => 'nullable|digits:11'
                ],
            ],
            'email'    => [
                'email'   => [
                    'security_type'  => 'required',
                    'email_host'     => 'required',
                    'email_port'     => 'required|numeric',
                    'email'          => 'required|email',
                    'email_password' => 'required',
                    'username'       => 'nullable'
                ],
                'setting' => [
                    'email' => 'nullable|email',
                ]
            ],
            'cache'    => [
                'cache' => [
                    'cache_refresh_time' => 'numeric|nullable'
                ]
            ],
            'for_all'  => [],
            'validate' => true
        ];
        $validate = array_merge($defaultValidate, $validate);

        if (isset($validate[$first_segment]) && isset($validate[$first_segment][$second_segment])) {
            $newValidate = $validate[$first_segment][$second_segment];
            if (isset($validate['for_all']) && !empty($validate['for_all'])) {
                foreach ($validate['for_all'] as $key => $value)
                    $newValidate[$key] = $value;
            }
            return $newValidate;
        }
        return $validate;
    }

    static function createOrUpdate($request, $page)
    {
        $type = $request->input('setting_type');
        if ($type === 'site_map') {
            if (Sitemap::refresh())
                return self::response(true, ['Başarıyla Güncellendi!']);
            return self::response(false, ['Başarıyla Güncellendi', 'Güncelleme Başarısız!']);
        }
        $validator = self::validateSettings($page, $type);
        if (!isset($validator['validate'])) {
            $validator = \Validator::make($request->all(), $validator);
            if ($validator->errors()->isNotEmpty())
                return self::response(false);
        }
        $record = ModelSettings::where('setting_type', $page)->first();
        self::intervention($request, $page, $type, $record);
        $data = $request->except('_token', 'setting_type', 'site_logo', 'site_favicon');
        if (empty($record)) {
            // Yeni kayıt
            $create = ModelSettings::create([
                'setting_type' => $page,
                'setting_data' => json_encode([$type => $data])
            ]);
            return self::response($create);
        } else {
            // Kayıt var güncelle
            $setting_data = $data;
            $dataAttributes = array_map(function ($value, $key) {
                return "'$key','$value'";
            }, array_values($setting_data), array_keys($setting_data));
            $setting = ModelSettings::where('setting_type', $page)->select('setting_id')->first();
            if (!empty($setting)) {
                $update = ModelSettings::find($setting->setting_id)->update(['setting_data' => \DB::raw("JSON_SET(setting_data,'$." . $type . "',JSON_OBJECT(" . implode(',', $dataAttributes) . "))")]);
                return self::response($update);
            }
            return self::response(false);
        }
    }

    public static function createOrUpdateImage($request, $types, $record = null)
    {
        $results = [];
        foreach ($types as $key => $value) {
            if ($request->hasFile($key)) {
                if (!empty($record)) {
                    $decodedRecord = json_decode($record->setting_data);
                    if (!empty($decodedRecord->image_settings) && isset($decodedRecord->image_settings->$value)) {
                        $name = $decodedRecord->image_settings->$value;
                        File::delete(public_path('storage/settings/') . $name);
                    }
                }
                $imageName = self::uploadImage($request->file($key));
                $results[$value] = $imageName;
            }
        }
        if (!empty($record))
            $data = self::mergeImages($types, json_decode($record->setting_data));
        return $request->request->add(isset($data) ? array_merge($data, $results) : $results);
    }

    public static function getSetting($type, $param = null)
    {
        $setting = ModelSettings::where('setting_type', $type);
        if (!empty($param))
            $setting = $setting->selectRaw('JSON_EXTRACT(setting_data,"$.' . $param . '") AS ' . $param);
        return $setting;
    }

    private static function mergeImages($types, $record)
    {
        $results = [];
        if (isset($record->image_settings)) {
            $record = $record->image_settings;
            foreach ($types as $key => $value)
                if (isset($record->$value))
                    $results[$value] = $record->$value;
        }
        return $results;
    }

    private static function uploadImage($image)
    {
        $noExtensionName = Helper::uniqImg();
        $imageName = Helper::uniqImg(['extension' => $image->getClientOriginalExtension()], $noExtensionName);
        $img = ImageManagerStatic::make($image->getRealPath());
        if (!File::exists(public_path('storage/settings')))
            File::makeDirectory(public_path('storage/settings'));
        $img->save(public_path('storage/settings/') . $imageName);
        return $imageName;
    }


    private static function intervention($request, $page, $type, $record = null)
    {
        if ($page === 'email') {
            if ($type === 'email') {
                if ($request->input('email_password') === '#password' && !empty($record)) {
                    $record = json_decode($record->setting_data);
                    $request->merge(['email_password' => $record->email->email_password]);
                } else {
                    $request->merge(['email_password' => $request->input('email_password')]);
                }
            }

        } elseif ($page === 'general') {
            if ($type === 'image_settings') {
                $record = !empty($record) ? $record : null;
                $types = ['site_logo' => 'logo', 'site_favicon' => 'favicon'];
                self::createOrUpdateImage($request, $types, $record);
                return $request->except('_token', 'setting_type', 'site_logo', 'site_favicon');
            } elseif ($type === 'general_settings') {
                if (empty($request->input('post_per_page')))
                    $request->merge(['post_per_page' => 20]);
                if (!empty($request->input('panel_connect'))){
                    $request->merge(['panel_connect' => Str::slug($request->input('panel_connect'))]);
                    \Cache::flush();
                }
            }
        }
    }

    public static function response($action, $messages = [])
    {
        $defaults = [
            'Başarıyla Kaydedildi!',
            'Bir Sorun Oluştu ! Lütfen bilgileri kontrol edin'
        ];
        $messages = array_merge($messages, $defaults);
        if ($action)
            return redirect()->back()->with('success', $messages[0]);
        return redirect()->back()->with('error', $messages[1]);
    }

}