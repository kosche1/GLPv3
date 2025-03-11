<div id="loading-screen" class="fixed inset-0 z-50 flex items-center justify-center bg-zinc-950 transition-opacity duration-300">
    <div class="loader">
        @for ($i = 1; $i <= 9; $i++)
            <div class="loader-square"></div>
        @endfor
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loadingScreen = document.getElementById('loading-screen');
        if (loadingScreen) {
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                }, 300);
            }, 500);
        }
    });
</script>