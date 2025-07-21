<ul class="account-nav">
            <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Panel</a></li>
            <li><a href="{{route('user.account.orders')}}" class="menu-link menu-link_us-s">Orders</a></li>
            <li><a href="#" class="menu-link menu-link_us-s">Direcciones</a></li>
            <li><a href="#" class="menu-link menu-link_us-s">Detalles de la orden</a></li>
            <li> 
                <form action="{{route('logout')}}" method="POST" id="logout-form" >
                    @csrf
                    <a href="{{route('logout')}}" class="menu-link menu-link_us-s" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </form>
            </li>
</ul>