<?php

namespace App\Http\Controllers\Adminstrator;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Symfony\Component\VarDumper\Cloner\Data;

class PostController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
        if (Category::where([['title', '=', 'Uncategorized'], ['parent_id', '=', 999999], ['type', '=', 'post']])->first() === null) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Category::create([
                'title' => 'Uncategorized',
                'slug' => 'uncategorized',
                'description' => 'Danh mục bài viết mặc định',
                'parent_id' => 999999,
                'type' => 'post'
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
        Post::where('user_id', null)->delete();
    }

    public function cat_list()
    {
        $list_category = data_tree(Category::where([['type', 'post'], ['parent_id', '!=', 999999]])->get()->toArray());
        $uncategorized = Category::where([['type', 'post'], ['parent_id', 999999]])->first()->toArray();
        $uncategorized = data_tree([0 => $uncategorized], 999999);
        $categories = $list_category;
        $categories = array_merge($uncategorized, $categories);

        $page_on_click = !empty($_GET['page']) ? $_GET['page'] : 1;
        $paginate = get_param_pagging(10, count($categories), $page_on_click);
        $confirm = "Bạn chắc chắn xóa vĩnh viễn danh mục . Những danh mục con phụ thuộc sẽ không mất đi nhưng không thể hoàn tác";

        // dd($paginate);
        return view('admin.post.cat.list', compact('categories', 'list_category', 'confirm', 'paginate'));
    }

    public function cat_store(Request $request)
    {
        if ($request->input('btn_create')) {
            $request->validate(
                [
                    'title' => 'required|max:255|string',
                    'slug' => 'nullable|max:255|string|unique:categories',
                    'description' => 'nullable|max:255|string',
                    'parent_id' => "required|not_in:''",
                ],
                [
                    'required' => ":attribute không được để trống",
                    'parent_id.required' => 'Chọn :attribute',
                    'max' => ':attribute tối đa 255 ký tự',
                    'string' => ':attribute bắt buộc là một text',
                    'unique' => ':attribute'
                ],
                [
                    'title' => 'Tên danh mục',
                    'slug' => 'Đường dẫn thân thiện đã tồn tại . Bạn vui lòng chọn đường dẫn thân thiện khác cho danh mục',
                    'description' => 'Mô tả',
                    'parent_id' => 'danh mục cha'
                ]
            );
            $data = array(
                'title' => $request->input('title'),
                'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
                'description' => $request->input('description'),
                'parent_id' => $request->input('parent_id'),
                'type' => 'post'
            );
            if ($data['parent_id'] == 0) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                Category::create($data);
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } else {
                Category::create($data);
            }
            return redirect()->route('admin.post.cat.list')->with('success', 'Đã thêm danh mục');
        }
    }

    public function cat_destroy($id)
    {
        $category = Category::find($id);
        if ($category->parent_id == 999999 and $category->type == 'post') {
            return redirect()->route('admin.post.cat.list')->with('warning', 'Xóa danh mục sẽ không xóa bài viết trong danh mục đó. Thay vì thế, bài viết sẽ được chuyển đến danh mục mặc định Uncategorized. Danh mục mặc định không thể xóa.');
        }

        // Chuyển parent_id tất cả các danh mục con phụ thuộc = parent_id danh mục đang xóa
        $categories_child = $category->child_items;
        
        if (!$categories_child->isEmpty()) {
            foreach ($categories_child as $child) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                Category::find($child->id)->update([
                    'parent_id' => $category->parent_id,
                ]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            }
        }

        // Chuyển tất cả post thuộc vào danh mục sang danh mục không xác định
        $posts = $category->posts;
        
        if(!$posts->isEmpty()){
            $uncategorized = Category::where([['parent_id', 999999], ['type', 'post']])->first();
            foreach($posts as $post){
                Post::withTrashed()->find($post->id)->update(['cat_id' => $uncategorized->id]);
            }
        }
        Category::destroy($id);
        return redirect()->route('admin.post.cat.list')->with('success', 'Đã xóa danh mục');
    }

    public function cat_edit($id)
    {
        $list_category = data_tree(Category::where([['type', 'post'], ['parent_id', '!=', 999999]])->get()->toArray());
        $category = Category::find($id);
        if ($category->parent_id == 999999 and $category->type == 'post') {
            return redirect()->route('admin.post.cat.list')->with('warning', 'Không thể cập nhật danh mục mặc định');
        }
        return view('admin.post.cat.edit', compact('category', 'list_category'));
    }

    public function cat_update(Request $request, $id)
    {
        if (!empty($request->input('btn_edit'))) {
            $request->validate(
                [
                    'title' => 'required|max:255|string',
                    'slug' => 'nullable|max:255|string|unique:categories,slug,' . $id,
                    'description' => 'nullable|max:255|string',
                    'parent_id' => "required|not_in:''",
                ],
                [
                    'required' => ":attribute không được để trống",
                    'parent_id.required' => 'Chọn :attribute',
                    'max' => ':attribute tối đa 255 ký tự',
                    'string' => ':attribute bắt buộc là một text',
                    'unique' => ":attribute",
                ],
                [
                    'title' => 'Tên danh mục',
                    'slug' => 'Đường dẫn thân thiện do hệ thống tự động tạo đã bị trùng lặp , bạn vui lòng điền đường dẫn thân thiện khác cho danh mục',
                    'description' => 'Mô tả',
                    'parent_id' => 'danh mục cha'
                ]
            );



            $data = array(
                'title' => $request->input('title'),
                'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
                'description' => $request->input('description'),
                'parent_id' => $request->input('parent_id'),
            );

            if ($data['parent_id'] == 0) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                Category::find($id)->update($data);
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
            } else {
                Category::find($id)->update($data);
            }
            return redirect()->route('admin.post.cat.edit', $id)->with('success', "Đã cập nhật danh mục");
        }
    }

    public function list(Request $request)
    {
        $key = '';
        $count = [
            'on' => Post::where('status', 'on')->count(),
            'off' => Post::where('status', 'off')->count(),
            'trash' => Post::onlyTrashed()->count(),
            'unknown_author' => Post::onlyTrashed()->where('user_id', NULL)->count(),
        ];

        if ($request->input('key') !== null) {
            $key = $request->input('key');
            $posts = Post::where('title', 'LIKE', "%{$key}%")->orderBy('created_at', 'desc')->paginate(10);
            $posts->list_action = ['on', 'off', 'destroy'];
        } else if ($request->input('status') === 'trash') {
            $posts = Post::onlyTrashed()->paginate(10);

            $posts->list_action = ['restore', 'forceDelete'];
            $posts->confirm = "Bạn chắc chắn xóa vĩnh viễn bài viết . Không thể hoàn tác";
        } else {
            if ($request->input('status') === 'on') {
                $posts = Post::where('status', $request->input('status'))->orderBy('created_at', 'desc')->paginate(10);

                $posts->list_action = ['destroy', 'off'];
                $posts->confirm = "Bạn chắc chắn xóa bài viết . Có thể phục hồi";
            } elseif ($request->input('status') === 'off') {
                $posts = Post::where('status', $request->input('status'))->orderBy('created_at', 'desc')->paginate(10);

                $posts->list_action = ['destroy', 'on'];
                $posts->confirm = "Bạn chắc chắn xóa bài viết . Có thể phục hồi";
            } elseif ($request->input('status') === 'unknown_author') {
                $posts = Post::onlyTrashed()->where('user_id', null)->orderBy('created_at', 'desc')->paginate(10);

                $posts->list_action = ['restore', 'forceDelete'];
                $posts->confirm = "Bạn chắc chắn xóa vĩnh viễn bài viết . Không thể hoàn tác";
            } else {
                $posts = Post::where('status', 'on')->orderBy('created_at', 'desc')->paginate(10);

                $posts->list_action = ['destroy', 'off'];
                $posts->confirm = "Bạn chắc chắn xóa bài viết . Có thể phục hồi";
            }
        }

        $index = ($posts->perPage() * $posts->currentPage()) - $posts->perPage() + 1;
        return view('admin.post.list', compact('posts', 'count', 'key', 'index'));
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        $action = $request->input('action');
        if (!empty($action)) {
            if (!empty($list_check)) {
                if ($action === 'on') {
                    Post::whereIn('id', $list_check)->update(['status' => 'on']);
                }
                if ($action === 'off') {
                    Post::whereIn('id', $list_check)->update(['status' => 'off']);
                }
                if ($action === 'destroy') {
                    Post::destroy($list_check);
                }
                if ($action === 'restore') {
                    foreach ($list_check as $id) {
                        if (Post::onlyTrashed()->where([['id', $id], ['user_id', null]]) === null) {
                            Post::onlyTrashed()->where('id', $id)->update(['user_id' => Auth::id()]);
                        }
                    }
                    Post::onlyTrashed()->whereIn('id', $list_check)->restore();
                }
                if ($action === 'forceDelete') {
                    Post::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                }
                return redirect()->back()->with('success', 'Đã áp dụng thành công thao tác cho bài viết');
            }
            return redirect()->back()->with('warning', 'Vui lòng chọn bài viết');
        }
        return redirect()->back()->with('warning', 'Vui lòng chọn thao tác áp dụng');
    }

    public function create()
    {
        $categories = data_tree(Category::where([['type', 'post'], ['parent_id', '!=', 999999]])->get()->toArray());
        return view('admin.post.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'slug' => 'nullable|max:255|string|unique:posts',
                'desc' => 'nullable|max:255|string',
                'content' => 'required|string',
                'status' => 'required',
                'cat_id' => "required|not_in:''",
                'file' => 'required|image',
            ],
            [
                'required' => ":attribute không được để trống",
                'parent_id.required' => 'Chọn :attribute',
                'unique' => ":attribute",
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute bắt buộc là một text',
                'image' => ':attribute có định dạng (png, jpg, jpeg, gif, ...)'
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'slug' => 'Đường dẫn thân thiện đã tồn tại . Bạn vui lòng chọn đường dẫn thân thiện khác cho bài viết',
                'desc' => 'Mô tả ngắn',
                'content' => 'Nội dung bài viết',
                'status' => 'Trạng thái bài viết',
                'cat_id' => 'Danh mục bài viết thuộc vào',
                'thumb' => 'Ảnh đại diện bài viết',
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $upload_dir = 'public/images/post/';
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file_format = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $file->getClientOriginalName();
            if (file_exists(public_path() . "/images/post/" . $file->getClientOriginalName())) {
                $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($upload_file)) {
                    $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
            }
            $file->move($upload_dir, $upload_file);
        }
        $data = array(
            'title' => $request->input('title'),
            'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'thumb' => $upload_file,
            'status' => $request->input('status'),
            'user_id' => Auth::id(),
            'cat_id' => $request->input('cat_id'),
        );
        Post::create($data);
        return redirect()->route('admin.post.list')->with('success', 'Đã tạo bài viết');
    }

    public function destroy($id)
    {
        if (Post::find($id) == null) {
            Post::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect()->back()->with('success', 'Bài viết đã vào thùng rác');
        } else {
            Post::destroy($id);
            return redirect()->back()->with('success', 'Đã xóa vĩnh viễn bài viết');
        }
    }

    public function edit($id)
    {
        $categories = data_tree(Category::where([['type', 'post'], ['parent_id', '!=', 999999]])->get()->toArray());
        $post = Post::withTrashed()->find($id);

        return view('admin.post.edit', compact('categories', 'post'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'title' => 'required|max:255|string',
                'slug' => 'nullable|max:255|string|unique:posts,slug,' . $id,
                'desc' => 'nullable|max:255|string',
                'content' => 'required|string',
                'status' => 'required',
                'cat_id' => "required|not_in:''",
                'file' => 'nullable|image',
            ],
            [
                'required' => ":attribute không được để trống",
                'parent_id.required' => 'Chọn :attribute',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute bắt buộc là một text',
                'image' => ':attribute có định dạng (png, jpg, jpeg, gif, ...)',
                'unique' => ":attribute"
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'slug' => 'Đường dẫn thân thiện do hệ thống tự động tạo đã bị trùng lặp , bạn vui lòng điền đường dẫn thân thiện khác cho bài viết',
                'desc' => 'Mô tả ngắn',
                'content' => 'Nội dung bài viết',
                'status' => 'Trạng thái bài viết',
                'cat_id' => 'Danh mục bài viết thuộc vào',
                'thumb' => 'Ảnh đại diện bài viết',
            ]
        );

        $data = array(
            'title' => $request->input('title'),
            'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
            'desc' => $request->input('desc'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
            'cat_id' => $request->input('cat_id'),
        );

        if ($request->hasFile('file')) {
            if (file_exists(base_path(Post::find($id)->pluck('thumb')->toArray()[0]))) {
                unlink(base_path(Post::find($id)->pluck('thumb')->toArray()[0]));
            }
            $file = $request->file;
            $upload_dir = 'public/images/post/';
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file_format = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $file->getClientOriginalName();
            if (file_exists(public_path() . "/images/post/" . $file->getClientOriginalName())) {
                $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($upload_file)) {
                    $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
            }
            $file->move($upload_dir, $upload_file);
            $data['thumb'] = $upload_file;
        }

        Post::withTrashed()->find($id)->update($data);
        return redirect()->route('admin.post.edit', $id)->with('success', 'Đã cập nhật bài viết');
    }
}
