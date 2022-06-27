<?php

namespace App\Http\Controllers\Adminstrator;

use App\Brand;
use App\Category;
use App\Category_Brand;
use App\Color;
use App\Http\Controllers\Controller;
use App\Image;
use App\Memory;
use App\Product;
use App\Product_Color;
use App\Ram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
        if (Category::where([['title', '=', 'Uncategorized'], ['parent_id', '=', 999999], ['type', '=', 'product']])->first() === null) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Category::create([
                'title' => 'Uncategorized',
                'slug' => 'uncategorized',
                'description' => 'Danh mục sản phẩm mặc định',
                'parent_id' => 999999,
                'type' => 'product'
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
        Product::where('user_id', null)->delete();
    }

    // Categories
    public function cat_list()
    {
        $list_category = data_tree(Category::where([['type', 'product'], ['parent_id', '!=', 999999]])->get()->toArray());
        $list_brand = Brand::all()->toArray();
        $uncategorized = Category::where([['type', 'product'], ['parent_id', 999999]])->first()->toArray();
        $uncategorized = data_tree([0 => $uncategorized], 999999);
        $categories = $list_category;
        $categories = array_merge($uncategorized, $categories);

        $page_on_click = !empty($_GET['page']) ? $_GET['page'] : 1;
        $paginate = get_param_pagging(10, count($categories), $page_on_click);
        $confirm = "Bạn chắc chắn xóa vĩnh viễn danh mục . Những danh mục con phụ thuộc sẽ không mất đi nhưng không thể hoàn tác";

        return view('admin.product.cat.list', compact('categories', 'list_category', 'list_brand', 'confirm', 'paginate'));
    }

    public function cat_store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'slug' => 'nullable|max:255|string|unique:categories',
                'description' => 'nullable|max:255|string',
                'parent_id' => "required|not_in:''",
                'brand_id' => "required",
            ],
            [
                'required' => ":attribute không được để trống",
                'parent_id.required' => 'Chọn :attribute',
                'brand_id.required' => 'Chọn :attribute',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute bắt buộc là một text',
                'unique' => ':attribute'
            ],
            [
                'title' => 'Tên danh mục',
                'slug' => 'Đường dẫn thân thiện đã tồn tại . Bạn vui lòng chọn đường dẫn thân thiện khác cho danh mục',
                'description' => 'Mô tả',
                'parent_id' => 'danh mục cha',
                'brand_id' => 'thương hiệu con phụ thuộc . Giúp khách hàng phân loại trong quá trình tìm kiếm sản phẩm'
            ]
        );
        $data = array(
            'title' => $request->input('title'),
            'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'parent_id' => $request->input('parent_id'),
            'type' => 'product'
        );
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $category_instance = Category::create($data);
        if (!empty($request->input('brand_id'))) {
            foreach ($request->input('brand_id') as $item) {
                if (!empty($item)) {
                    Category_Brand::create([
                        'cat_id' => $category_instance->id,
                        'brand_id' => $item
                    ]);
                }
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        return redirect()->route('admin.product.cat.list')->with('success', 'Đã thêm danh mục');
    }

    public function cat_destroy($id)
    {
        $category = Category::find($id);
        if ($category->parent_id == 999999 and $category->type == 'product') {
            return redirect()->route('admin.product.cat.list')->with('warning', 'Xóa danh mục sẽ không xóa sản phẩm trong danh mục đó. Thay vì thế, sản phẩm sẽ được chuyển đến danh mục mặc định Uncategorized. Danh mục mặc định không thể xóa.');
        }

        // Chuyển all parent_id con phụ thuộc = parent_id danh mục đang xóa
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

        // Chuyển tất cả sản phẩm thuộc danh mục đang xóa sang danh mục không xác đinh 
        $products = $category->products;

        if (!$products->isEmpty()) {
            $uncategorized = Category::where([['parent_id', 999999], ['type', 'product']])->first();
            foreach ($products as $product) {
                Product::withTrashed()->find($product->id)->update(['cat_id' => $uncategorized->id]);
            }
        }
        Category::destroy($id);
        return redirect()->route('admin.product.cat.list')->with('success', 'Đã xóa danh mục');
    }

    public function cat_edit($id)
    {
        $list_category = data_tree(Category::where([['type', 'product'], ['parent_id', '!=', 999999]])->get()->toArray());
        $list_brand = Brand::all()->toArray();
        $category = Category::find($id);
        $category_brand = $category->brands->pluck('id')->toArray();
        if ($category->parent_id == 999999 and $category->type == 'product') {
            return redirect()->route('admin.product.cat.list')->with('warning', 'Không thể cập nhật danh mục mặc định');
        }
        return view('admin.product.cat.edit', compact('category', 'list_category', 'list_brand', 'category_brand'));
    }

    public function cat_update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|max:255|string',
                'slug' => 'nullable|max:255|string|unique:categories,slug,' . $id,
                'description' => 'nullable|max:255|string',
                'parent_id' => "required|not_in:''",
                'brand_id' => "required",

            ],
            [
                'required' => ":attribute không được để trống",
                'parent_id.required' => 'Chọn :attribute',
                'brand_id.required' => 'Chọn :attribute',
                'max' => ':attribute tối đa 255 ký tự',
                'unique' => ':attribute',
                'string' => ':attribute bắt buộc là một text',
            ],
            [
                'title' => 'Tên danh mục',
                'slug' => 'Đường dẫn thân thiện đã tồn tại . Bạn vui lòng chọn đường dẫn thân thiện khác cho danh mục',
                'description' => 'Mô tả',
                'parent_id' => 'danh mục cha',
                'brand_id' => 'thương hiệu con phụ thuộc . Giúp khách hàng phân loại trong quá trình tìm kiếm sản phẩm'
            ]
        );



        $data = array(
            'title' => $request->input('title'),
            'slug' => !empty($request->input('slug')) ? $request->input('slug') : Str::slug($request->input('title')),
            'description' => $request->input('description'),
            'parent_id' => $request->input('parent_id'),
        );

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Category::find($id)->update($data);
        if (!empty($request->input('brand_id'))) {
            Category_Brand::where('cat_id', $id)->delete();
            foreach ($request->input('brand_id') as $item) {
                if (!empty($item)) {
                    Category_Brand::create([
                        'cat_id' => $id,
                        'brand_id' => $item
                    ]);
                }
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        return redirect()->route('admin.product.cat.edit', $id)->with('success', "Đã cập nhật danh mục");
    }

    // Brands
    public function brand_list()
    {
        $brands = Brand::paginate(10);
        return view('admin.product.brand.list', compact('brands'));
    }

    public function brand_store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:50|unique:brands',
            ],
            [
                'required' => ":attribute không được để trống",
                'max' => ":attribute tối đa 50 ký tự",
                'string' => ":attribute là một text",
                'unique' => ":attribute đã tồn tại trong hệ thống"
            ],
            [
                'name' => "Tên thương hiệu"
            ]
        );

        Brand::create(['name' => $request->input('name')]);
        return redirect()->route('admin.product.brand.list')->with('success', "Đã thêm thương hiệu");
    }

    public function brand_edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.product.brand.edit', compact('brand'));
    }

    public function brand_update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:50|unique:brands,name,' . $id,
            ],
            [
                'required' => ":attribute không được để trống",
                'max' => ":attribute tối đa 50 ký tự",
                'string' => ":attribute là một text",
                'unique' => ":attribute đã tồn tại trong hệ thống"
            ],
            [
                'name' => "Tên thương hiệu"
            ]
        );


        Brand::find($id)->update(['name' => $request->input('name')]);
        return redirect()->route('admin.product.brand.edit', $id)->with('success', "Đã cập nhật thương hiệu");
    }

    // Color
    public function color_list()
    {
        $colors = Color::paginate(10);
        return view('admin.product.color.list', compact('colors'));
    }

    public function color_store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:50',
                'code' => "required|string|max:20",
            ],
            [
                'required' => ":attribute không được để trống",
                'max' => ":attribute tối đa 50 ký tự",
                'string' => ":attribute là một text",
            ],
            [
                'title' => "Tên màu sắc",
                'code' => "Mã màu",
            ]
        );
        $data = $request->all(['title', 'code']);
        Color::create($data);
        return redirect()->route('admin.product.color.list')->with('success', "Đã thêm màu sắc");
    }

    public function color_edit($id)
    {
        $color = Color::find($id);
        return view('admin.product.color.edit', compact('color'));
    }

    public function color_update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'required|string|max:50',
                'code' => 'required|string|max:20',
            ],
            [
                'required' => ":attribute không được để trống",
                'max' => ":attribute tối đa 50 ký tự",
                'string' => ":attribute là một text",
            ],
            [
                'title' => "Tên màu sắc",
                'code' => "Mã màu sắc"
            ]
        );


        Color::find($id)->update(
            [
                'title' => $request->input('title'),
                'code' => $request->input('code'),
            ]
        );
        return redirect()->route('admin.product.color.edit', $id)->with('success', "Đã cập nhật màu sắc");
    }

    // Products
    public function list(Request $request)
    {

        $key = '';
        $count = [
            'all' => Product::all()->count(),
            'on' => Product::where('status', 'on')->count(),
            'off' => Product::where('status', 'off')->count(),
            'still' => Product::where('stocking', 'still')->count(),
            'out' => Product::where('stocking', 'out')->count(),
            'trash' => Product::onlyTrashed()->count(),
            'unknown_author' => Product::onlyTrashed()->where('user_id', null)->count(),
        ];
        if ($request->input('key') !== null) {
            $key = $request->input('key');
            $products = Product::where('name', 'LIKE', "%{$key}%")->orderBy('created_at', 'desc')->paginate(10);
            $products->list_action = ['on', 'off', 'still', 'out', 'destroy'];
            $products->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
        } else {
            if ($request->input('status') === 'on') {
                $products = Product::where('status', 'on')->orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['off', 'still', 'out', 'destroy'];
                $products->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
            } elseif ($request->input('status') === 'off') {
                $products = Product::where('status', 'off')->orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['on', 'still', 'out', 'destroy'];
                $products->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
            } elseif ($request->input('status') === 'still') {
                $products = Product::where('stocking', 'still')->orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['out', 'on', 'off', 'destroy'];
                $products->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
            } elseif ($request->input('status') === 'out') {
                $products = Product::where('stocking', 'out')->orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['still', 'on', 'off', 'destroy'];
                $products->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
            } elseif ($request->input('status') === 'trash') {
                $products = Product::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['restore', 'forceDelete', 'on', 'off', 'still', 'out'];
                $products->confirm = "Bạn chắc chắn xóa vĩnh viễn sản phẩm . Không thể hoàn tác";
            } elseif ($request->input('status') === 'unknown_author') {
                $products = Product::onlyTrashed()->where('user_id', null)->orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['restore', 'forceDelete', 'on', 'off', 'still', 'out'];
                $products->confirm = "Bạn chắc chắn xóa vĩnh viễn sản phẩm . Không thể hoàn tác";
            } else {
                $products = Product::orderBy('created_at', 'desc')->paginate(10);
                $products->list_action = ['on', 'off', 'still', 'out', 'destroy'];
                $products->confirm = "Bạn chắc chắn xóa sản phẩm . Có thể hoàn tác";
            }
        }
        $index = ($products->perPage() * $products->currentPage()) - $products->perPage() + 1;
        return view('admin.product.list', compact('products', 'key', 'count', 'index'));
    }

    public function action(Request $request)
    {
        $action = $request->input('action');
        $list_check = $request->input('list_check');
        if ($action !== null) {
            if ($list_check !== null) {
                // on off still out destroy forceDelete restore
                if ($action == 'on') {
                    Product::withTrashed()->whereIn('id', $list_check)->update(['status' => 'on']);
                }
                if ($action == 'off') {
                    Product::withTrashed()->whereIn('id', $list_check)->update(['status' => 'off']);
                }
                if ($action == 'still') {
                    Product::withTrashed()->whereIn('id', $list_check)->update(['stocking' => 'still']);
                }
                if ($action == 'out') {
                    Product::withTrashed()->whereIn('id', $list_check)->update(['stocking' => 'out']);
                }
                if ($action == 'destroy') {
                    Product::destroy($list_check);
                }
                if ($action == 'forceDelete') {
                    Product::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                }
                if ($action == 'restore') {
                    foreach ($list_check as $id) {
                        if (Product::onlyTrashed()->where([['id', '=', $id], ['user_id', '=', null]])->first() !== null) {
                            Product::onlyTrashed()->where('id', $id)->update(['user_id' => Auth::id()]);
                        }
                    }
                    Product::onlyTrashed()->whereIn('id', $list_check)->restore();
                }

                return redirect()->back()->with('success', 'Đã áp dụng thao tác thành công cho sản phẩm');
            }
            return redirect()->back()->with('warning', 'Vui lòng chọn sản phẩm');
        }
        return redirect()->back()->with('warning', 'Vui lòng chọn thao tác áp dụng');
    }

    public function create()
    {
        $list_category = data_tree(Category::where([['type', 'product'], ['parent_id', '!=', 999999]])->get(['id', 'title', 'parent_id'])->toArray());
        $list_color = Color::all()->toArray();
        $list_memory = Memory::all()->toArray();
        $list_ram = Ram::all()->toArray();


        return view('admin.product.create', compact('list_category', 'list_color', 'list_ram', 'list_memory'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['nullable', 'max:255', 'string', 'unique:products'],
                'price' => ['required', 'integer'],
                'old_price' => ['nullable', 'integer'],
                'desc' => ['required', 'max:500', 'string'],
                'content' => ['required', 'string'],
                'status' => ['required'],
                'stocking' => ['required'],
                'cat_id' => ['required', "not_in:''"],
                'brand_id' => ['required', "not_in:''"],
                'file' => 'required',
                'file.*' => 'mimes:jpeg,jpg,png,gif|max:2048',

                'memory_id' => ['nullable', "not_in:''"],
                'ram_id' => ['nullable', "not_in:''"],
                'color_id' => ['nullable'],
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => ':attribute',
                'max' => ':attribute tối đa 255 ký tự',
                'string' => ':attribute phải là một text',
                'integer' => ':attribute phải là số và tương đương với giá tiền của sản phẩm',
                'cat_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'brand_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'file.required' => 'Chọn ảnh sản phẩm',

                'memory_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'ram_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'color_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
            ],
            [
                'name' => "Tên sản phẩm",
                'slug' => 'Đường dẫn thân thiện đã tồn tại . Bạn vui lòng chọn đường dẫn thân thiện khác cho sản phẩm',
                'price' => "Giá sản phẩm",
                'old_price' => "Giá cũ",
                'desc' => "Mô tả ngắn sản phẩm",
                'content' => "Chi tiết sản phẩm",
                'cat_id' => "danh mục",
                'brand_id' => 'thương hiệu',
                'status' => "Trạng thái sản phẩm",
                'stocking' => "Tồn kho sản phẩm",

                'memory_id' => "bộ nhớ trong",
                'ram_id' => "ram",
                'color_id' => "màu sắc",
            ]
        );


        $data = $request->all(['name', 'slug', 'price', 'old_price', 'desc', 'content', 'cat_id', 'brand_id', 'ram_id', 'memory_id', 'status', 'stocking']);
        $data_color = $request->input('color_id');



        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        $data['user_id'] = Auth::id();
        $list_thumb = [];
        if ($request->hasFile('file')) {
            $upload_dir = 'public/images/product/';
            foreach ($request->file as $item) {
                $file_name = pathinfo($item->getClientOriginalName(), PATHINFO_FILENAME);
                $file_format = pathinfo($item->getClientOriginalName(), PATHINFO_EXTENSION);
                $upload_file = $upload_dir . $item->getClientOriginalName();
                if (file_exists(public_path() . "/images/product/" . $item->getClientOriginalName())) {
                    $upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                    $k = 2;
                    while (file_exists($upload_file)) {
                        $upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                        $k++;
                    }
                }
                $item->move($upload_dir, $upload_file);
                $list_thumb[] = [
                    'name' => $file_name,
                    'url' => $upload_file,
                ];
            }
        }
        $data['old_price'] = !empty($data['old_price']) ? $data['old_price'] : 0;
        $product_instance = Product::create($data);
        foreach ($list_thumb as $thumb) {
            $thumb['relation_id'] = $product_instance->id;
            $thumb['relation_type'] = "App\Product";
            Image::create($thumb);
        }
        if (!empty($data_color)) {
            foreach ($data_color as $color) {
                Product_Color::create([
                    'product_id' => $product_instance->id,
                    'color_id' => $color,
                ]);
            }
        }


        return redirect()->route('admin.product.list')->with('success', "Đã thêm sản phẩm");
    }

    public function destroy($id)
    {
        if (Product::onlyTrashed()->find($id) !== null) {
            $images = Product::withTrashed()->find($id)->images;
            foreach ($images as $image) {
                unlink(base_path($image->url));
                Image::destroy($image->id);
            }
            Product::onlyTrashed()->where('id', $id)->forceDelete();
            return redirect()->back()->with('success', 'Đã xóa vĩnh viễn sản phẩm');
        } else {
            Product::destroy($id);
            return redirect()->back()->with('success', 'Sản phẩm đã vào thùng rác');
        }
    }

    public function edit($id)
    {
        $product = Product::withTrashed()->find($id);
        $colors_of_product = $product->colors->pluck('id')->toArray();
        $list_category = data_tree(Category::where([['type', 'product'], ['parent_id', '!=', 999999]])->get(['id', 'title', 'parent_id'])->toArray());
        $list_brand = Category::find($product->cat_id)->brands->pluck('name', 'id')->toArray();

        $list_color = Color::all()->toArray();
        $list_memory = Memory::all()->toArray();
        $list_ram = Ram::all()->toArray();
        return view('admin.product.edit', compact('product', 'list_category', 'list_brand', 'list_color', 'list_ram', 'list_memory', 'colors_of_product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['nullable', 'max:255', 'string', "unique:products,slug,{$id}"],
                'price' => ['required', 'integer'],
                'old_price' => ['nullable', 'integer'],
                'desc' => ['required', 'max:500', 'string'],
                'content' => ['required', 'string'],
                'status' => ['required'],
                'stocking' => ['required'],
                'cat_id' => ['required', "not_in:''"],
                'brand_id' => ['required', "not_in:''"],

                'memory_id' => ['nullable', "not_in:''"],
                'ram_id' => ['nullable', "not_in:''"],
                'color_id' => ['nullable'],
            ],
            [
                'required' => ':attribute không được để trống',
                'unique' => ":attribute",
                'max' => ':attribute tối đa 500 ký tự',
                'string' => ':attribute phải là một text',
                'integer' => ':attribute phải là số và tương đương với giá tiền của sản phẩm',
                'cat_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'brand_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',

                'memory_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'ram_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
                'color_id.required' => 'Chọn :attribute mà sản phẩm thuộc vào',
            ],
            [
                'name' => "Tên sản phẩm",
                'slug' => 'Đường dẫn thân thiện đã tồn tại . Bạn vui lòng chọn đường dẫn thân thiện khác cho sản phẩm',
                'price' => "Giá sản phẩm",
                'old_price' => "Giá cũ",
                'desc' => "Mô tả ngắn sản phẩm",
                'content' => "Chi tiết sản phẩm",
                'cat_id' => "danh mục",
                'brand_id' => 'thương hiệu',
                'status' => "Trạng thái sản phẩm",
                'stocking' => "Tồn kho sản phẩm",

                'memory_id' => "bộ nhớ trong",
                'ram_id' => "ram",
                'color_id' => "màu sắc",
            ]
        );
        $data = $request->all(['name', 'slug', 'price', 'old_price', 'desc', 'content', 'cat_id', 'brand_id', 'ram_id', 'memory_id', 'status', 'stocking']);
        $data_color = $request->input('color_id');

        $data['slug'] = !empty($data['slug']) ? $data['slug'] : Str::slug($data['name']);
        $data['old_price'] = !empty($data['old_price']) ? $data['old_price'] : 0;

        Product::where('id', $id)->update($data);
        if (!empty($data_color)) {
            $old_colors = Product_Color::where('product_id', $id)->get()->pluck('id')->toArray();
            Product_Color::destroy($old_colors);
            foreach ($data_color as $color) {
                Product_Color::create([
                    'product_id' => $id,
                    'color_id' => $color,
                ]);
            }
        } else {
            Product_Color::where('product_id', $id)->delete();
        }

        return redirect()->route('admin.product.edit', $id)->with('success', "Đã cập nhật sản phẩm");
    }

    public function delete_image_ajax()
    {
        $result = array();
        $image_id = $_GET['image_id'];
        $product_id = $_GET['product_id'];

        if (Product::withTrashed()->where('id', $product_id)->first()->images->count() <= 1) {
            $result['delete'] = false;
        } else {
            if ($image = Image::find($image_id)) {
                Image::destroy($image_id);
                if (file_exists(base_path($image->url))) {
                    unlink(base_path($image->url));
                    $result['delete'] = true;
                }
            }
        }
        echo json_encode($result);
    }

    public function upload_image_ajax()
    {
        $result = '';
        $error = '';
        $list_image = [];
        $product_id = $_POST['product_id'];
        $list_image = validation_image("files", "error", "public/images/product/");
        if (!empty($list_image)) {
            foreach ($list_image as $key => $value) {
                $data = [
                    'name' => $value['name'],
                    'url' => $value['url'],
                    'name' => $value['name'],
                    'relation_id' => $product_id,
                    'relation_type' => "App\Product",
                ];
                $image_instance = Image::create($data);
                if (move_uploaded_file($value['tmp_name'], $value['url'])) {
                    $route_delete_image = route('admin.product.delete_image_ajax');
                    $url = url($image_instance->url);
                    $result .= "<li>";
                    $result .=      "<img data-image='{$image_instance->id}' src='{$url}' alt='' width='150px' height='150px'>";
                    $result .= "    <ul class='list-update-thumb' data-url='{$route_delete_image}'>";
                    $result .= "        <li><a class='delete' href='' data-image='{$image_instance->id}' data-id='{$product_id}' title='Xóa hình ảnh' class='edit'><i class='fa fa-trash' aria-hidden='true'></i></a></li>";
                    $result .= "    </ul>";
                    $result .= "</li>";
                } else {
                    $error = "Hệ thống đang xảy ra lỗi . Mong bạn thử lại sau";
                }
            }
        }

        // Kết luận
        if (empty($error)) {
            echo $result;
        } else {
            echo $error;
        }
    }

    public function swap_order_image_ajax()
    {
        $result = array();
        $id_one = $_GET['image_one'];
        $id_two = $_GET['image_two'];

        $image_one = Image::find($id_one);
        $image_two = Image::find($id_two);

        if (Image::where('id', $id_one)->update(['url' => $image_two->url, 'name' => $image_two->name]) > 0) {
            if (Image::where('id', $id_two)->update(['url' => $image_one->url, 'name' => $image_one->name]) > 0) {
                $result = array(
                    'swap_image' => true,
                    'new_src_img_one' => url($image_two->url),
                    'new_src_img_two' => url($image_one->url),
                );
            } else {
                $result['swap_image'] = false;
            }
        } else {
            $result['swap_image'] = false;
        }
        echo json_encode($result);
    }

    public function load_brand_ajax()
    {
        $result = [];
        $html_option = "";
        $cat_id = $_GET['cat_id'];
        $list_brand = Category::find($cat_id)->brands->pluck('name', 'id')->toArray();
        if (!empty($list_brand)) {
            $html_option .= "<option value=''>Chọn thương hiệu</option>";
            foreach ($list_brand as $key => $value) {
                $html_option .= "<option value='{$key}'>{$value}</option>";
            }
            $result = array(
                'result' => true,
                'html_option' => $html_option
            );
        } else {
            $result = array(
                'result' => false,
            );
        }


        echo json_encode($result);
    }
}
