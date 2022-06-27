<?php

namespace App\Http\Controllers\Adminstrator;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Image;
use App\Widget_Detail;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function list()
    {
        $banners = Banner::where('type', 'banner')->paginate(10);
        $index = ($banners->perPage() * $banners->currentPage()) - $banners->perPage() + 1;
        return view('admin.banner.list', compact('banners', 'index'));
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
                'file.required' => "Vui lòng tải lên banner",
                'image' => ':attribute có định dạng (png, jpg, jpeg, gif, ...)',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute bắt buộc là một text',
            ],
            [
                'title' => 'Tên banner (có thể là mô tả)',
                'file' => 'Banner',
            ]
        );

        $data = [
            'title' => $request->input('title'),
            'type' => 'banner',
        ];
        $banner = [];
        if ($request->hasFile('file')) {
            $upload_dir = 'public/images/banner/';
            $item = $request->file;

            $file_name = pathinfo($item->getClientOriginalName(), PATHINFO_FILENAME);
            $file_format = pathinfo($item->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $item->getClientOriginalName();
            if (file_exists(public_path() . "/images/banner/" . $item->getClientOriginalName())) {
                $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($upload_file)) {
                    $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
            }
            $item->move($upload_dir, $upload_file);
            $banner = [
                'name' => $file_name,
                'url' => $upload_file,
            ];
        }

        $banner_instance = Banner::create($data);
        $banner['relation_id'] = $banner_instance->id;
        $banner['relation_type'] = "App\Banner";
        Image::create($banner);
        return redirect()->route('admin.banner.list')->with('success', "Đã thêm banner");
    }


    public function edit($id){
        $banner = Banner::find($id);
        return view('admin.banner.edit', compact('banner'));
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
                'title' => 'Tên banner (có thể là mô tả)',
                'file' => 'Banner',
            ]
        );
        $banner = [];
        if ($request->hasFile('file')) {
            $upload_dir = 'public/images/banner/';
            $item = $request->file;

            $file_name = pathinfo($item->getClientOriginalName(), PATHINFO_FILENAME);
            $file_format = pathinfo($item->getClientOriginalName(), PATHINFO_EXTENSION);
            $upload_file = $upload_dir . $item->getClientOriginalName();
            if (file_exists(public_path() . "/images/banner/" . $item->getClientOriginalName())) {
                $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                $k = 2;
                while (file_exists($upload_file)) {
                    $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                    $k++;
                }
            }
            if (file_exists(base_path(Banner::find($id)->image->url))) {
                unlink(base_path(Banner::find($id)->image->url));
            }
            $item->move($upload_dir, $upload_file);
            $banner = [
                'name' => $file_name,
                'url' => $upload_file,
            ];
        }

        $data = [
            'title' => $request->input('title'),
        ];

        Banner::find($id)->update($data);
        Image::find(Banner::find($id)->image->id)->update($banner);
        return redirect()->route('admin.banner.edit', $id)->with('success', "Đã cập nhật banner");
    }

    public function destroy($id){
        $banner = Banner::find($id);
        $widget_detail = Widget_Detail::where('image_id', $banner->image->id)->first();
        if(!empty($widget_detail)){
            return redirect()->route('admin.banner.list')->with('error', "Bạn nên cân nhắc xóa bởi vì Banner bạn đang xóa được sử dụng bởi khối widget <strong>" . $widget_detail->widget->title . "</strong>, nếu xóa sẽ ảnh hưởng trực tiếp đến giao diện người dùng");
        }else{
            Image::destroy($banner->image->id);
            if (file_exists(base_path($banner->image->url))) {
                unlink(base_path($banner->image->url));
            }
            Banner::destroy($banner->id);
            return redirect()->route('admin.banner.list')->with('success', 'Đã xóa banner');
        }
    }
}
