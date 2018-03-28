<!-- footer -->

<footer>
    <div class="container pb-3 font-weight-light">
        <div class="text-center">
            <p>Trainingscentrum WEZENBERG</p>
            <p id="footer-follow">Volg ons op <a href="https://www.facebook.com/Trainingscentrum-Wezenberg-TCW-514839802012875/" target="_blank"><i class="fa fa-facebook-square"></i></a> facebook</p>
        </div>
        <hr>

        <!-- Navigatie-links in de voetnoot -->

        <div class="d-flex justify-content-center col-12">
            <div id="footer-links" class="col-lg-6 col-md-9 col-sm-12 col-12 d-flex justify-content-sm-between text-center flex-sm-row flex-column">
                <a href="#top">Startpagina</a>
                <a href="#Wedstrijden">Wedstrijden</a>
                <a href="#Team">Team</a>
                <?php
                if ($persoon == null) {

                    // niet aangemeld                                    
                    echo divAnchor('Welcome/meldAan', 'Aanmelden');
                    // aangemeld
                } else {
                    echo divAnchor('Welcome/meldAf', 'Afmelden');
                }
                ?>
            </div>
        </div>
    </div>
</footer>