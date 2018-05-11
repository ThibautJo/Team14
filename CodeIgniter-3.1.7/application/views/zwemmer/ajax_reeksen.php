<?php

foreach ($reeksen as $reeks) {
    echo '<div>';
    echo form_checkbox('reeksen', $reeks->reeksPerWedstrijd, FALSE);
    echo form_label($reeks->afstand . ' ' . $reeks->slag, 'reeks');
    echo '</div>';
}
?>