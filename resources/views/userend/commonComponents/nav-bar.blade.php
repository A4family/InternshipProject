<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<nav>
    <div class="menu-icon">
       <span class="fas fa-bars"></span>
    </div>
    <div class="logo">
       BrandLogo
    </div>
    <div class="nav-items">
       <li><a href="{{ route('user-home') }}">Home</a></li>
       <li><a href="#">About</a></li>
       <li><a href="{{ route('product-ad-form') }}">Post an Ad</a></li>
       @guest
            <li><a href="{{ route('user.login') }}">Cart</a></li>
            <li><a href="{{ route('user.login') }}">Login</a></li>
       @else
            <li><a href="{{ route('cart-items', ['userId' => auth()->id()]) }}">Cart</a></li>
            <li class="dropdown">
            <button onclick="myFunction()" class="dropbtn">{{ auth()->user()->username }}</button>
            <div id="myDropdown" class="dropdown-content">
              <a href="{{ route('my-product-ads') }}">Dashboard</a>
              <a href="{{ route('user.logout') }}">Logout</a>
            </div>
        </li>
        <script>
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            window.onclick = function(event) {
                if (!event.target.matches('.dropbtn')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>
       @endguest
    </div>
    {{-- <div class="search-icon">
       <span class="fas fa-search"></span>
    </div>
    <div class="cancel-icon">
       <span class="fas fa-times"></span>
    </div> --}}
    <form action="#">
       <input type="search" class="search-data" placeholder="Search Products" required>
       <button type="submit" class="fas fa-search"></button>
    </form>
 </nav>

 <script>
    const menuBtn = document.querySelector(".menu-icon span");
    const searchBtn = document.querySelector(".search-icon");
    const cancelBtn = document.querySelector(".cancel-icon");
    const items = document.querySelector(".nav-items");
    const form = document.querySelector("form");
    menuBtn.onclick = ()=>{
      items.classList.add("active");
      menuBtn.classList.add("hide");
      searchBtn.classList.add("hide");
      cancelBtn.classList.add("show");
    }
    cancelBtn.onclick = ()=>{
      items.classList.remove("active");
      menuBtn.classList.remove("hide");
      searchBtn.classList.remove("hide");
      cancelBtn.classList.remove("show");
      form.classList.remove("active");
      cancelBtn.style.color = "#ff3d00";
    }
    searchBtn.onclick = ()=>{
      form.classList.add("active");
      searchBtn.classList.add("hide");
      cancelBtn.classList.add("show");
    }
 </script>
