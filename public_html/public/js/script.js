const toggleButton = document.getElementById('toggle-navbar');
const hiddenNavbar = document.getElementById('hidden-navbar');

toggleButton.addEventListener('click', () => {
    hiddenNavbar.classList.toggle('-translate-x-full');
});