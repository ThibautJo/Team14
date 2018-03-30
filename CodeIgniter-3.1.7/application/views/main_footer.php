<span class="d-flex flex-sm-row flex-column justify-content-sm-center">
    <span><b>Oefening voor:</b> Thomas More Geel &nbsp;&nbsp;|&nbsp;&nbsp;</span> 
    <span><b>Opdrachtgever:</b> Kristine Mangelschots</span>
</span>
<span class="d-flex justify-content-sm-center">
    <span>Team 14: 
        <?php
        
        // Zorgt ervoor dat de auteur in de voetnoot vet is gedrukt
        
        $i = 0;
        foreach ($team as $value => $key) {
            if ($key == 'true') {
                echo '<b>' . $value . '</b>';
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