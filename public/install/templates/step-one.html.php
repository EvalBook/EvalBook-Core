<section>
    <h2>Étape 1/3: <span>Choix du mode d'installation</span></h2>

    <form action="/index.php" method="POST">
        <div class="input-group">
            <!-- Standard installation mode, use in production -->
            <div>
                <input type="radio" id="prod" name="install-mode" value="prod" checked>
                <label for="prod">Mode production, pour utiliser dans votre école.</label>
            </div>

            <!-- Dev installation mode, used to contribute to EvalBook -->
            <div>
                <input type="radio" id="dev" name="install-mode" value="dev">
                <label for="prod">Mode développeur, pour contribuer à EvalBook</label>
            </div>
        </div>
        <div class="input-group">
            <input type="submit" class="btn" value="Suivant&nbsp;&raquo;" name="next">
        </div>
    </form>

</section>