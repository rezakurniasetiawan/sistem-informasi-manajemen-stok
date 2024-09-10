 <div class="navbar-collapse collapse">
     <ul class="navbar-nav navbar-align">


         <li class="nav-item dropdown">
             <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                 <i class="align-middle" data-feather="settings"></i>
             </a>

             <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                 <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span
                     class="text-dark">Balqis</span>
             </a>
             <div class="dropdown-menu dropdown-menu-end">
                 <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1"
                         data-feather="user"></i> Profile</a>
                 <a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i>
                     Settings</a>
                 <div class="dropdown-divider"></div>
                 <form action="{{ route('actionlogout') }}" method="post">
                     @csrf
                     <button class="dropdown-item">Log out</button>
                 </form>
             </div>
         </li>
     </ul>
 </div>
