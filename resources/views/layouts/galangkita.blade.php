<x-shell :title="trim($__env->yieldContent('title', 'GalangKita'))" :flush="trim($__env->yieldContent('flush')) === '1'">
    @yield('content')
</x-shell>
