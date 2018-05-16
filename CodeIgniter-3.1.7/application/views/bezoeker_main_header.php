<?php
    /**
     * @file bezoeker_main_header.php
     * View waarmee de header en navigatiebalk op de homepagina worden weergegeven.
     */
?>

<!-- navigatie -->

<nav class="navbar navbar-expand-sm navbar-dark fixed-top">
    <div class="container">

        <!-- logo in navigatie -->

        <a class="navbar-brand font-weight-bold" href="#top">TCW</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- links in navigatie -->

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#top">Startpagina</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Nieuws">Nieuws</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Wedstrijden">Wedstrijden</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#Team">Team</a>
                </li>

                <!-- login knop -->
                <li class="nav-item">
                        <?php
                        if ($persoon == null) {
                            // niet aangemeld
                            echo "<button type='button' class='btn btn-outline-light' id='login-button' data-toggle='modal' data-target='#aanmeldFormulier'>Aanmelden</button>";
                        } else {
                            // aangemeld
                            echo divAnchor('Welcome/meldAf', 'Afmelden', 'class="btn btn-outline-light" id="login-button"');
                        }
                        ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
