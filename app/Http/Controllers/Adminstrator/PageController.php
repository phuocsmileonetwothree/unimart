<?php

namespace App\Http\Controllers\Adminstrator;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PageController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
        Page::where('user_id', null)->delete();
    }

    public function list(Request $request)
    {
        $key = '';
        $count = [
            'on' => Page::all()->count(),
            'trash' => Page::onlyTrashed()->count(),
            'unknown_author' => Page::onlyTrashed()->where('user_id', '=', NULL)->count(),
        ];

        if ($request->input('key') !== null) {
            $key = $request->input('key');
            $pages = Page::where('title', 'LIKE', "%{$key}%")->orderBy('created_at', 'desc')->paginate(5);
            $pages->list_action = ['destroy'];
            $pages->confirm = "Bạn chắc chắn xóa trang . Có thể hoàn tác";
        } else {
            if ($request->input('status') === 'trash') {
                $pages = Page::onlyTrashed()->orderBy('created_at', 'desc')->paginate(5);
                $pages->confirm = "Bạn chắc chắn xóa vĩnh viễn trang . Không thể phục hồi";
                $pages->list_action = ['restore', 'forceDelete'];
            } elseif ($request->input('status') === 'unknown_author') {
                $pages = Page::onlyTrashed()->where('user_id', null)->orderBy('created_at', 'desc')->paginate(5);
                $pages->confirm = "Bạn chắc chắn xóa vĩnh viễn trang . Không thể phục hồi";
                $pages->list_action = ['restore', 'forceDelete'];
            } else {
                $pages = Page::orderBy('created_at', 'desc')->paginate(5);
                $pages->confirm = "Bạn chắc chắn xóa trang . Có thể hoàn tác";
                $pages->list_action = ['destroy'];
            }
        }
        $index = ($pages->perPage() * $pages->currentPage()) - $pages->perPage() + 1;
        return view('admin.page.list', compact('pages', 'index', 'key', 'count'));
    }

    public function action(Request $request)
    {

        $list_check = $request->input('list_check');
        $action = $request->input('action');
        if (!empty($action)) {
            if (!empty($list_check)) {
                if ($action == 'destroy') {
                    Page::destroy($list_check);
                }
                if ($action == 'restore') {
                    foreach ($list_check as $id) {
                        if (Page::onlyTrashed()->where([['id', '=', $id], ['user_id', '=', null]])->first() !== null) {
                            Page::onlyTrashed()->where('id', $id)->update(['user_id' => Auth::id()]);
                        }
                    }
                    Page::onlyTrashed()->whereIn('id', $list_check)->restore();
                }
                if ($action == 'forceDelete') {
                    Page::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                }
                return redirect()->back()->with('success', "Đã áp dụng thành công thao tác cho trang");
            }
            return redirect()->back()->with('warning', 'Vui lòng chọn trang');
        }
        return redirect()->back()->with('warning', 'Vui lòng chọn thao tác áp dụng');
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:270|unique:pages',
                'content' => 'required|string',
            ],
            [
                'required' => ":attribute không được để trống",
                'max' => ":attribute có độ dài tối đa 255 ký tự",
                'string' => ":attribute phải là một văn bản",
                'unique' => ":attribute"
            ],
            [
                'title' => 'Tiêu đề',
                'slug' => 'Đường dẫn thân thiện do hệ thống tự động tạo đã bị trùng lặp , bạn vui lòng điền đường dẫn thân thiện khác cho trang',
                'content' => 'Nội dung',
            ]
        );
        
        $page = Page::create([
            'title' => $request->input('title'),
            'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
        ]);
        // create trả về 1 model instance vừa add
        return redirect()->route('admin.page.list')->with('success', 'Thêm trang thành công');
    }

    public function destroy($id)
    {
        if (Page::onlyTrashed()->find($id) !== null) {
            Page::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect()->back()->with('success', 'Đã xóa vĩnh viễn trang');
        } else {
            Page::destroy($id);
            return redirect()->back()->with('success', 'Trang đã vào thùng rác');
        }
    }

    public function edit($id)
    {
        $page = Page::withTrashed()->find($id);
        return view('admin.page.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:270|unique:pages,slug,' . $id,
                'content' => 'required|string',
            ],
            [
                'required' => ":attribute không được để trống",
                'required' => ":attribute có độ dài tối đa 255 ký tự",
                'string' => ":attribute phải là một văn bản",
                'unique' => ":attribute",
            ],
            [
                'title' => 'Tiêu đề',
                'slug' => 'Đường dẫn thân thiện do hệ thống tự động tạo đã bị trùng lặp , bạn vui lòng điền đường dẫn thân thiện khác cho trang',
                'content' => 'Nội dung',
            ]
        );
        Page::withTrashed()->find($id)->update([
            'title' => $request->input('title'),
            'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
            'content' => $request->input('content'),
        ]);
        return redirect()->route('admin.page.edit', $id)->with('success', "Đã cập nhật trang");

    }
}
