<?php
$user = auth()->user();
//dd($user);
$avatar = $user->avatar ? $user->avatar : '/assets/img/demo/img/profile-pics/2.jpg';
?>
<header class="header">
    <div class="navigation-trigger hidden-xl-up" data-ma-action="aside-open" data-ma-target=".sidebar">
        <div class="navigation-trigger__inner">
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
            <i class="navigation-trigger__line"></i>
        </div>
    </div>

    <div class="header__logo">
        <h1>
            <a href="/dashboard">
                <img src="https://cdn.chozoi.vn/static/85e4cb1f5ac64472a289c4640e9badb9.png" alt="bigmarket" style="max-height: 45px;">
            </a>
        </h1>
    </div>

    <div class="search">
        <div class="search__inner">
            @include('components.menu')
        </div>
    </div>

    <ul class="top-nav">
        <li class="dropdown hidden-xs-down">
            <a href="" data-toggle="dropdown">
                <img src="{{$avatar}}" alt="{{$user->name}}" style="width: 2rem;height: 2rem;border-radius: 50%;">
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href=""><i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> {{ __('Trang cá nhân') }}</a>
                <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="zmdi zmdi-long-arrow-return zmdi-hc-fw"></i>
                    {{ __('Đăng xuất') }}
                </a>
            </div>
        </li>
    </ul>
</header>
