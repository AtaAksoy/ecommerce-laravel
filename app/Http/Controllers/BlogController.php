<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BlogController extends Controller
{
    public function updateHits($slug) {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }
        $blog = Blog::where('slug', $slug)->first();
        if ($blog) {
            $hits = $blog->hits;
            if ($hits != null){
                // THERE ARE VISITOR
                $hits = json_decode($hits, true);
                $updatebool = true;
                for ($i=0; $i < count($hits); $i++) {
                    if ($hits[$i] == $ip){ $updatebool = false; }
                }
                if ($updatebool){
                    array_push($hits, $ip);
                    $update = Blog::where('slug', $slug)->update(['hits' => json_encode($hits)]);
                }
            }else {
                $hits = json_encode([$ip]);
                $update = Blog::where('slug', $slug)->update(['hits' => $hits]);
            }
        }
    }

    public function blogList() {
        $blogs = Blog::where('state', 1)->orderBy('id', 'desc')->paginate(5);
        $popularPosts = Blog::where('state', 1)->orderByRaw('CHAR_LENGTH(hits) DESC')->take(4)->get();
        return view('blog.blog-list', compact('blogs', 'popularPosts'));
    }

    public function showBlog($slug) {
        $blog = Blog::where('slug', $slug)->where('state', 1)->first();
        if ($blog) {
            $this->updateHits($slug);
            return view('blog.blog-details', compact('blog'));
        }else {
            return redirect()->route('index');
        }
    }

    public function leaveComment($slug, Request $request) {
        $blog = Blog::where('slug', $slug)->first();
        if ($blog) {
            $comments = json_decode($blog->comments, true);
            if ($comments == null) {
                // FIRST COMMENT
                $comments = array();
                $comment = [
                    'id' => 0,
                    'name' => $request->name,
                    'email' => $request->email,
                    'comment' => $request->comment,
                    'date' => date('d.m.Y')
                ];
            }
            else {
                $id = $comments[count($comments) - 1]['id'];
                $comment = [
                    'id' => $id +1,
                    'name' => $request->name,
                    'email' => $request->email,
                    'comment' => $request->comment,
                    'date' => date('d.m.Y')
                ];
            }
            array_push($comments, $comment);
            $update = Blog::where('slug', $slug)->update(['comments' => json_encode($comments)]);
            if ($update) {
                return redirect()->route('blog.showblog', $slug)->with(['message' => 'Yorum Eklendi!', 'messageType' => 'success']);
            }else {
                return redirect()->route('blog.showblog', $slug)->with(['message' => 'Yorum Eklenemedi!', 'messageType' => 'danger']);
            }
        }
    }
}
