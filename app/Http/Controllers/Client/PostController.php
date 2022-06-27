<?php

namespace App\Http\Controllers\Client;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($slug){
        $categories = Category::where([['type', 'post'], ['parent_id', '!=', 999999]])->get()->toArray();
        $category = Category::where('slug', $slug)->first();
        $posts_most_viewed = Post::orderBy('views', 'desc')->limit(10)->get();
        $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        if($category !== null){
            $categories_sub_id = get_all_id_sub_categories($category);
            $categories_sub_id[] = $category->id;
            $paginate = get_param_pagging_offset_limit(10, Post::whereIn('cat_id', $categories_sub_id)->count(), $page);
            $paginate['slug'] = $slug;
            $posts = Post::whereIn('cat_id', $categories_sub_id)->offset($paginate['start'])->limit($paginate['end'])->get();

        }else{
            $paginate = get_param_pagging_offset_limit(10, Post::all()->count(), $page);
            $paginate['slug'] = $slug;
            $posts = Post::all();
        }
        return view('client.post.index', compact('categories', 'posts', 'paginate', 'posts_most_viewed'));
    }

    public function detail($slug){
        $post = Post::where('slug', $slug)->first();
        Post::where('slug', $slug)->update(['views' => $post->views + 1]);
        $posts_related = Post::where([['cat_id', $post->cat_id], ['id', "!=", $post->id]])->limit(10)->get();
        return view('client.post.detail', compact('post', 'posts_related'));
    }
}
