
<?php
// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Klaus Daems       |       Helper:
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

  <table class="table table-hover table-responsive">
    <thead>
      <tr>
        <th scope="col">Datum</th>
        <th scope="col">Naam</th>
        <th scope="col">Locatie</th>
        <th scope="col">Programma</th>
        <th scope="col">INgeschrevenen</th>
        <th scope="col">Acties</th>
        <th scope="col"></th>
      </tr>
    </thead>
    <tbody>
      <?php

      // var_dump($wedstrijden);

      foreach ($wedstrijden as $wedstrijd) {
        echo "<tr scope='row' id='". $wedstrijd->ID ."'>";
        echo "<td>" . date("d-m-Y", strtotime($wedstrijd->DatumStart)) . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>  <button type='button' class='btn btn-success' id='aanpassen".$wedstrijd->ID."' onclick='wedstrijdUpdate(this.id)' value='".$wedstrijd->ID."'>aanpassen</button></td>";
        echo "<td>  <button type='button' class='btn btn-danger' id='verwijder".$wedstrijd->ID."' onclick='wedstrijdVerwijder(this.id)' value='".$wedstrijd->ID."'>verwijder</button></td>";
        echo "</tr>";
      }

      ?>
    </tbody>
  </table>

  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/wedstrijden/index?pagina=weergaven'">Weergaven</button>
  <button type="button" class="btn btn-primary" onclick="wedstrijdToevoegen()" style="float:right;">Toevoegen</button>

  <!-- toegoegen -->
  <div class="popup-background"></div>

  <div class="popup-dialog" id="toevoegen">
    <div class="popup-header">
      <h3 class="popup-title">Wedstrijd toevoegen</h3>
      <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="popup-content">
      <form id="form-wedstrijd" action="#" method="post">
        <table>
          <tr>
            <td>
              <label for="titel-wedstrijd">Titel</label>
              <input type="text" name="titel-wedstrijd" id="titel-wedstrijd" required>
            </td>
            <td rowspan="4">
              <label for="programma-wedstrijd">Voeg een reeks toe:</label>
              <select id="afstand-wedstrijd">
                <?php
                //adding slag en afstand
                foreach ($afstanden as $afstand) {
                  echo "<option value='".$afstand->ID."'>".$afstand->Afstand."</option>";
                }
                ?>
              </select>
              <select id="slag-wedstrijd">
                <?php
                //adding slag en afstand
                foreach ($slagen as $slag) {
                  echo "<option value='".$slag->ID."'>".$slag->Slag."</option>";
                }
                ?>
              </select>
              <button type="button" class="btn btn-default" onclick="addReeks()" aria-label="Left Align" style="margin-left: 10px;">
                <span class="glyphicon glyphicon-align-left" aria-hidden="true">+</span>
              </button>
            </td>
          </tr>
          <tr>
            <td>
              <label for="datum-wedstrijd">Datum</label>
              <input type="date" name="datum-wedstrijdStart" id="datum-wedstrijdStart" required> <p style="display: inline; margin: 0 10px;"> tot </p>
              <input type="date" name="datum-wedstrijdEnd" id="datum-wedstrijdEnd" required>
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
    <div class="popup-footer">
      <button type="button" class="btn btn-primary" onclick="wedstrijdOpslaan()">Opslaan</button>
    </div>
  </div>


  <div class="popup-dialog" id="aanpassen">
    <div class="popup-header">
      <h3 class="popup-title">Wedstrijd toevoegen</h3>
      <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="popup-content">
      <p>content verwijderen</p>
    </div>
    <div class="popup-footer">
      <p>footer</p>
    </div>
  </div>

</div>
