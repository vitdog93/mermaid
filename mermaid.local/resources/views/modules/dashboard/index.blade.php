@extends('layouts.app')

@section('title', __('Dashboard'))

@section('header')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
    <section class="content content--full">
        <header class="content__title">
            <h1>Trang chủ</h1>
            <small>Welcome to the unique Material Design admin web app experience!</small>

            <div class="actions">
                <div class="input-group">
                    <input type="text" class="form-control daterange-dateranges" placeholder="Pick a date">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                    </div>
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </header>

        <div class="row quick-stats">
            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item bg-blue">
                    <div class="quick-stats__info">
                        <h2>987,459</h2>
                        <small>Tiếp cận</small>
                    </div>

                    <div class="quick-stats__chart sparkline-bar-stats">6,4,8,6,5,6,7,8,3,5,9,5</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item bg-amber">
                    <div class="quick-stats__info">
                        <h2>356,785</h2>
                        <small>Đăng ký</small>
                    </div>

                    <div class="quick-stats__chart sparkline-bar-stats">4,7,6,2,5,3,8,6,6,4,8,6</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item bg-purple">
                    <div class="quick-stats__info">
                        <h2>58,778</h2>
                        <small>Đơn hàng</small>
                    </div>

                    <div class="quick-stats__chart sparkline-bar-stats">9,4,6,5,6,4,5,7,9,3,6,5</div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="quick-stats__item bg-red">
                    <div class="quick-stats__info">
                        <h2>214,540,000</h2>
                        <small>Doanh thu tạm tính</small>
                    </div>

                    <div class="quick-stats__chart sparkline-bar-stats">5,6,3,9,7,5,4,6,5,6,4,9</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Doanh thu</h4>
                        <h6 class="card-subtitle">Vestibulum purus quam scelerisque, mollis nonummy metus</h6>
                        <div class="actions">
                            <a href="#" class="actions__item zmdi zmdi-eye"></a>
                        </div>

                        <div class="flot-chart flot-curved-line"></div>
                        <div class="flot-chart-legends flot-chart-legends--curved"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tổng quan</h4>
                        <h6 class="card-subtitle">Commodo luctus nisi erat porttitor ligula eget lacinia odio semnec elit</h6>
                        <div class="actions">
                            <a href="#" class="actions__item zmdi zmdi-eye"></a>
                        </div>

                        <div class="flot-chart flot-line"></div>
                        <div class="flot-chart-legends flot-chart-legends--line"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Đơn hàng mới</h4>
                <h6 class="card-subtitle">Commodo luctus nisi erat porttitor ligula eget lacinia odio semnec elit</h6>
                <div class="actions">
                    <a href="#" class="actions__item zmdi zmdi-refresh-alt"></a>
                    <a href="#" class="actions__item zmdi zmdi-format-list-bulleted"></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Thời gian tạo</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-success">Hoàn thành</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-info">Mới</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-danger">Hủy</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-warning">Giao hàng</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-success">Hoàn thành</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-info">Mới</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-danger">Hủy</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        <tr>
                            <th scope="row"><a href="#">ABC123</a></th>
                            <td>PiTi Phạm</td>
                            <td>14:03 - 06/03/2019</td>
                            <td>Thanh toán trực tiếp</td>
                            <td><span class="badge badge-pill badge-warning">Giao hàng</span></td>
                            <td>289,000 ₫</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('assets/bower_components/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/bower_components/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/bower_components/flot.curvedlines/curvedLines.js') }}"></script>
    <script src="{{ asset('assets/bower_components/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/bower_components/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Charts and maps-->
    <script src="{{ asset('assets/js/flot-charts/curved-line.js') }}"></script>
    <script src="{{ asset('assets/js/flot-charts/line.js') }}"></script>
    <script src="{{ asset('assets/js/flot-charts/chart-tooltips.js') }}"></script>
    <script src="{{ asset('assets/js/other-charts.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection
