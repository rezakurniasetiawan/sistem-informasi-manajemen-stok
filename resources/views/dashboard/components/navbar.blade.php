 <div class="navbar-collapse collapse">
     <ul class="navbar-nav navbar-align">


         <li class="nav-item dropdown">
             <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                 <i class="align-middle" data-feather="settings"></i>
             </a>

             <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                     {{ Auth::user()->name }}</span>
             </a>
             <div class="dropdown-menu dropdown-menu-end">
                 <form action="{{ route('actionlogout') }}" method="post">
                     @csrf
                     <button class="dropdown-item">Log out</button>
                 </form>
             </div>
         </li>
     </ul>
 </div>
