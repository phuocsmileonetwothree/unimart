<?php
use App\Category;
use App\Product;
use App\Post;
use App\Page;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

$action = Route::getCurrentRoute()->getActionMethod();
$module = class_basename(Route::current()->controller);
$module = strtolower(str_replace("Controller", '', $module));
$list_root = [];
$slug = Request::route()->parameter('slug');
if($slug == 'all'){
    $list_root = [
        0 => [
        'slug' => 'all',
        'title' => 'Tất cả ' . convert_breadcrumb($module)
        ]
    ];
}else{
    if ($action == 'index') {
        $category = Category::where('slug', $slug)->first();
        $list_root [] = [
            'slug' => route("client.{$module}.category.index", ['slug' => $category->slug]),
            'title' => $category->title,
        ];
        while($category->parent_id != 0) {
            $list_root[] = [
                'slug' => route("client.{$module}.category.index", ['slug' => $category->parent->slug]),
                'title' => $category->parent->title,
            ];
            $category = $category->parent;
        }
    }

    if($action == 'detail'){

        if($module == 'product'){
            $category = Product::where('slug', $slug)->first()->category;
            $list_root [] = [
                'slug' => route("client.product.category.index", ['slug' => $category->slug]),
                'title' => $category->title,
            ];
            while($category->parent_id != 0) {
                $list_root[] = [
                    'slug' => route("client.product.category.index", ['slug' => $category->parent->slug]),
                    'title' => $category->parent->title,
                ];
                $category = $category->parent;
            }
        }

        if($module == 'post'){
            $category = Post::where('slug', $slug)->first()->category;
            $list_root [] = [
                'slug' => route("client.post.category.index", ['slug' => $category->slug]),
                'title' => $category->title,
            ];
            while($category->parent_id != 0) {
                $list_root[] = [
                    'slug' => route("client.post.category.index", ['slug' => $category->parent->slug]),
                    'title' => $category->parent->title,
                ];
                $category = $category->parent;
            }
        }

        if($module == 'page'){
            $category = Page::where('slug', $slug)->first();
            $list_root [] = [
                'slug' => route("client.page.detail", ['slug' => $category->slug]),
                'title' => $category->title,
            ];
            while($category->parent_id != 0) {
                $list_root[] = [
                    'slug' => route("client.page.detail", ['slug' => $category->parent->slug]),
                    'title' => $category->parent->title,
                ];
                $category = $category->parent;
            }
        }
    }
}


$list_root = array_reverse($list_root);
?>
<div class="breadcrumb-main" style="padding: 10px!important">
    <div class="breadcrumb-contain" style="justify-content: flex-start">
        <div>
            <ul>
                <li><a href="{{ route('client.home') }}">Trang chủ</a></li>
                <li><i class="fa fa-angle-right"></i></li>
                <?php $index = 0; ?>
                @if (!empty($list_root))
                @foreach ($list_root as $item)
                <?php $index++; ?>
                <li><a href="{{ $item['slug'] }}">{{ $item['title'] }}</a></li>
                @if ($index != count($list_root))
                <li><i class="fa fa-angle-right"></i></li>
                @endif
                @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>