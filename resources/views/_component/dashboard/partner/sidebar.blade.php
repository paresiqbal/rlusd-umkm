@php
    $urlPath = explode('/', request()->path());
@endphp

<div class="fixed bottom-0 z-20 h-screen border-r vertical-menu left-0 top-[70px] bg-slate-50 border-gray-50 print:hidden">
        
  <div data-simplebar class="h-full">
      <!--- Sidemenu -->
      <div class="metismenu pb-10 pt-2.5" id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul id="side-menu">
              <li class="px-5 py-3 text-xs font-medium text-gray-500 cursor-default leading-[18px] group-data-[sidebar-size=sm]:hidden block" data-key="t-menu">Menu</li>

              <li>
                  <a href="{{ route('partners.dashboard') }}" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500">
                      <i data-feather="home" fill="#545a6d33"></i>
                      <span data-key="t-dashboard"> Dashboard</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('partners.jobs.index') }}" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500">
                      <i data-feather="briefcase" fill="#545a6d33"></i>
                      <span data-key="t-jobs"> Lowongan</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('partners.candidates.index') }}" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500">
                      <i data-feather="user-check" fill="#545a6d33"></i>
                      <span data-key="t-candidates"> Kandidat</span>
                  </a>
              </li>
              
              <li class="px-5 py-3 mt-2 text-xs font-medium text-gray-500 cursor-default leading-[18px] group-data-[sidebar-size=sm]:hidden" data-key="t-mitra">Mitra</li>        
              
              <li>
                  <a href="{{ route('partners.profile.show') }}" class="block py-2.5 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500">
                      <i data-feather="trello" fill="#545a6d33"></i>
                      <span data-key="t-profile"> Profil Perusahaan</span>
                  </a>
              </li>
              

          </ul>
      </div>
      <!-- Sidebar -->
  </div>
</div>