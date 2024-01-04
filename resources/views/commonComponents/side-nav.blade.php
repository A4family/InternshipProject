<nav>
    <div class="brand-place">
        <span>Brand</span>
    </div>

    <div class="activities">
        <div class="navigation">
            <ul>
                <a href={{ route('admin.dashboard') }}><li><i class="fa-solid fa-layer-group"></i></i> Dashboard</li></a>
                <a href={{ route('admin-category.index') }}><li><i class="fa-solid fa-layer-group"></i></i> Category</li></a>
                <a href=""><li><i class="fa-solid fa-layer-group"></i></i> Users</li></a>
                <a href=""><li><i class="fa-solid fa-layer-group"></i></i> Admins</li></a>
            </ul>
        </div>
        <div class="utilities">
            <ul>
                <a href=""><li><i class="fa-solid fa-layer-group"></i></i> Settings</li></a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><li><i class="fa-solid fa-layer-group"></i> 
                    Logout</li></a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </div>
    </div>
</nav>