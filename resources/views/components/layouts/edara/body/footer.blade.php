    <script>
                // Mobile menu toggle
                const mobileMenuButton = document.getElementById('mobileMenuButton');
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.querySelector('main');

                mobileMenuButton.addEventListener('click', () => {
                    sidebar.classList.toggle('translate-x-full');
                });

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', (e) => {
                    if (window.innerWidth < 768) { // Only on mobile
                        if (!sidebar.contains(e.target) && !mobileMenuButton.contains(e.target)) {
                            sidebar.classList.add('translate-x-full');
                        }
                    }
                });

                // Handle window resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 768) {
                        sidebar.classList.remove('translate-x-full');
                    } else {
                        sidebar.classList.add('translate-x-full');
                    }
                });
    </script>
</body>
@livewireScripts
</html> 