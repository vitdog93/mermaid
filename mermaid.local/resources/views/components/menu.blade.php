<ul class="top-menu" style="box-shadow: none;top: -14px;text-align: left;">
    <li class="">
        <a href="/dashboard">Tổng quan</a>
    </li>
    <li class="dropdown">
        <a href="{{ route('account') }}" data-toggle="dropdown">Tài khoản</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('account.buyer') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Danh sách khách hàng
                </a>
            </li>
            <li>
                <a href="{{ route('account.seller') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Danh sách nhà bán hàng
                </a>
            </li>
            <li>
                <a href="{{ route('account.topup') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Danh sách yêu cầu topup
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="{{ route('product') }}" data-toggle="dropdown">Sản phẩm</a>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item pl-3" href="{{ route('product') }}">
                    <i class="zmdi zmdi-widgets zmdi-hc-fw"></i>
                    Danh sách sản phẩm
                </a>
            </li>
            <li>
                <a class="dropdown-item pl-3" href="{{ route('product.category') }}">
                    <i class="zmdi zmdi-menu zmdi-hc-fw"></i>
                    Danh mục sản phẩm
                </a>
            </li>
            <li>
                <a class="dropdown-item pl-3" href="{{ route('product.attribute') }}">
                    <i class="zmdi zmdi-share zmdi-hc-fw"></i>
                    Thuộc tính sản phẩm
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="{{ route('order') }}" data-toggle="dropdown">Đơn hàng</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('order') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Danh sách đơn hàng
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="{{ route('connect') }}" data-toggle="dropdown">Kết nối</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('connect.payment') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Kết nối thanh toán
                </a>
            </li>
            <li>
                <a href="{{ route('connect.shipping') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Kết nối vận chuyển
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="{{ route('notify') }}" data-toggle="dropdown">Thông báo/Email</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('notify') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Thông báo tự động
                </a>
            </li>
            <li>
                <a href="{{ route('notify.push') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Thông báo tay
                </a>
            </li>
            <li>
                <a href="{{ route('notify.segment') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Thời điểm thông báo
                </a>
            </li>
            <li>
                <a href="{{ route('notify.template') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-assignment zmdi-hc-fw"></i> Email template
                </a>
            </li>
        </ul>
    </li>
    <li class="dropdown">
        <a href="" data-toggle="dropdown">Cài đặt</a>
        <ul class="dropdown-menu">
            <li>
                <a href="{{ route('setting.user') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-account zmdi-hc-fw"></i> Quản trị viên
                </a>
            </li>
            <li>
                <a href="{{ route('setting.role') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-lock zmdi-hc-fw"></i> Danh sách phân quyền
                </a>
            </li>
            <li>
                <a href="{{ route('setting.permission') }}" class="dropdown-item pl-3">
                    <i class="zmdi zmdi-share zmdi-hc-fw"></i> Danh sách tính năng
                </a>
            </li>
        </ul>
    </li>
</ul>
