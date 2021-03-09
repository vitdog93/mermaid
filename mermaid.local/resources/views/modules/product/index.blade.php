
@extends('layouts.app')

@section('title', __('Danh sách sản phẩm'))

@section('header')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/fotorama-4.6.4/fotorama.css') }}">
@endsection

@section('content')
    <section class="content content--full">
        <header class="content__title">
            <h1>{{ __('Danh sách sản phẩm') }}</h1>
            <div class="actions">
                <nav class="breadcrumb">
                    <a class="breadcrumb-item" href="/">{{ __('Tổng quan') }}</a>
                    <span class="breadcrumb-item active">{{ __('Danh sách sản phẩm') }}</span>
                </nav>
            </div>
            <div class="float-button">
                <button class="btn btn--raised btn-success btn--icon"
                        onclick="addItem()">
                    <i class="zmdi zmdi-plus"></i>
                </button>
            </div>
        </header>
            <div class="card">
            <div class="card-body">
                <form class="form-row" method="get" action="{{ route('product') }}">
{{--                    <input type="hidden" name="searchData[state]" value="{{ $searchData['state'] }}">--}}
                    <div class="col-md-1">
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchData[id]" placeholder="{{ __(' ID sản phẩm...') }}"
                                   value="{{ isset($searchData['id']) ? $searchData['id'] : '' }}">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" name="searchData[name]" placeholder="{{ __('Tên sản phẩm, tên cửa hàng...') }}"
                                   value="{{ isset($searchData['name']) ? $searchData['name'] : '' }}">
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select class="category__filter w-100" name="searchData[category]"></select>
                        </div>
                    </div>

                    <div class="col-md-2 text-right ml-auto">
                        <button type="submit" class="btn btn-primary mb-4">{{ __('Tìm kiếm ') }}</button>
                        <a href="{{ route('product') }}" class="btn btn-light mb-4">{{ __('Bỏ lọc') }}</a>
                    </div>
                </form>
                <div class="table-responsive align-middle">
                    <table class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>#{{ __('ID') }}</th>
                            <th>{{ __('Sản phẩm') }}</th>
                            <th>{{ __('Mã sản phẩm ') }}</th>
                            <th>{{ __('Số lượng') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('Tình trạng') }}</th>
                            <th style="width: 100px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($itemList as $p)
<!--                            --><?php //$item = json_decode($p->data) ?>
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p-> name  }}</td>
                                <td>{{ $p-> description }}</td>
                                <td>{{$p-> quantity  }}</td>
                                <td>
                                    @if($p->quantity == 0)
                                    <span class="badge badge-pill badge-danger">Hết hàng</span>
                                    @else
                                        <span class="badge badge-pill badge-success">Còn hàng</span>
                                        @endif
                                </td>
{{--                                <td class="text-right">--}}
{{--                                    <a href="javascript:void(0)" class="btn btn-sm btn-info" onclick="viewItem({{ $p->id }})">--}}
{{--                                        <i class="zmdi zmdi-eye"></i> Chi tiết--}}
{{--                                    </a>--}}
{{--                                </td>--}}
                                <td class="text-right">
                                    <a href="javascript:void(0)" onclick="editItem({{$p->id}})"
                                       class="btn btn-sm btn-info zmdi zmdi-edit mr-1" data-toggle="tooltip"
                                       data-placement="top" data-original-title="{{ __('Chỉnh sửa') }}"></a>
                                    <a href="javascript:void(0)" onclick="if(!confirm('{{ __('Bạn có muốn xóa sản phẩm này?') }}'))return false;"
                                       class="btn btn-sm btn-danger zmdi zmdi-delete" data-toggle="tooltip"
                                       data-placement="top" data-original-title="{{ __('Xóa') }}"></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('Không có kết quả phù hợp') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $itemList->links('components.pagination') }}
            </div>
        </div>
    </section>
    <div class="modal modal__full fade" id="modalItem">
        <div class="modal-dialog">
            <div class="modal-content">
                Đang tải.....................
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalForm">
        <div class="modal-dialog">
            <div class="modal-content" style="width: 700px">
                <form action="" method="post" enctype="multipart/form-data" id="formProduct">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title pull-left">{{ __('Chi tiêt sản phẩm') }}</h5>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>{{ __('Tên sản phẩm') }}</label>
                            <input type="text" class="form-control" placeholder="---" id="productName" name="name"
                                   required>
                            <i class="form-group__bar"></i>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Mã sản phẩm') }}</label>
                            <input type="text" class="form-control" placeholder="---" id="productCode" name="code"
                                   required>
                            <i class="form-group__bar"></i>
                        </div>
                        <div class="form-group" style="width: 50px">
                            <label for="quantity">{{ __('Số lượng') }}</label>
                            <input type="number" class="form-control" placeholder="0" id="productQuantity" name="quantity"
                                   required>
                            <i class="form-group__bar"></i>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Miêu tả sản phẩm') }}</label>
                            <textarea type="text" class="form-control" rows="5" placeholder="---"
                                      id="productDescription" name="description"></textarea>
                            <i class="form-group__bar"></i>
                        </div>


                        <div class="">
                            <button type="submit" class="btn btn-primary">{{ __('Confirm') }}</button>
                            <button type="button" class="btn btn-light"
                                    data-dismiss="modal">{{ __('Close') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/product/category.js') }}"></script>
    <script src="{{ asset('assets/js/product/product.js') }}"></script>
@endsection
