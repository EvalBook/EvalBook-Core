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
     * Handle radio buttons labels clicks and tooltips hovering labels on step 1.
     */
    const prodLabel = document.querySelector('#prod');
    const devLabel = document.querySelector('#dev');

    if(prodLabel && devLabel) {
        const radios = document.querySelectorAll('input[type="radio"]');
        const prodTooltip = new Tooltip(`
            <p class="info"><strong>Mode production: </strong></p>
            <p class="info">
                &#9432; Utilisez ce mode si vous souhaitez utiliser EvalBook dans votre établissement
            </p>
            <ul class="info">
                <li>Installe toutes les dépendances automatiquement</li>
                <li>Supprime le dossier d'installation pour des raisons de sécurité</li>
                <li>Crée votre base de données</li>
            </ul>
        `);

        const devTooltip = new Tooltip(`
            <p class="info"><strong>Mode développement: </strong></p>
            <p class="info">
                &#9432; Utilisez ce mode si vous souhaitez contribuer à EvalBook
            </p>
            <ul class="info">
                <li>Utilise vos installations de Composer et de NPM/Yarn</li>
                <li>Ne supprime pas le dossier d'installation</li>
                <li>Peuple la base de données avec des données de tests</li>
                <li>Crée votre fichier <em>.env.local</em></li>
            </ul>
        `);

        if(radios) {
            [prodLabel, devLabel].forEach(radioLabel => radioLabel.addEventListener('click', function () {
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
    }

});

