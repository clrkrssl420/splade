<div class="">
    @include('layouts.admin.sidebar')
    <!-- Page Content -->
    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        @include('layouts.admin.topbar')
        {{ $slot }}
    </main>
</div>
