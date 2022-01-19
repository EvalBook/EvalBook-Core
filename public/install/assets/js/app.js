
window.addEventListener('load', function() {
    const loaderContainer = document.querySelector('.loader-container');
    //loaderContainer.style.display = 'none';

    const inputButtons = document.querySelectorAll('input[type="submit"]');
    if(inputButtons) {
        inputButtons.forEach(button => button.addEventListener('click', () => loaderContainer.style.display = 'flex'));
    }
});
