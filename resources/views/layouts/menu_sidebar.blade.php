 <!-- ========== App Menu ========== -->
 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="/" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="{{ asset('assets') }}/images/logo-sm.png" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('assets') }}/images/logo-dark.png" alt="" height="17">
             </span>
         </a>
         <!-- Light Logo-->
         <a href="/" class="logo logo-light">
             <span class="logo-sm">
                 <img src="{{ asset('assets') }}/images/logo-sm.png" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('assets') }}/images/logo-light.png" alt="" height="17">
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div id="scrollbar">
         <div class="container-fluid">

             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="widgets.html">
                         <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                     </a>
                 </li>

                 <li class="menu-title"><span data-key="t-menu">Processing</span></li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="/receiving">
                         <i class="ri-share-forward-2-line"></i> <span data-key="t-receiving">Receiving</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="/cutting">
                         <i class="ri-knife-blood-line"></i> <span data-key="t-cutting">Cutting</span>
                     </a>
                 </li>
                 {{-- <li class="nav-item">
                     <a class="nav-link menu-link" href="#receiving" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="receiving">
                         <i class="ri-share-forward-2-line"></i> <span data-key="t-receiving">Receiving</span>
                     </a>
                     <div class="collapse menu-dropdown" id="receiving">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="pages-starter.html" class="nav-link" data-key="t-starter">Receiving</a>
                             </li>

                             <li class="nav-item">
                                 <a href="pages-team.html" class="nav-link" data-key="t-team">Data</a>
                             </li>
                         </ul>
                     </div>
                 </li> --}}

                 {{--  cutting --}}
                 {{-- <li class="nav-item">
                     <a class="nav-link menu-link" href="#cutting" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="cutting">
                         <i class="ri-knife-blood-line"></i> <span data-key="t-cutting">Cutting</span>
                     </a>
                     <div class="collapse menu-dropdown" id="cutting">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="pages-starter.html" class="nav-link" data-key="t-starter">Cutting</a>
                             </li>

                             <li class="nav-item">
                                 <a href="pages-team.html" class="nav-link" data-key="t-team">Data</a>
                             </li>
                         </ul>
                     </div>
                 </li> --}}

                 {{-- retouching --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#retouching" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="retouching">
                         <i class="ri-dashboard-line"></i> <span data-key="t-retouching">Retouching</span>
                     </a>
                     <div class="collapse menu-dropdown" id="retouching">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="pages-starter.html" class="nav-link" data-key="t-starter">Cutting</a>
                             </li>

                             <li class="nav-item">
                                 <a href="pages-team.html" class="nav-link" data-key="t-team">Data</a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 {{-- stuffing --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#retouching" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="retouching">
                         <i class="ri-luggage-cart-fill"></i> <span data-key="t-pages">Retouching</span>
                     </a>
                     <div class="collapse menu-dropdown" id="retouching">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="pages-starter.html" class="nav-link" data-key="t-retouching">Cutting</a>
                             </li>

                             <li class="nav-item">
                                 <a href="pages-team.html" class="nav-link" data-key="t-team">Data</a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Pengaturan</span></li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="/supplier">
                         <i class="ri-dashboard-2-line"></i> <span data-key="t-supplier">Supplier</span>
                     </a>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#users" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="users">
                         <i class="ri-pages-line"></i> <span data-key="t-users">Users</span>
                     </a>
                     <div class="collapse menu-dropdown" id="users">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="pages-starter.html" class="nav-link" data-key="t-starter"> Starter </a>
                             </li>
                             <li class="nav-item">
                                 <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse" role="button"
                                     aria-expanded="false" aria-controls="sidebarProfile" data-key="t-profile">
                                     Profile
                                 </a>
                                 <div class="collapse menu-dropdown" id="sidebarProfile">
                                     <ul class="nav nav-sm flex-column">
                                         <li class="nav-item">
                                             <a href="pages-profile.html" class="nav-link" data-key="t-simple-page">
                                                 Simple Page </a>
                                         </li>
                                         <li class="nav-item">
                                             <a href="pages-profile-settings.html" class="nav-link"
                                                 data-key="t-settings"> Settings </a>
                                         </li>
                                     </ul>
                                 </div>
                             </li>

                         </ul>
                     </div>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarLanding">
                         <i class="ri-rocket-line"></i> <span data-key="t-landing">Landing</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarLanding">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="landing.html" class="nav-link" data-key="t-one-page"> One Page </a>
                             </li>

                             <li class="nav-item">
                                 <a href="job-landing.html" class="nav-link"><span data-key="t-job">Job</span>
                                     <span class="badge badge-pill bg-success" data-key="t-new">New</span></a>
                             </li>
                         </ul>
                     </div>
                 </li>


             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
 <!-- Left Sidebar End -->
 <!-- Vertical Overlay-->
 <div class="vertical-overlay"></div>
