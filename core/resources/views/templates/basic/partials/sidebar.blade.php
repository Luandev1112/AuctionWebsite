<div class="dashboard-menu">
    <div class="user">
        <span class="side-sidebar-close-btn"><i class="las la-times"></i></span>
        <div class="thumb">
            <img src="{{ getImage(imagePath()['profile']['user']['path'].'/'. auth()->user()->image,imagePath()['profile']['user']['size']) }}" alt="@lang('client')">
        </div>
        <div class="content mt-4">
            <h6 class="title"><a href="#0" class="text--base">{{auth()->user()->fullname}}</a></h6>
        </div>
    </div>
    <ul>
        <li>
            <a href="{{route('user.home')}}" class="{{request()->routeIs('user.home') ? 'active' : ''}}"><i class="las la-home"></i>@lang('Dashboard')</a>
        </li>
        <li>
            <a href="{{route('user.profile.setting')}}" class="{{request()->routeIs('user.profile.setting') ? 'active' : ''}}"><i class="las la-cog"></i>@lang('Profile Setting')</a>
        </li>
        <li>
            <a href="{{route('user.change.password')}}" class="{{request()->routeIs('user.change.password') ? 'active' : ''}}"><i class="las la-lock-open"></i>@lang('Change Password')</a>
        </li>

        <li>
            <a href="{{route('user.deposit')}}" class="{{request()->routeIs('user.deposit') ? 'active' : ''}}"><i class="las la-wallet"></i>@lang('Deposit Money')</a>
        </li>

        <li>
            <a href="{{route('user.deposit.history')}}" class="{{request()->routeIs('user.deposit.history') ? 'active' : ''}}"><i class="las la-tasks"></i>@lang('Deposit History')</a>
        </li>

         <li>
            <a href="{{route('user.withdraw')}}" class="{{request()->routeIs('user.withdraw') ? 'active' : ''}}"><i class="las la-credit-card"></i>@lang('Withdraw Money')</a>
        </li>

        <li>
            <a href="{{route('user.withdraw.history')}}" class="{{request()->routeIs('user.withdraw.history') ? 'active' : ''}}"><i class="las la-file-invoice-dollar"></i>@lang('Withdraw History')</a>
        </li>

        <li>
            <a href="{{route('user.transaction.history')}}" class="{{request()->routeIs('user.transaction.history') ? 'active' : ''}}"><i class="las la-home"></i>@lang('Transaction')</a>
        </li>
    </ul>

    <h6 class="subtitle ms-3 my-3 text--base">@lang('Product')</h6>
    <ul>
        <li>
            <a href="{{route('user.product.create')}}" class="{{request()->routeIs('user.product.create') ? 'active' : ''}}"><i class="las la-luggage-cart"></i>@lang('Post New Product')</a>
        </li>
        <li>
            <a href="{{route('user.product.index')}}" class="{{request()->routeIs('user.product.index') ? 'active' : ''}}"><i class="las la-bars"></i>@lang('Product List')</a>
        </li>
        <li>
            <a href="{{route('user.purchase.list')}}" class="{{request()->routeIs('user.purchase.list') ? 'active' : ''}}"><i class="las la-shopping-bag"></i>@lang('Purchase Product')</a>
        </li>
    </ul>

    <h6 class="subtitle ms-3 my-3 text--base">@lang('Sold Product')</h6>
    <ul>
        <li>
            <a href="{{route('user.order.list')}}"  class="{{request()->routeIs('user.order.list') ? 'active' : ''}}"><i class="las la-border-all"></i> @lang('All')</a>
        </li>

        <li>
            <a href="{{route('user.order.pending')}}"  class="{{request()->routeIs('user.order.pending') ? 'active' : ''}}"><i class="las la-exchange-alt"></i> @lang('Pending')</a>
        </li>

        <li>
            <a href="{{route('user.order.complete')}}"  class="{{request()->routeIs('user.order.complete') ? 'active' : ''}}"><i class="las la-th-list"></i> @lang('Complete')</a>
        </li>

        <li>
            <a href="{{route('user.order.process')}}"  class="{{request()->routeIs('user.order.process') ? 'active' : ''}}"><i class="las la-spinner"></i> @lang('In Process')</a>
        </li>

        <li>
            <a href="{{route('user.order.ship')}}"  class="{{request()->routeIs('user.order.ship') ? 'active' : ''}}"><i class="las la-truck"></i></i> @lang('Shipped')</a>
        </li>

        <li>
            <a href="{{route('user.order.dispute')}}" class="{{request()->routeIs('user.order.dispute') ? 'active' : ''}}"><i class="las la-bell-slash"></i> @lang('Disputed')</a>
        </li>

         <li>
            <a href="{{route('user.order.cancel')}}" class="{{request()->routeIs('user.order.cancel') ? 'active' : ''}}"><i class="lar la-window-close"></i> @lang('Canceled')</a>
        </li>
    </ul>
    <h6 class="subtitle ms-3 my-3 text--base">@lang('Other')</h6>
    <ul>
        <li>
            <a href="{{route('user.contact.send')}}" class="{{request()->routeIs('user.contact.send') ? 'active' : ''}}"><i class="las la-comment-dots"></i>@lang('Message')</a>
        </li>
        <li>
            <a href="{{route('user.twofactor')}}" class="{{request()->routeIs('user.twofactor') ? 'active' : ''}}"><i class="las la-home"></i>@lang('2FA Security')</a>
        </li>
        <li>
            <a href="{{route('ticket')}}" class="{{request()->routeIs('ticket') ? 'active' : ''}}"><i class="las la-ticket-alt"></i>@lang('Get Support')</a>
        </li>
        <li>
            <a href="{{route('user.logout')}}"><i class="las la-sign-out-alt"></i>@lang('Logout')</a>
        </li>
    </ul>
</div>
