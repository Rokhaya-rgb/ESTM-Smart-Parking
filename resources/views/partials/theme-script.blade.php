{{-- Thème clair / sombre : appliqué avant l'affichage pour éviter un flash, choix mémorisé dans le navigateur --}}
<script>
    (function () {
        var root = document.documentElement;
        var key = 'parking-theme';
        var theme = 'dark';
        try {
            var saved = localStorage.getItem(key);
            if (saved === 'light' || saved === 'dark') theme = saved;
        } catch (e) {}
        root.setAttribute('data-theme', theme);

        document.addEventListener('click', function (event) {
            if (!event.target.closest('[data-theme-toggle]')) return;
            theme = root.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            root.setAttribute('data-theme', theme);
            try { localStorage.setItem(key, theme); } catch (e) {}
        });
    })();
</script>
