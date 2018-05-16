<?php
/**
 * @mainpage Commentaar bij project Wezenberg
 * 
 * # Wat ?
 * Hier kan je onze Doxygen-commentaar bij het PHP-project <b>project Wezenberg</b>.
 * - Commentaar bij onze  model- en controller-klassen vind je onder menu <em>Klassen</em>.
 * - Commentaar bij onze view-bestanden vind je onder het menu <em>Bestanden</em>.
 * - Ook de originele commentaar geschreven bij het CodeIgniter-framework is opgenomen.
 *
 * # Wie ?
 * Dit project is geschreven en becommentarieerd door de leden van Team14 nl. Jolien Lauwers, Klaus Daems, Lise Van Eyck, Thibaut Joukes & Tom Nuyts.
 */
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo $titel ?></title>

        <!-- Stylesheets -->

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <?php echo pasStylesheetAan("bezoeker_eigenStijl.css"); ?>
        <?php echo pasStylesheetAan("scroll.css"); ?>
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script type="text/javascript">
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

    </head>

    <body id="top">

        <!-- Navigatie -->

        <?php echo $hoofding; ?>

        <!-- Achtergrond -->

        <div class="jumbotron jumbotron-fluid d-flex align-items-center position-relative">
            <div id="background" class="container text-white">

                <!-- Tekst die getoond wordt op de achtergrondafbeelding -->

                <div id="background-text">
                    <p class="lead mb-0 font-weight-light">Welkom bij</p>
                    <h2 class="font-weight-bold">Trainingscentrum Wezenberg</h2>
                </div>
                <div id="parallelogram"></div>

                <!-- Symbool dat aanduidt dat je kan scrollen -->

                <a href="#inhoud" id="scroll-symbol">
                    <div class="center-do-not-use position-absolute">
                        <div class="mouse">
                            <div class="wheel"></div>
                        </div>
                        <div>
                            <span class="arrow"></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Aanmeld formulier -->

        <?php echo $aanmeldFormulier; ?>

        <!-- Inhoud -->

        <main id="inhoud">

            <div class="container">
                <div class="text-center"><h3>Dit is een testproject van Thomas More Hogeschool Geel.</h3></div>
                <hr>
            </div>

            <!-- Nieuws sectie -->

            <div class="container" id="Nieuws">
                <h4>Nieuws</h4>

                <div class="row">
                    <?php
                    foreach ($startpaginaitems as $startpaginaitem) {
                        echo "\n<div id='" . $startpaginaitem->id . "'><div class='col-sm nieuwstitel'>" . ucfirst($startpaginaitem->titel) . "</div><div class='col-sm'>" .
                        ucfirst($startpaginaitem->inhoud) . "</div><br>\n";
                    }
                    ?>
                </div>

            </div>
            <hr>

            <!-- Wedstrijden sectie -->

            <div class="container" id="Wedstrijden">
                <h4>Wedstrijden</h4>

                <div class="row">
                    <div class="col-2 wedstrijdtitel">Datum</div>
                    <div class="col-sm wedstrijdtitel">Wedstrijd</div>
                    <div class="col-2 wedstrijdtitel">Locatie</div>
                </div>

                <?php
                // Geeft de laatste 5 wedstrijden weer
                $teller = 0;

                foreach ($wedstrijden as $wedstrijd) {

                    echo "\n<div class='row'><div class='col-2'>" . ucfirst(date("d-m-Y", strtotime($wedstrijd->datumStart))) . "</div><div class='col-sm'><a href='http://" . $wedstrijd->programma . "'>" .
                    ucfirst($wedstrijd->naam) . "</a></div><div class='col-2'>" . ucfirst($wedstrijd->plaats) . "</div></div>\n";
                    $teller++;

                    if ($teller == 5) {
                        break;
                    }
                }
                ?>

            </div>
            <hr>

            <!-- Team sectie -->

            <div class="container" id="Team">
                <h4>Ons team</h4>
                <br>

                <div class="row mx-auto">
                    <?php
                    foreach ($zwemmers as $zwemmer)
                        echo '<figure class="col text-center figure"><a class="mijnKlik" href="#' . $zwemmer->id . '">' . toonAfbeelding('Profiel/Avatar_' . $zwemmer->voornaam . "_" . $zwemmer->achternaam . '.jpg', 'class="figure-img rounded-circle" id="team-foto"')
                        . '</a><figcaption class="figure-caption">' . $zwemmer->voornaam . " " . $zwemmer->achternaam . '</figcaption></figure>'
                        ?> 
                </div>

            </div>
            <br>


        </main>

        <!-- Voetnoot -->

        <?php echo $voetnoot ?>

        <!-- Javascript scriptjes -->

        <script>

            $(document).ready(function () {

                //Script om de navigatie te veranderen bij het scrollen

                $(window).scroll(function () {
                    var scroll = $(window).scrollTop();
                    if (scroll > 54) {
                        $('nav').removeClass("navbar-dark");
                        $('nav').addClass("navbar-scrolling navbar-light");
                        $('.nav-link').addClass('text-darkblue');
                        $('#login-button').addClass('login-button-darkblue');
                        $('#login-button').removeClass('btn-outline-light');
                        $('.navbar-brand').addClass('text-darkblue');
                        $('.active').addClass('active-darkblue');
                    } else {
                        $('nav').removeClass("navbar-scrolling navbar-light");
                        $('nav').addClass("navbar-dark");
                        $('.nav-link').removeClass('text-darkblue');
                        $('#login-button').removeClass('login-button-darkblue');
                        $('#login-button').addClass('btn-outline-light');
                        $('.navbar-brand').removeClass('text-darkblue');
                        $('.active').removeClass('active-darkblue');
                    }
                });

                //Script om te scrollen naar een id

                $('a[href*=\\#]').on('click', function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: $(this.hash).offset().top}, 500);
                });

                $('#submit-login').click(function () {
                    $('#aanmeldFormulier').modal('show');
                });

                //Script om verschillende zwemmeromschrijvingen te tonen

                $("mijnKlik").on("click", function (e) {
                    e.PreventDefault;
                    var grabID = $(this).attr("href");
                    $('div' + grabID).toggleClass("hide");
                    $("div").not('div' + grabID).addClass("hide"); //hide all div except clicked one.
                });

            });

        </script>
    </body>

</html>
