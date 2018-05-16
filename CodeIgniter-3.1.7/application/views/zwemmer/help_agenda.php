<?php

// +----------------------------------------------------------
// |    Trainingscentrum Wezenberg
// +----------------------------------------------------------
// |    Auteur: Jolien Lauwers      |       Helper:
// +----------------------------------------------------------
// |
// |    Helpmenu view
// |
// +----------------------------------------------------------
// |    Team 14
// +----------------------------------------------------------

/**
 * @file help_agenda.php
 * 
 * View waarin de gebruikersondersteuning wordt weergegeven.
 */

?>
<div class="d-flex flex-column">
    
        <div class="d-flex"><h4>Veelgestelde vragen</h4></div>
        <br />

        <div>
            <h6>1. Waarvoor kan ik de agenda-tool gebruiken?</h6>
            <p>Je persoonlijke agenda geeft een weekoverzicht weer met alle activiteiten en supplementen die door jouw trainer werden ingepland. Je vindt hier dus een gemakkelijk overzicht van beide!</p>
        </div>
        
        <div>
            <h6>2. Kan ik zelf activiteiten of supplementen inplannen?</h6>
            <p>Nee, activeiten én supplementen worden beide ingepland door jouw trainer. Je kan zelf geen elementen toevoegen aan je persoonlijke agenda.</p>
        </div>
        
        <div>
            <h6>3. Is het mogelijk om vorige activiteiten en supplementen te bekijken?</h6>
            <p>Ja, via de pijltjes rechtsboven de agenda kan je in het verleden of in de toekomst de verschillende blokjes terugvinden.</p>
        </div>
        
        <div>
            <h6>4. Kan ik wat meer informatie krijgen over bepaalde activiteiten of supplementen?</h6>
            <p>Ja, indien er op een van de blokjes geklikt wordt, kunnen er meer details worden weergegeven indien je trainer deze heeft aangevuld.</p>
        </div>
        
        <div>
            <h6>5. Wie kan mijn persoonlijke agenda zien?</h6>
            <p>Je agenda wordt beheerd door je trainer, dus je activiteiten en supplementen kunnen enkel door jullie twee bekeken worden. Je kan geen agenda's van andere zwemmers raadplegen.</p>
        </div>

        <br />
        <br />
        <div><h4>Om je verder te helpen bij het raadplegen van je persoonlijke agenda, is hieronder een voorbeeld voorzien.</h4></div>
        <br />

    <div class="d-flex flex-lg-row flex-column">
        <div class="d-flex flex-row">

            <div class="p-2"><?php echo toonAfbeelding('cirkel_1.png'); ?></div>
            <div class="p-2"><p>De blokjes op de agenda geven aan welke activiteiten er op die datum/tijdstip plaatsvinden. 
                Bij aanklikken van deze activiteit-blokjes zal er meer gedetailleerde informatie getoond worden.</p></div>

        </div>

        <div class="d-flex flex-row">

            <div class="p-2"><?php echo toonAfbeelding('cirkel_2.png'); ?></div>
            <div class="p-2"><p>De blokjes in de Supplementen-balk geven aan welke medicatie of supplementen op die datum ingenomen dienen te worden.
            Bij aanklikken van deze supplement-blokjes zal er meer gedetailleerde informatie getoond worden.</p></div>

        </div>

        <div class="d-flex flex-row">

            <div class="p-2"><?php echo toonAfbeelding('cirkel_3.png'); ?></div>
            <div class="p-2"><p>Via de pijltjes kan er tussen de verschillende weken genavigeerd worden. 
        Om gemakkelijk naar de huidige datum terug te keren kan er op de knop 'Vandaag' geklikt worden.</p></div>

        </div>
    </div>

        <div class="d-flex p-2 float-left"><?php echo toonAfbeelding('help_agenda_afbeelding.png', 'width="100%" height="100%"'); ?></div>

</div>