<nav class="bg-white mt-4 relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start dark:bg-slate-900" navbar-main navbar-scroll="false">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
      <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
        <div class="flex items-center md:pr-4">
          <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
            <h6 class="mb-0 font-bold text-slate-850 capitalize dark:text-white">{{ $header }}</h6>
          </div>
        </div>
        <div class="flex md:ml-auto md:pr-4">
          @php
            use Carbon\Carbon;
            $current_time = Carbon::now()->format('M-d-Y H:i');
          @endphp
            <h6 class="mb-0 text-slate-850 capitalize dark:text-white">{{ $current_time }}</h6>
        </div>
        <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
          <li class="flex items-center pl-4 xl:hidden">
            <a href="javascript:;" class="block p-0 text-sm text-slate-850 transition-all ease-nav-brand" sidenav-trigger>
              <div class="w-4.5 overflow-hidden">
                <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-slate-850 transition-all dark:bg-white"></i>
                <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-slate-850 transition-all dark:bg-white"></i>
                <i class="ease relative block h-0.5 rounded-sm bg-slate-850 transition-all dark:bg-white"></i>
              </div>
            </a>
          </li>
        </ul>
      </div>
    </div>
</nav>