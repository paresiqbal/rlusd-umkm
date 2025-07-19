@php
    $urlPath = explode('/', request()->path());
@endphp

<div id="dashboard-sidebar" class="fixed bottom-0 z-20 h-screen border-r vertical-menu left-0 top-[70px] bg-slate-50 border-gray-50 w-64">
        
  <div data-simplebar class="h-full">
      <!--- Sidemenu -->
      <div class="metismenu pb-10 pt-2.5" id="sidebar-menu">
          <!-- Left Menu Start -->
          <ul id="side-menu">
              <li class="px-5 py-3 text-xs font-bold text-gray-500 cursor-default leading-[18px] block" data-key="t-menu">Menu</li>

              <li>
                  <a href="{{ route('partners.dashboard') }}" class="flex items-center gap-4 py-2 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500" data-linkname="partners-dashboard">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    <span data-key="t-dashboard"> Dashboard</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('partners.jobs.index') }}" class="flex items-center gap-4 py-2 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500"  data-linkname="partners-jobs">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg>
                    <span data-key="t-jobs"> Lowongan</span>
                  </a>
              </li>

              <li>
                  <a href="{{ route('partners.candidates.index') }}" class="flex items-center gap-4 py-2 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500"  data-linkname="partners-candidates">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4" /><path d="M15 19l2 2l4 -4" /></svg>
                      <span data-key="t-candidates"> Kandidat</span>
                  </a>
              </li>
              
              <li class="px-5 py-3 text-xs font-bold text-gray-500 cursor-default leading-[18px] block" data-key="t-mitra">Mitra</li>        
              
              <li>
                  <a href="{{ route('partners.profile.show') }}" class="flex items-center gap-4 py-2 px-6 text-sm font-medium text-gray-950 transition-all duration-150 ease-linear hover:text-violet-500"  data-linkname="partners-profiles">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-building-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21h9" /><path d="M9 8h1" /><path d="M9 12h1" /><path d="M9 16h1" /><path d="M14 8h1" /><path d="M14 12h1" /><path d="M5 21v-16c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h10c.53 0 1.039 .211 1.414 .586c.375 .375 .586 .884 .586 1.414v7" /><path d="M16 18c0 .53 .211 1.039 .586 1.414c.375 .375 .884 .586 1.414 .586c.53 0 1.039 -.211 1.414 -.586c.375 -.375 .586 -.884 .586 -1.414c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414z" /><path d="M18 14.5v1.5" /><path d="M18 20v1.5" /><path d="M21.032 16.25l-1.299 .75" /><path d="M16.27 19l-1.3 .75" /><path d="M14.97 16.25l1.3 .75" /><path d="M19.733 19l1.3 .75" /></svg>
                      <span data-key="t-profile"> Profil Perusahaan</span>
                  </a>
              </li>
              

          </ul>
      </div>
      <!-- Sidebar -->
  </div>
</div>