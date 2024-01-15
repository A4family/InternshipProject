<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
<nav>
    <div class="menu-icon">
       <span class="fas fa-bars"></span>
    </div>
    <div class="logo">
       BrandLogo
    </div>
    <div class="nav-items">
       <li><a href="#">Home</a></li>
       <li><a href="#">About</a></li>
       <li><a href="#">Post an Ad</a></li>
       <li><a href="#">Login</a></li>
    </div>
    {{-- <div class="search-icon">
       <span class="fas fa-search"></span>
    </div>
    <div class="cancel-icon">
       <span class="fas fa-times"></span>
    </div> --}}
    <form action="#">
       <input type="search" class="search-data" placeholder="Search" required>
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