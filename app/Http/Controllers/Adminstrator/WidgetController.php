<?php

namespace App\Http\Controllers\Adminstrator;

use App\Banner;
use App\Category;
use App\Http\Controllers\Controller;
use App\Page;
use App\Slider;
use App\Widget;
use App\Widget_Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'widget']);
            return $next($request);
        });
    }

    public function list()
    {
        $widgets = data_tree(Widget::all()->toArray());
        $page_on_click = !empty($_GET['page']) ? $_GET['page'] : 1;
        $paginate = get_param_pagging(20, count($widgets), $page_on_click);
        $confirm = "Bạn chắc chắn xóa vĩnh viễn khối giao diện . Những khối giao diện con phụ thuộc sẽ không mất đi nhưng không thể hoàn tác";
        return view('admin.widget.list', compact('widgets', 'paginate', 'confirm'));
    }

    public function get_widget_image_ajax(){
        $result = [];
        $data_widget = $_GET['data_widget'];
        $url = convert_widget_url($data_widget);
        if(!file_exists(base_path($url))){
            $result = [
                'result' => false,
            ];
        }else{
            $result = [
                'result' => true,
                'url' => url($url),
            ];
        }
        echo json_encode($result);
    }

    public function store(Request $request)
    {
        // return redirect()->route('admin.widget.list')->with('warning', 'Vui lòng liên hệ quản trị hệ thống để biết thêm chi tiết');
        $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'desc' => ['nullable', 'string', 'max:255'],
                'parent_id' => ['required', "not_in:''"],
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute phải là một text',
                'parent_id.required' => 'Chọn :attribute mà khối thuộc vào',
            ],
            [
                'title' => "Tên khối giao diện",
                'desc' => "Mô tả ngắn khối",
                'parent_id' => "khối giao diện cha",
            ]
        );

        $data = [
            'title' => $request->input('title'),
            'desc' => !empty($request->input('desc')) ? $request->input('desc') : "",
            'parent_id' => $request->input('parent_id'),
            'user_id' => Auth::id(),
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Widget::create($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        return redirect()->route('admin.widget.list')->with('success', "Đã thêm khối giao diện");
    }

    public function content_list($id){
        $widget = Widget::find($id);
        $widget_details = data_tree_widget_details($widget->widget_details->toArray());
        return view('admin.widget.content.list', compact('widget', 'widget_details'));
    }

    public function content_create($id){
        $widget = Widget::find($id);
        $pages = Page::all()->toArray();
        $sliders = Slider::where('type', 'slider')->get();
        $banners = Banner::where('type', 'banner')->get();
        $categories_product = data_tree(Category::where([['type', 'product'], ['parent_id', '!=', 999999]])->get()->toArray());
        $categories_post = data_tree(Category::where([['type', 'post'], ['parent_id', "!=", 999999]])->get()->toArray());
        $last_order = Widget_Detail::where('widget_id', $widget->id)->orderBy('order', 'desc')->limit(1)->first('order');
        if(!empty($last_order)){
            $last_order = $last_order->toArray()['order'] + 1;
        }else{
            $last_order = 1;
        }
        return view('admin.widget.content.create', compact('widget', 'last_order', 'pages', 'categories_product', 'categories_post', 'sliders', 'banners'));
    }

    public function content_store(Request $request){
        $request->validate(
            [
                'content' => ['nullable', 'string', 'max:255'],
                'url' => ['nullable', 'string', 'max:270'],
                'image_id' => ['nullable'],
                'order' => ['required'],
                'type_content' => ['required'],
                'widget_id' => ['nullable'],
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute phải là một text',
                'type_content.required' => 'Chọn :attribute',
            ],
            [
                'content' => "Nội dung",
                'url' => "Đường dẫn của nội dung",
                'type_content' => "loại nội dung"
            ]
        );

        $content = "";
        $list_child_slider_banner = [];
        if($request->input('type_content') == 'plaintext-basic'){
            $type_content = $request->input('content');
            $type_heading = $request->input('type_heading');
            $type_color = $request->input('type_color')!==null ? "style='color: {$request->input('type_color')};'" : "";
            if($type_heading !== null){
                $content = "<{$type_heading} {$type_color}>{$type_content}</{$type_heading}>";
            }else{ 
               $content = $request->input('content');
            }
            
        }
        if($request->input('type_content') == 'plaintext-icon'){
            $type_content = $request->input('content');
            $type_heading = $request->input('type_heading');
            $type_color = $request->input('type_color')!==null ? "style='{$request->input('type_color')}'" : "";
            $type_icon = $request->input('type_icon');
            if($type_heading !== null){
                $content = "<{$type_heading} {$type_color}>{$type_content}</{$type_heading}>";
            }else{
                $content = $request->input('content');
            }
            if($type_icon !== null){
                $content = "<i class='{$type_icon}'></i>" . $content;
            }
        }
        if($request->input('type_content') == 'plaintext-slider-banner-group'){
            $list_child_slider_banner = $request->input('detail_id');
            $content = $request->input('url');
            if($content == ""){
                $content = "NONE";
            }
        }
        $data = [
            'content' => $content,
            'order' => $request->input('order'),
            'widget_id' => $request->input('widget_id'),
        ];
        if($request->input('url') !== null){
            $data['url'] = $request->input('url');
        }
        if($request->input('image_id') !== null){
            $data['image_id'] = (int)$request->input('image_id');
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $widget_detail = Widget_Detail::create($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        if(!empty($list_child_slider_banner)){
            $data_update = ['detail_id' => $widget_detail->id];
            foreach($list_child_slider_banner as $child){
                Widget_Detail::find($child)->update($data_update);
            }
        }
        return redirect()->route('admin.widget.content.list', ['id' => $data['widget_id']])->with('success', "Đã thêm nội dung vào khối giao diện");
    }

    public function content_destroy($id){
        $widget_detail = Widget_Detail::find($id);
        $widget_detail_child = $widget_detail->details;
        if(!empty($widget_detail_child)){
            foreach($widget_detail_child as $item){
                Widget_Detail::destroy($item->id);
            }
        }
        Widget_Detail::destroy($widget_detail->id);
        return redirect()->back()->with('success', 'Đã xóa nội dung của widget');
    }

}
