<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Newsletter;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomePageController extends Controller
{

    public function index(Request $request) {
        $newsletter = Settings::where('setting', 'newsletter_popup')->first();
        $bannerSettings = Settings::where('setting', 'home-banner')->first();
        $smallbannerSettings = Settings::where('setting', 'small-home-banner')->first();
        if ($request->isMethod('GET')){
            $blogs = Blog::where('state', 1)->take(10)->get();
            return view('index', compact('newsletter', 'blogs', 'bannerSettings', 'smallbannerSettings'));
        }else {
            // BULTEN ABONE
            try {
                $newsletter = Newsletter::where('email', strtolower(strip_tags(trim($request->newsletter_email))))->first();
                if (!$newsletter){
                    $create = Newsletter::create([
                        'email' => strtolower(strip_tags(trim($request->newsletter_email)))
                    ]);
                    if ($create) { return redirect()->route('index')->with([ 'message' => 'Başarıyla bültene abone oldunuz!', 'messageType' => 'success' ]); }
                }else { return redirect()->route('index')->with(['message' => 'Zaten abonesiniz!', 'messageType' => 'danger']); }
            } catch (\Throwable $th) {
                return redirect()->route('index')->with(['message' => 'Sistem hatası!', 'messageType' => 'danger']);
            }
        }
    }

}
