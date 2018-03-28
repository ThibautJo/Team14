
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

  <table class="table">
    <thead>
      <tr>
        <th scope="col">Datum</th>
        <th scope="col">Naam</th>
        <th scope="col">Locatie</th>
        <th scope="col">Programma</th>
        <th scope="col">INgeschrevenen</th>
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
      echo "</tr>";
      }

       ?>
    </tbody>
  </table>

  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/wedstrijden/index?pagina=aanpassen'">Aanpassen</button>

</div>
