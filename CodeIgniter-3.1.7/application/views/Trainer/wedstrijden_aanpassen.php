
<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Thibaut Joukes       |       Helper:
// +----------------------------------------------------------
// |
// |    Training home
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------
?>

<div id="wedstrijd">
  <h1><?php echo $maand; ?></h1>

  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Datum</th>
        <th scope="col">Naam</th>
        <th scope="col">Locatie</th>
        <th scope="col">Programma</th>
        <th scope="col">INgeschrevenen</th>
        <th scope="col"></th>
        <th scope="col"><button type='button' class='btn btn-warning btn-xs btn-round' data-toggle="modal" data-target="#wedstrijdToevoegen" id='' onclick="reeksenLeegmaken()" value=''><i class='fas fa-plus'></button></th>
      </tr>
    </thead>
    <tbody>
      <?php

      // var_dump($wedstrijden[0]);

      foreach ($wedstrijden as $wedstrijd) {
        echo "<tr scope='row' id='". $wedstrijd->id ."'>";
        echo "<td>" . date("d-m-Y", strtotime($wedstrijd->datumStart)) . "</td>";
        echo "<td>" . $wedstrijd->naam . "</td>";
        echo "<td>" . $wedstrijd->plaats . "</td>";
        echo "<td><a href='http://".$wedstrijd->programma."'>Open Programma</a></td>";
        echo "<td>";
        if ($wedstrijd->personen->namen) {
          foreach ($wedstrijd->personen->namen as $persoon) {
            echo $persoon;
          }
        }
        else {
          echo "...";
        }
        echo "</td>";
        echo "<td>  <button type='button' class='btn btn-success' id='aanpassen".$wedstrijd->id."' onclick='wedstrijdOpvragen(this.id)' value='".$wedstrijd->id."'><i class='fas fa-pencil-alt'></i></button></td>";
        echo "<td>  <button type='button' class='btn btn-danger' id='verwijder".$wedstrijd->id."' onclick='wedstrijdVerwijder(this.id)' value='".$wedstrijd->id."'><i class='fas fa-trash-alt'></i></button></td>";
        echo "</tr>";
      }

      ?>
    </tbody>
  </table>

  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/wedstrijden/index?pagina=weergaven'">Weergaven</button>


  <!-- Modal toevoegen -->
<div class="modal fade" id="wedstrijdToevoegen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="popup-title">Wedstrijd toevoegen</h3>
        <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-wedstrijd" action="#" method="post">
          <table>
            <tr>
              <td>
                <label for="titel-wedstrijd">Titel</label>
                <input type="text" name="titel-wedstrijd" id="titel-wedstrijd" required>
              </td>
              <td rowspan="4" class="reeksen">
                <label for="programma-wedstrijd">Voeg een reeks toe:</label>
                <select class="afstand-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($afstanden as $afstand) {
                    echo "<option value='".$afstand->id."'>".$afstand->afstand."</option>";
                  }
                  ?>
                </select>
                <select class="slag-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($slagen as $slag) {
                    echo "<option value='".$slag->id."'>".$slag->slag."</option>";
                  }
                  ?>
                </select>
                <button type="button" class="btn btn-default" onclick="reeksToevoegen('toevoegen')" aria-label="Left Align" style="margin-left: 10px;">
                  <span class="glyphicon glyphicon-align-left" aria-hidden="true">+</span>
                </button>
              </td>
            </tr>
            <tr>
              <td>
                <label for="datum-wedstrijd">Datum</label>
                <input type="date" name="datum-wedstrijdStart" id="datum-wedstrijdStart" required> <p style="display: inline; margin: 0 10px;"> tot </p>
                <input type="date" name="datum-wedstrijdStop" id="datum-wedstrijdStop" required>
              </td>
            </tr>
            <tr>
              <td>
                <label for="locatie-wedstrijd">Locatie</label>
                <input type="text" name="locatie-wedstrijd" id="locatie-wedstrijd" required>
              </td>
            </tr>
            <tr>
              <td>
                <label for="programma-wedstrijd">programma</label>
                <input type="text" name="programma-wedstrijd" id="programma-wedstrijd" required>
              </td>
            </tr>

          </table>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="wedstrijdOpslaan('toevoegen')">Opslaan</button>
      </div>
    </div>
  </div>
</div>

  <!-- Modal aanpassen -->
<div class="modal fade" id="wedstrijdAanpassen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="popup-title">Wedstrijd Aanpassen</h3>
        <button type="button" class="close" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-wedstrijd" action="#" method="post">
          <table>
            <tr>
              <td>
                <label for="titel-wedstrijd">Titel</label>
                <input type="text" name="titel-wedstrijd" id="titel-wedstrijd" required>
              </td>
              <td rowspan="4" class="reeksen">
                <label for="programma-wedstrijd">Voeg een reeks toe:</label>
                <select class="afstand-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($afstanden as $afstand) {
                    echo "<option value='".$afstand->id."'>".$afstand->afstand."</option>";
                  }
                  ?>
                </select>
                <select class="slag-wedstrijd">
                  <?php
                  //adding slag en afstand
                  foreach ($slagen as $slag) {
                    echo "<option value='".$slag->id."'>".$slag->slag."</option>";
                  }
                  ?>
                </select>
                <button type="button" class="btn btn-default" onclick="reeksToevoegen('aanpassen')" aria-label="Left Align" style="margin-left: 10px;">
                  <span class="glyphicon glyphicon-align-left" aria-hidden="true">+</span>
                </button>
              </td>
            </tr>
            <tr>
              <td>
                <label for="datum-wedstrijd">Datum</label>
                <input type="date" name="datum-wedstrijdStart" id="datum-wedstrijdStart" required> <p style="display: inline; margin: 0 10px;"> tot </p>
                <input type="date" name="datum-wedstrijdStop" id="datum-wedstrijdStop" required>
              </td>
            </tr>
            <tr>
              <td>
                <label for="locatie-wedstrijd">Locatie</label>
                <input type="text" name="locatie-wedstrijd" id="locatie-wedstrijd" required>
              </td>
            </tr>
            <tr>
              <td>
                <label for="programma-wedstrijd">programma</label>
                <input type="text" name="programma-wedstrijd" id="programma-wedstrijd" required>
              </td>
            </tr>

          </table>
          <input type="text" name="wedstrijdID" id="wedstrijdID" value="" hidden>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="wedstrijdOpslaan('aanpassen')">Opslaan</button>
      </div>
    </div>
  </div>
</div>


</div>
