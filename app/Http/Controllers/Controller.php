<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $site_settings;

    public function __construct() 
    {
        $settings = Setting::all();
        $this->site_settings = $settings->pluck('value', 'key')->all();
        View::share('site_settings', $this->site_settings);
    }

    public function getValueSetting($key){
        return $this->site_settings[$key] ?? "{}";
    }

}
