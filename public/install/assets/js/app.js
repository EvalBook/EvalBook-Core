import {Tooltip} from "./components/Tooltip.js";

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
        inputButtons.forEach(button => button.addEventListener('click', () => {
            if(button.id !== 'database-configuration') {
                loaderContainer.style.display = 'flex'
            }
            else {
                const form = document.querySelector('form');
                if(form.checkValidity()) {
                    loaderContainer.style.display = 'flex';
                }
            }
        }));
    }

    /**
     * Handle radio buttons labels click.
     */
    const prodLabel = document.querySelector('#prod');
    const devLabel = document.querySelector('#dev');
    const radios = document.querySelectorAll('input[type="radio"]');

    const prodTooltip = new Tooltip(`
        Hello World from PROD
    `);

    const devTooltip = new Tooltip(`
        <p class="info">
            Utilise votre installation de composer et npm, ne supprime pas le dossier /install, et peuple la base de données avec des données de test
        </p>
    `);

    if(prodLabel && devLabel && radios) {
        [prodLabel, devLabel].forEach(radioLabel => radioLabel.addEventListener('click', function() {
            (this.id === 'prod' ? radios[0] : radios[1]).checked = true;
        }));
    }

    /**
     * Initialize tooltips.
     */
    prodLabel.addEventListener('mouseenter', (e) => prodTooltip.show(e));
    prodLabel.addEventListener('mouseleave', () => prodTooltip.hide());

    devLabel.addEventListener('mouseenter', (e) => devTooltip.show(e));
    devLabel.addEventListener('mouseleave', () => devTooltip.hide());

});

