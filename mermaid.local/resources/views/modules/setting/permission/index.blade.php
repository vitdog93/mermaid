@extends('layouts.app')

@section('title', __('Cài đặt - Tính năng'))

@section('header')

@endsection

@section('content')
    <section class="content content--full">
        <header class="content__title">
            <h1>Cài đặt</h1>
            <small>Tính năng</small>

            <div class="actions">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="/dashboard">Tổng quan</a>
                    <a class="breadcrumb-item" href="{{ route('setting') }}">Cài đặt</a>
                    <span class="breadcrumb-item active">Tính năng</span>
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
                            <input type="text" class="form-control" name="searchData[name]" placeholder="{{ __('Tên, mô tả...') }}"
                                   value="{{ isset($searchData['name']) ? $searchData['name'] : '' }}">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-2 text-right ml-auto">
                        <button type="submit" class="btn btn-primary mb-4">{{ __('Tìm kiếm') }}</button>
                        <a href="{{ route('setting.permission') }}" class="btn btn-light mb-4">{{ __('Bỏ lọc') }}</a>
                    </div>
                </form>
                <div class="table-responsive align-middle">
                    <table class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>#{{ __('ID') }}</th>
                            <th>{{ __('Tính năng') }}</th>
                            <th>{{ __('Mô tả') }}</th>
                            <th>{{ __('Thời gian tạo') }}</th>
                            <th>{{ __('Người tạo') }}</th>
                            <th class="text-right">
                                <button type="button" class="btn btn-sm btn-success" onclick="addItem()">
                                    <i class="zmdi zmdi-plus"></i> Thêm mới
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($itemList as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="javascript:void(0)" onclick="editItem({{ $item->id }})">{{ $item->name }}</a></td>
                                <td>{{ $item->description }}</td>
                                <td>{{ date('H:i | d/m/Y', strtotime($item->created_at . '+7 hours')) }}</td>
                                <td>
                                    <?php if (isset($user2Id[$item->created_by])): ?>
                                    {{ $user2Id[$item->created_by]->name }}
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="editItem({{ $item->id }})">
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
    <div class="modal fade" id="modalItem">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post" id="formItem">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Thông tin tính năng') }}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>{{ __('Tên tính năng') }}</label>
                            <input type="text" class="form-control" placeholder="---" id="item-name" name="name" required>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Khóa chỉ mục') }}</label>
                            <input type="text" class="form-control" placeholder="---" id="item-slug" name="slug" required>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Mô tả') }}</label>
                            <textarea id="item-description" name="description" class="form-control" placeholder="---"></textarea>
                            <i class="form-group__bar"></i>
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
    <script src="{{ asset('assets/js/setting/permission.js') }}"></script>
@endsection

