<!-- footer -->

<footer>
    <div class="container pb-3 font-weight-light">
        <div class="text-center">
            <p>Trainingscentrum WEZENBERG</p>
            <p id="footer-follow">Volg ons op <a href="https://www.facebook.com/Trainingscentrum-Wezenberg-TCW-514839802012875/" target="_blank"><i class="fa fa-facebook-square"></i></a> facebook</p>
        </div>
        <hr>

        <!-- Navigatie-links in de voetnoot -->

        <div class="d-flex justify-content-center col-12 flex-column align-items-center">
            <div id="footer-info" class="col-12 d-flex justify-content-md-between text-center flex-lg-row flex-column mt-4">
                <span class="d-flex flex-sm-row flex-column justify-content-sm-center">
                    <span><b>Oefening voor:</b> Thomas More Geel &nbsp;&nbsp;|&nbsp;&nbsp;</span>
                    <span><b>Opdrachtgever:</b> Kristine Mangelschots</span>
                </span>
                <span class="d-flex justify-content-sm-center">
                    <span>Team 14: 
                        <?php

                        // Zorgt ervoor dat de auteur in de voetnoot wit is gedrukt

                        $i = 0;
                        foreach ($team as $value => $key) {
                            if ($key == 'true') {
                                echo '<span class="text-white">' . $value . '</span>';
                            }
                            else {
                                echo $value;
                            }

                            if ($i == count($team) - 1) {
                            }
                            else {
                                echo ', ';
                            }
                            $i++;
                        }

                        ?>
                    </span>
                </span>
            </div>
        </div>
    </div>
</footer>