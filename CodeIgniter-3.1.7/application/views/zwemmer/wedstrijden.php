<?php
/**
 * @file wedstrijden.php
 *
 * View waarin de gegevens van wedstrijden worden weergegeven
 * en waar een zwemmer zich kan inschrijven voor een wedstrijd
 */
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Thibaut Joukes       |       Helper:
// +----------------------------------------------------------
// |
// |    Wedstrijden
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
$attributenFormulier = array('id' => 'mijnFormulier',
    'data-toggle' => 'validator',
    'role' => 'form');

$maandKey = null;
$maanden = array(
    0 => "Alle wedstrijden",
    1 => "januari",
    2 => "februari",
    3 => "maart",
    4 => "april",
    5 => "mei",
    6 => "juni",
    7 => "juli",
    8 => "augustus",
    9 => "september",
    10 => "oktober",
    11 => "november",
    12 => "december"
);
?>

<div id="wedstrijd">
    <h1 style="display: inline;"><?php
        if ($maand == 0) {
            echo "Alle wedstrijden";
        } else {
            echo $maanden[$maand];
        }
        ?></h1>
    <form action="#" method="post" style="display: inline-block; margin: 10px;">
        <select id="datumSelected">
            <?php
            foreach ($maanden as $key => $value) {
                if (strtolower($value) == strtolower($maanden[$maand])) {
                    echo "<option value='" . $key . "' selected>" . $value . "</option>";
                    $maandKey = $key;
                } else {
                    echo "<option value='" . $key . "'>" . $value . "</option>";
                }
            }
            ?>
        </select>
        <label>Jaar:</label>
        <a href="<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=' . $maandKey . '&jaar=' . $jaar . '&actie=vorige'); ?>" style="font-weight: bold;"> < </a>
<?php echo $jaar; ?>
        <a href="<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=' . $maandKey . '&jaar=' . $jaar . '&actie=volgende'); ?>" style="font-weight: bold;"> > </a>
    </form>

    <?php
    $template = array(
        'table_open' => '<table class="table">'
    );
    $this->table->set_template($template);

    $this->table->set_heading(array('data' => 'Datum', 'scope' => 'col'), array('data' => 'Naam', 'scope' => 'col'), array('data' => 'Locatie', 'scope' => 'col'), array('data' => 'Programma', 'scope' => 'col'), array('data' => 'Ingeschrevenen', 'scope' => 'col'), array('data' => '', 'scope' => 'col'));

    $this->table->add_row();

    // var_dump($wedstrijden);

    foreach ($wedstrijden as $wedstrijd) {
        echo "<tr scope='row' id='" . $wedstrijd->id . "'>";
        if ($wedstrijd->personen->namen) {
            foreach ($wedstrijd->personen->namen as $persoon) {
                $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), $wedstrijd->naam, $wedstrijd->plaats, array('data' => "Open Programma", 'href' => 'http://' . $wedstrijd->programma . ''), $persoon, '<button type="button" class="btn btn-warning inschrijven" id="inschrijven' . $wedstrijd->id . '" value="' . $wedstrijd->id . '" data-toggle="modal" data-target="#inschrijvenWedstrijd"><i class="fas fa-plus-square"></i></button>');
            }
        } else {
            $this->table->add_row(date("d-m-Y", strtotime($wedstrijd->datumStart)), $wedstrijd->naam, $wedstrijd->plaats, array('data' => "Open Programma", 'href' => 'http://' . $wedstrijd->programma . ''), '...', '<button type="button" class="btn btn-warning inschrijven" id="inschrijven' . $wedstrijd->id . '" value="' . $wedstrijd->id . '" data-toggle="modal" data-target="#inschrijvenWedstrijd"><i class="fas fa-plus-square"></i></button>');
        }
        echo "</tr>";
    }
    echo $this->table->generate();
    ?>

    <!-- Inschrijven wedstrijd -->
    <div class="modal fade" id="inschrijvenWedstrijd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Inschrijven wedstrijd</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    echo form_open('', $attributenFormulier);
                    ?>                
                    <div class="form-group">
                        <p><div id="reeksen"></div></p>
                        <?php echo form_label("Vak is leeg!", 'naam', array("id" => "reeksen-fout", "class" => "fout", "hidden" => "hidden")); ?>
                        <div class="invalid-feedback">
                            Vul dit veld in.
                        </div>
                    </div>

<?php echo form_close(); ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-primary" data-dismiss="modal">Annuleren</button>
                    <button type="button" class="btn button-blue" onclick="inschrijvingOpslaan()">Inschrijven</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">

    $('#datumSelected').on('change', function () {
        datumSelect();
    });

    function datumSelect() {
        switch ($("#datumSelected").val()) {
            case "0":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=0&jaar=' . $jaar); ?>';
                break;
            case "1":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=1&jaar=' . $jaar); ?>';
                break;
            case "2":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=2&jaar=' . $jaar); ?>';
                break;
            case "3":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=3&jaar=' . $jaar); ?>';
                break;
            case "4":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=4&jaar=' . $jaar); ?>';
                break;
            case "5":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=5&jaar=' . $jaar); ?>';
                break;
            case "6":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=6&jaar=' . $jaar); ?>';
                break;
            case "7":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=7&jaar=' . $jaar); ?>';
                break;
            case "8":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=8&jaar=' . $jaar); ?>';
                break;
            case "9":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=9&jaar=' . $jaar); ?>';
                break;
            case "10":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=10&jaar=' . $jaar); ?>';
                break;
            case "11":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=11&jaar=' . $jaar); ?>';
                break;
            case "12":
                window.location.href = '<?php echo site_url('/Zwemmer/Wedstrijden/index?pagina=weergaven&maand=12&jaar=' . $jaar); ?>';
                break;
            default:
                break;
        }
    }

    function haalReeksenOp(id)
    {
        $.ajax({type: "GET",
            url: site_url + "/Zwemmer/Wedstrijden/reeksen",
            data: {id: id},
            success: function (result) {
                $("#reeksen").html(result);
                $('#inschrijvenWedstrijd').modal('show');
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX -- \n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {

        $(".inschrijven").click(function (e) {
            e.preventDefault();
            var id = $(this).val();
            haalReeksenOp(id);
        });

    });
</script>
