
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
      echo "<tr scope='row' id='". $wedstrijd->ID ."'>";
      echo "<td>" . date("d-m-Y", strtotime($wedstrijd->DatumStart)) . "</td>";
      echo "<td>" . $wedstrijd->Naam . "</td>";
      echo "<td>" . $wedstrijd->Plaats . "</td>";
      echo "<td><a href='http://".$wedstrijd->Programma."'>Open Programma</a></td>";
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
      echo "</tr>";
      }

       ?>
    </tbody>
  </table>

  <button type="button" class="btn btn-primary" onclick="document.location.href= site_url + '/Trainer/wedstrijden/index?pagina=aanpassen'">Aanpassen</button>

</div>
