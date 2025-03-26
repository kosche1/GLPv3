<div id="loading-screen"
     x-data="{ isLoading: true }"
     x-init="
        window.addEventListener('load', () => {
            setTimeout(() => {
                isLoading = false;
            }, 300);
        });
     "
     x-show="isLoading"
     x-transition:leave="transition-opacity duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center bg-neutral-900">
    <div class="loader">
        <div class="loader-square"></div>
        <div class="loader-square"></div>
        <div class="loader-square"></div>
        <div class="loader-square"></div>
        <div class="loader-square"></div>
        <div class="loader-square"></div>
        <div class="loader-square"></div>
        <div class="loader-square"></div>
    </div>
</div>
