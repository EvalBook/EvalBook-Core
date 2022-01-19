/**
 * Handling loader.
 */
window.addEventListener('load', function() {
    const loaderContainer = document.querySelector('.loader-container');
    loaderContainer.style.display = 'none';

    /**
     * Starting loader on buttons steps clicks.
     * @type {NodeListOf<Element>}
     */
    const inputButtons = document.querySelectorAll('input[type="submit"]');
    if(inputButtons) {
        inputButtons.forEach(button => button.addEventListener('click', () => loaderContainer.style.display = 'flex'));
    }

    /**
     * Handle radio buttons labels click.
     * @type {NodeListOf<Element>}
     */
    const radios = document.querySelectorAll('input[type="radio"]');
    document.querySelectorAll('#prod, #dev').forEach(radioLabel => radioLabel.addEventListener('click', function() {
        (this.id === 'prod' ? radios[0] : radios[1]).checked = true;
    }));

});

