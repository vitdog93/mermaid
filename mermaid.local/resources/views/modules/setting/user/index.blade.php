@extends('layouts.app')

@section('title', __('Cài đặt - Quản trị viên'))

@section('header')

@endsection

@section('content')
    <section class="content content--full">
        <header class="content__title">
            <h1>Cài đặt</h1>
            <small>Quản trị viên</small>

            <div class="actions">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="/dashboard">Tổng quan</a>
                    <a class="breadcrumb-item" href="{{ route('setting') }}">Cài đặt</a>
                    <span class="breadcrumb-item active">Quản trị viên</span>
                </nav>
            </div>
        </header>

        <div class="card">
            <div class="card-body">
                <form class="form-row" method="get">
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchData[id]" placeholder="{{ __('ID...') }}"
                                   value="{{ isset($searchData['id']) ? $searchData['id'] : '' }}">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchData[name]" placeholder="{{ __('Tên, Email...') }}"
                                   value="{{ isset($searchData['name']) ? $searchData['name'] : '' }}">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="select2" data-minimum-results-for-search="Infinity" name="searchData[state]">
                                <option selected value="">{{ __('Trạng thái') }}</option>
                                <option value="PUBLIC">{{ __('Hoạt động') }}</option>
                                <option value="PENDING">{{ __('Chờ duyệt') }}</option>
                                <option value="LOCKED">{{ __('Tạm khóa') }}</option>
                                <option value="DELETED">{{ __('Đã xóa') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 text-right ml-auto">
                        <button type="submit" class="btn btn-primary mb-4">{{ __('Tìm kiếm') }}</button>
                        <a href="{{ route('setting.user') }}" class="btn btn-light mb-4">{{ __('Bỏ lọc') }}</a>
                    </div>
                </form>
                <div class="table-responsive align-middle">
                    <table class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>#{{ __('ID') }}</th>
                            <th>{{ __('Quản trị viên') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Thời gian tạo') }}</th>
                            <th>{{ __('Người tạo') }}</th>
                            <th class="text-center">{{ __('Trạng thái') }}</th>
                            <th class="text-right">
                                <button type="button" class="btn btn-sm btn-success" onclick="addUser()">
                                    <i class="zmdi zmdi-plus"></i> Thêm mới
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($itemList as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="javascript:void(0)" onclick="editUser({{ $item->id }})">{{ $item->name }}</a></td>
                                <td>{{ $item->email }}</td>
                                <td>{{ date('H:i | d/m/Y', strtotime($item->created_at . '+7 hours')) }}</td>
                                <td>
                                    <?php if (isset($user2Id[$item->created_by])): ?>
                                    {{ $user2Id[$item->created_by]->name }}
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($item->state == 'PUBLIC'): ?>
                                    <span class="badge badge-pill badge-success">{{ __('Hoạt động') }}</span>
                                    <?php elseif ($item->state == 'PENDING'): ?>
                                    <span class="badge badge-pill badge-warning">{{ __('Chờ duyệt') }}</span>
                                    <?php elseif ($item->state == 'LOCKED'): ?>
                                    <span class="badge badge-pill badge-dark">{{ __('Tạm khóa') }}</span>
                                    <?php elseif ($item->state == 'DELETED'): ?>
                                    <span class="badge badge-pill badge-danger">{{ __('Đã khóa') }}</span>
                                    <?php else: ?>
                                    <span class="badge badge-pill badge-light">{{ __('Không xác định') }}</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="editUser({{ $item->id }})">
                                        <i class="zmdi zmdi-edit"></i> Sửa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('Không tìm thấy dữ liệu theo yêu cầu') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $itemList->links('components.pagination') }}
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formUser">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Thông tin quản trị viên') }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Quản trị viên') }}</label>
                            <input type="text" class="form-control" placeholder="---" id="item-name" name="name" required>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input type="text" class="form-control" placeholder="---" id="item-email" name="email" required>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Mật khẩu') }}</label>
                            <input type="password" class="form-control" placeholder="---" id="item-password" name="password" required>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Ảnh đại diện') }}</label>
                            <div class="input-group input-group-sm">
                                <input type="text" id="item-avatar" class="form-control " placeholder="---" name="avatar" style="padding-left: 0;">
                                <span class="input-group-btn upload">
                            <input type="file" class="hidden">
                            <button type="button" class="btn btn-success btn-xs">Tải ảnh</button>
                        </span>
                            </div>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Phân quyền') }}</label>
                            <select class="select2" data-minimum-results-for-search="Infinity" id="item-role" name="role">
                                <option value="" selected>Chọn phân quyền</option>
                                <?php foreach ($roleList as $key => $role): ?>
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Trạng thái</label>
                            <div class="">
                                <div class="radio radio--inline">
                                    <input type="radio" name="state" id="item-state--PUBLIC" value="PUBLIC" checked>
                                    <label class="radio__label" for="item-state--PUBLIC">Hoạt động</label>
                                </div>
                                <div class="radio radio--inline">
                                    <input type="radio" name="state" id="item-state--PENDING" value="PENDING">
                                    <label class="radio__label" for="item-state--PENDING">Chờ duyệt</label>
                                </div>
                                <div class="radio radio--inline">
                                    <input type="radio" name="state" id="item-state--LOCKED" value="LOCKED">
                                    <label class="radio__label" for="item-state--LOCKED">Tạm khóa</label>
                                </div>
                                <div class="radio radio--inline">
                                    <input type="radio" name="state" id="item-state--DELETED" value="DELETED">
                                    <label class="radio__label" for="item-state--DELETED">Xóa</label>
                                </div>
                            </div>
                        </div>

                        <div class="">
                            <button type="submit" class="btn btn-primary">{{ __('Xác nhận') }}</button>
                            <button type="button" class="btn btn-light" data-dismiss="modal">{{ __('Đóng') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/setting/user.js') }}"></script>
@endsection
