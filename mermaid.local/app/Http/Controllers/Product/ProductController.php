<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Mysql\Product;
use Illuminate\Http\Request;
use Mockery\Exception;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $model = new Product();
        $searchData = $request->searchData;

        if (isset($searchData['id']) && $searchData['id']) {
            $model = $model->where('products.id', intval($searchData['id']));
        }

//        if (!isset($searchData['state'])) {
//            $searchData['state'] = "PENDING";
//        }
//        $model = $model->where('products.state', $searchData['state']);

        if (isset($searchData['name']) && $searchData['name']) {
            $model = $model->where(function($q) use ($searchData) {
                $q->where('product->name', 'ILIKE', '%' . $searchData['name'] . '%');
            });
        }

        $limit = config('constants.item_per_page');
        $itemList = $model->orderBy('products.id', 'DESC')->paginate($limit);
        return view('modules.product.index', [
            'searchData' => $searchData,
            'itemList' => $itemList,
        ]);
    }

    public function create(Request $request){
        $requestData = $request->all();
        foreach ($request->file('image') as $img)
        {
        $originalImage = $img;
        $thumbnailImage = Image::make($originalImage);
        $thumbnailPath = public_path().'/thumbnail/';
        $originalPath = public_path().'/images/';
        $thumbnailImage->save($originalPath.$originalImage->getClientOriginalName());
        $thumbnailImage->resize(150,150);
        $thumbnailImage->save($thumbnailPath.$originalImage->getClientOriginalName());
        $data[] = $originalImage->getClientOriginalName();
        }
        $requestData['image']= json_encode($data);
        $model = Product::create($requestData);
        $model->save();
//        DB::beginTransaction();
//        try{
//
//            DB::commit();
//        }catch (\Exception $e){
//            DB::rollBack();
//            return response()->json([
//                'message' => 'Lỗi server. Vui lòng thử lại sau'
//            ],500);
//        }
        return redirect()->route('product');
    }
    public function detail($id)
    {
        $model = Product::find(intval($id));
        if (!$model) {
            return response()->json([
                'item' => ''
            ], 404);
        }
        $data= [
            'id' => $model->id,
            'name' => $model->name,
            'code' => $model->code,
            'description' => $model->description,
            'quantity' => $model->quantity,
            'wholesale_price' => $model->wholesale_price,
            'price' => $model->price,
            'image' => $model->image,
        ];
        return response()->json([
            'item' => $data
        ],200);
    }
    public function update(Request $request,$id)
    {
        $model = Product::find(intval($id));
        if (!$model) {
            abort(404);
        }

        $requestData = $request->all();
        $originalImage = $request->file('image');
        $thumbnailImage = Image::make($originalImage);
        $thumbnailPath = public_path().'/thumbnail/';
        $originalPath = public_path().'/images/';
        $thumbnailImage->save($originalPath.$originalImage->getClientOriginalName());
        $thumbnailImage->resize(150,150);
        $thumbnailImage->save($thumbnailPath.$originalImage->getClientOriginalName());
        $model->update($requestData);
        $model->image=$originalImage->getClientOriginalName();
        $model->save();

        return redirect()->route('product');
    }
}
