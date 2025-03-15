
<div class="sidebar-menu">
    <ul>
        <li><a class="sidebar-title">My Account</a></li>
        <li><a href="{{route('customer.account')}}" class="{{request()->is('customer/account')?'active':''}}"> Dashboard</a></li>
        <li><a href="{{route('customer.orders')}}" class="{{request()->is('customer/orders')?'active':''}}"> My Order</a></li>
        <li><a href="{{route('wishlist.show')}}" class="{{request()->is('wishlist')?'active':''}}"> Wishlist</a></li>
        <li><a href="{{route('customer.profile_edit')}}" class="{{request()->is('customer/profile-edit')?'active':''}}"> Profile Edit</a></li>
        <li><a href="{{route('customer.change_pass')}}" class="{{request()->is('customer/change-password')?'active':''}}"> Change Password</a></li>
        <li><a href="{{ route('customer.logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i data-feather="log-out"></i> Logout</a></li>
    </ul>
    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>