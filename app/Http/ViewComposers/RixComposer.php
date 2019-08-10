<?php

namespace App\Http\ViewComposers;

use App\Classes\Settings;
use Illuminate\Contracts\View\View;

class RixComposer
{
    public function compose(View $view)
    {
        $setting = Settings::getSetting('general','general_settings')->first();
        $setting =  isset($setting->general_settings) ? json_decode($setting->general_settings) : $setting;
        return $view->with([
           'composePanelName' => isset($setting->panel_name) ? $setting->panel_name : null
        ]);

    }
}