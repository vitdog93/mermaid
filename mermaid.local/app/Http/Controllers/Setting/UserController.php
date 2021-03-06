<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use PHPZen\LaravelRbac\Model\Role;
use Validator;

class UserController extends Controller
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
        $model = new User;
        $searchData = $request->searchData;
        if(isset($searchData['name']) && $searchData['name']){
            $model = $model->where(function ($q) use ($searchData){
                $q->where('name', 'LIKE', '%' . $searchData['name'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchData['name'] . '%');
            });
        }

        if( isset($searchData['id']) && intval($searchData['id'])){
            $model = $model->where('id', intval($searchData['id']));
        }
        if( isset($searchData['state']) && intval($searchData['state'])){
            $model = $model->where('state', intval($searchData['state']));
        }

        $limit = config('constants.item_per_page');
        $itemList = $model->orderBy('id', 'DESC')->paginate($limit);

        $userIds = [];
        foreach ($itemList as $key => $item) {
            $userIds[] = $item->created_by;
        }

        $user2Id = [];
        if ($userIds) {
            $userList =User::whereIn('id', $userIds)->get();
            foreach ($userList as $key => $user) {
                $user2Id[$user->id] = $user;
            }
        }

        $roleList = Role::get();

        return view('modules.setting.user.index', [
            'searchData' => $searchData,
            'itemList' => $itemList,
            'user2Id' => $user2Id,
            'roleList' => $roleList
        ]);
    }

    public function detail($id)
    {
        if (!intval($id)) {
            return response()->json([
                'message' => 'Qu???n tr??? vi??n kh??ng x??c ?????nh!'
            ], 400);
        }

        $model = \App\User::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Qu???n tr??? vi??n kh??ng t???n t???i!'
            ], 404);
        }

        if (isset($model->roles[0])) {
            $model->role = $model->roles[0]->id;
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
            'email' => [
                'required',
                'email',
                Rule::unique('users'),
            ],
            'password' => 'required|min:6',
        ], [
            'name.required' => 'T??n qu???n tr??? vi??n kh??ng x??c ?????nh!',
            'email.required' => 'Email kh??ng x??c ?????nh!',
            'email.email' => 'Email kh??ng ????ng ?????nh d???ng!',
            'email.unique' => 'Email ???? t???n t???i. Vui l??ng ch???n email kh??c!',
            'password.required' => 'M???t kh???u kh??ng x??c ?????nh!',
            'password.min' => 'M???t kh???u t???i thi???u c?? 6 k?? t???!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 406);
        }

        $requestData['password'] = Hash::make($requestData['password']);
        $requestData['created_by'] = auth()->user()->id;

        $roles = [];
        if (isset($requestData['role'])) {
            if ($requestData['role'] > 0) {
                $roles[] = $requestData['role'];
            }
            unset($requestData['role']);
        }

        DB::beginTransaction();
        try {
            $model = User::create($requestData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'L???i server. Vui l??ng th??? l???i sau!'
            ], 500);
        }

        if ($roles) {
            $model->roles()->sync($roles);
        }

        $request->session()->put('success', 'Th??m m???i qu???n tr??? vi??n th??nh c??ng!');
        return response()->json([
            'message' => 'Th??m m???i qu???n tr??? vi??n th??nh c??ng!'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $model = User::find(intval($id));
        if (!$model) {
            return response()->json([
                'message' => 'Qu???n tr??? vi??n kh??ng t???n t???i!'
            ], 404);
        }

        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($model->id),
            ],
        ], [
            'name.required' => 'T??n qu???n tr??? vi??n kh??ng x??c ?????nh!',
            'email.required' => 'Email kh??ng x??c ?????nh!',
            'email.email' => 'Email kh??ng ????ng ?????nh d???ng!',
            'email.unique' => 'Email ???? t???n t???i. Vui l??ng ch???n email kh??c!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 406);
        }

        $password = $model->password;
        if (isset($requestData['password'])) {
            if ($requestData['password']) {
                if (strlen($requestData['password']) < 6) {
                    return response()->json([
                        'message' => 'M???t kh???u t???i thi???u c?? 6 k?? t???.'
                    ], 406);
                }
                $password = Hash::make($requestData['password']);
            }
        }
        $requestData['password'] = $password;
        $requestData['updated_by'] = auth()->user()->id;

        $roles = [];
        if (isset($requestData['role'])) {
            if ($requestData['role'] > 0) {
                $roles[] = $requestData['role'];
            }
            unset($requestData['role']);
        }

        DB::beginTransaction();
        try {
            $model->update($requestData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'L???i server. Vui l??ng th??? l???i sau!'
            ], 500);
        }

        $model->roles()->sync($roles);

        $request->session()->put('success', 'C???p nh???t qu???n tr??? vi??n th??nh c??ng!');
        return response()->json([
            'message' => 'C???p nh???t qu???n tr??? vi??n th??nh c??ng!'
        ], 200);
    }
}
