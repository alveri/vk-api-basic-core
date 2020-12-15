<?php


namespace App\Vk;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CallbackController extends Controller
{
    public function callback(Request $request)
    {
        return new Response('ok');
    }

    public static function callbackUrl()
    {
        $callbackUrl = Config::get('url') . URL::route('vkCallback');
        return $callbackUrl;
    }
}
