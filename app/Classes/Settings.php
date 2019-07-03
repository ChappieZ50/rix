<?php

namespace App\Classes;


use App\Helpers\Helper;
use App\Models\Settings as ModelSettings;

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
                    'site_favicon' => 'nullable|image|mimes:jpg,jpeg,png,gif,ico'
                ],
                'contact_settings' => [
                    'email' => 'nullable|email',
                    'phone' => 'nullable|digits:11'
                ],
            ],
            'email'    => [
                'email'   => [
                    'security_type'  => 'required',
                    'email_title'    => 'required',
                    'email_host'     => 'required',
                    'email_port'     => 'required|numeric',
                    'email'          => 'required|email',
                    'email_password' => 'required'
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
        $validator = self::validateSettings($page, $type);
        if (!isset($validator['validate'])) {
            $validator = \Validator::make($request->all(), $validator);
            if ($validator->errors()->isNotEmpty())
                return Helper::response(false, '', [ 'errors' => $validator->errors() ]);
        }
        $record = ModelSettings::where('setting_type', $page)->first();
        if (empty($record)) {
            // Yeni kayıt
            $create = ModelSettings::create([
                'setting_type' => $page,
                'setting_data' => json_encode([ $type => $request->except('_token', 'setting_type') ])
            ]);
            //return self::response($create);
        } else {
            // Kayıt var güncelle
            $setting_data = $request->except('_token', 'setting_type');
            $dataAttributes = array_map(function ($value, $key) {
                return "'$key','$value'";
            }, array_values($setting_data), array_keys($setting_data));
            $update = ModelSettings::where('setting_type', $page)->update([ 'setting_data' => \DB::raw("JSON_SET(setting_data,'$." . $type . "',JSON_OBJECT(" . implode(',', $dataAttributes) . "))") ]);
            //return self::response($update);
        }
        return ModelSettings::where('setting_type', $page)->first()->toArray();
    }

    private static function response($action)
    {
        if ($action)
            return Helper::response(true, 'Kaydedildi');
        return Helper::response(false, 'Kaydedilemedi');
    }

}