<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Mysql\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Validator;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $model = new Permission;
        $searchData = $request->searchData;
        if (isset($searchData['name']) && $searchData['name']) {
            $model = $model->where(function($q) use ($searchData) {
                $q->where('name', 'LIKE', '%' . $searchData['name'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchData['name'] . '%');
            });
        }

        if (isset($searchData['id']) && intval($searchData['id'])) {
            $model = $model->where('id', intval($searchData['id']));
        }

        $limit = config('constants.item_per_page');
        $itemList = $model->orderBy('id', 'DESC')->paginate($limit);

        $userIds = [];
        foreach ($itemList as $key => $item) {
            $userIds[] = $item->created_by;
        }

        $user2Id = [];
        if ($userIds) {
            $userList = User::whereIn('id', $userIds)->get();
            foreach ($userList as $key => $user) {
                $user2Id[$user->id] = $user;
            }
        }

        return view('modules.setting.permission.index', [
            'searchData' => $searchData,
            'itemList' => $itemList,
            'user2Id' => $user2Id,
        ]);
    }

    public function detail($id)
    {
        if (!intval($id)) {
            return response()->json([
                'message' => 'Tính năng không xác định!'
            ], 400);
        }

        $model = Permission::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Tính năng không tồn tại!'
            ], 404);
        }

        return response()->json([
            'item' => $model
        ], 200);
    }

    public function create(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'slug' => [
                'required',
                Rule::unique('permissions'),
            ],
        ], [
            'name.required' => 'Tên tính năng không xác định!',
            'slug.required' => 'Khóa chỉ mục không xác định!',
            'slug.unique' => 'Khóa chỉ mục đã tồn tại!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 406);
        }

        $requestData['created_by'] = auth()->user()->id;
        DB::beginTransaction();
        try {
            $model = Permission::create($requestData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi server. Vui lòng thử lại sau!'
            ], 500);
        }

        $request->session()->put('success', 'Thêm mới tính năng thành công!');
        return response()->json([
            'message' => 'Thêm mới tính năng thành công!'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $model = Permission::find(intval($id));
        dd($model);
        if (!$model) {
            return response()->json([
                'message' => 'Tính năng không tồn tại!'
            ], 404);
        }

        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'slug' => [
                'required',
                Rule::unique('permissions')->ignore($model->id),
            ],
        ], [
            'name.required' => 'Tên tính năng không xác định!',
            'slug.required' => 'Khóa chỉ mục không xác định!',
            'slug.unique' => 'Khóa chỉ mục đã tồn tại!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 406);
        }

        $requestData['updated_by'] = auth()->user()->id;
        DB::beginTransaction();
        try {
            $model->update($requestData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi server. Vui lòng thử lại sau!'
            ], 500);
        }

        $request->session()->put('success', 'Cập nhật tính năng thành công!');
        return response()->json([
            'message' => 'Cập nhật tính năng thành công!'
        ], 200);
    }
}
