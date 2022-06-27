<?php

namespace App\Http\Controllers\Adminstrator;

use App\Http\Controllers\Controller;
use App\Image;
use App\Slider;
use App\Widget_Detail;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function list()
    {
        $sliders = Slider::where('type', 'slider')->paginate(10);
        $index = ($sliders->perPage() * $sliders->currentPage()) - $sliders->perPage() + 1;
        return view('admin.slider.list', compact('sliders', 'index'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'file' => "required|image",
            ],
            [
                'required' => ":attribute không được để trống",
                'file.required' => "Vui lòng tải lên slider",
                'image' => ':attribute có định dạng (png, jpg, jpeg, gif, ...)',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute bắt buộc là một text',
            ],
            [
                'title' => 'Tên slider (có thể là mô tả)',
                'file' => 'Slider',
            ]
        );

        $data = [
            'title' => $request->input('title'),
            'type' => 'slider',
        ];
        $slider = [];
        if ($request->hasFile('file')) {
            $upload_dir = 'public/images/slider/';
            $item = $request->file;

            $file_name = pathinfo($item->getClientOriginalName(), PATHINFO_FILENAME);
            $file_format = pathinfo($item->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $item->getClientOriginalName();
            if (file_exists(public_path() . "/images/slider/" . $item->getClientOriginalName())) {
                $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($upload_file)) {
                    $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
            }
            $item->move($upload_dir, $upload_file);
            $slider = [
                'name' => $file_name,
                'url' => $upload_file,
            ];
        }

        $slider_instance = Slider::create($data);
        $slider['relation_id'] = $slider_instance->id;
        $slider['relation_type'] = "App\Slider";
        Image::create($slider);

        return redirect()->route('admin.slider.list')->with('success', "Đã thêm slider");
    }

    public function edit($id){
        $slider = Slider::find($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id){
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'file' => "nullable|image",
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => ':attribute có định dạng (png, jpg, jpeg, gif, ...)',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute bắt buộc là một text',
            ],
            [
                'title' => 'Tên slider (có thể là mô tả)',
                'file' => 'Slider',
            ]
        );
        $slider = [];
        if ($request->hasFile('file')) {
            $upload_dir = 'public/images/slider/';
            $item = $request->file;

            $file_name = pathinfo($item->getClientOriginalName(), PATHINFO_FILENAME);
            $file_format = pathinfo($item->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $item->getClientOriginalName();
            if (file_exists(public_path() . "/images/slider/" . $item->getClientOriginalName())) {
                $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($upload_file)) {
                    $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
            }
            if (file_exists(base_path(Slider::find($id)->image->url))) {
                unlink(base_path(Slider::find($id)->image->url));
            }
            $item->move($upload_dir, $upload_file);
            $slider = [
                'name' => $file_name,
                'url' => $upload_file,
            ];
        }

        $data = [
            'title' => $request->input('title'),
        ];

        Slider::find($id)->update($data);
        Image::find(Slider::find($id)->image->id)->update($slider);
        return redirect()->route('admin.slider.edit', $id)->with('success', "Đã cập nhật slider");
    }

    public function destroy($id){
        $slider = Slider::find($id);
        $widget_detail = Widget_Detail::where('image_id', $slider->image->id)->first();
        if(!empty($widget_detail)){
            return redirect()->route('admin.slider.list')->with('error', "Bạn nên cân nhắc xóa bởi vì Slider bạn đang xóa được sử dụng bởi khối widget <strong>" . $widget_detail->widget->title . "</strong>, nếu xóa sẽ ảnh hưởng trực tiếp đến giao diện người dùng");
        }else{
            Image::destroy($slider->image->id);
            if (file_exists(base_path($slider->image->url))) {
                unlink(base_path($slider->image->url));
            }
            Slider::destroy($slider->id);
            return redirect()->route('admin.slider.list')->with('success', 'Đã xóa slider');
        }
    }
}
