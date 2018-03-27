
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
        echo "<tr scope='row'>";
        echo "<td>" . date("d-m-Y", strtotime($wedstrijd->DatumStart)) . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>" . $wedstrijd->Naam . "</td>";
        echo "<td>  <button type='button' class='btn btn-success' onclick=''>Aanpassen</button></td>";
        echo "<td>  <button type='button' class='btn btn-danger' onclick=''>Verwijder</button></td>";
        echo "</tr>";
      }

      ?>
    </tbody>
  </table>

  <button type="button" class="btn btn-primary" onclick="window.location.replace('../../../Trainer/wedstrijden/index/weergaven') ">Weergaven</button>
  <button type="button" class="btn btn-primary" onclick="wedstrijdToevoegen()" style="float:right;">Toevoegen</button>

  <!-- toegoegen -->
  <div class="popup-background"></div>
  <div class="popup-dialog">
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
              <input type="text" name="titel-wedstrijd" id="titel-wedstrijd" >
            </td>
            <td rowspan="4">
              <label for="programma-wedstrijd">Voeg een reeks toe:</label>
              <?php
                //adding the inputs
               ?>
            </td>
          </tr>
          <tr>
            <td>
              <label for="datum-wedstrijd">Datum</label>
              <input type="date" name="datum-wedstrijd" id="datum-wedstrijd"> <p style="display: inline;"> tot </p>
              <input type="date" name="datum-wedstrijd" id="datum-wedstrijd">
            </td>
          </tr>
          <tr>
            <td>
              <label for="locatie-wedstrijd">Locatie</label>
              <input type="text" name="locatie-wedstrijd" id="locatie-wedstrijd" value="">
            </td>
          </tr>
          <tr>
            <td>
              <label for="programma-wedstrijd">programma</label>
              <input type="text" name="programma-wedstrijd" id="programma-wedstrijd" value="">
            </td>
          </tr>

        </table>

      </form>
    </div>
    <div class="popup-footer">
      <p>footer</p>
    </div>
  </div>

</div>
