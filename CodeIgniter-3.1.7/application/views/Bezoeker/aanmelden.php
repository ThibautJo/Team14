<?php
$attributes = array('name' => 'mijnFormulier');
echo form_open('Welcome/controleerAanmelden', $attributes);
?>
<div class="modal show fade" id="aanmeldFormulier" tabindex="-1" role="dialog" aria-labelledby="aanmeldFormulier" aria-hidden="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div>
                <div id="backgroundAanmeldFormulier" class="position-absolute d-flex justify-content-center align-items-center text-white flex-column">
                    <div class="d-flex align-items-right flex-column">
                        <p class="lead mb-0 font-weight-light">Trainingscentrum</p>
                        <h1 class="font-weight-bold">Wezenberg</h1>
                    </div>
                </div>
            </div>
            <div id="modal-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Welkom terug!</h5> <!-- Modal titel -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <!-- Modal sluit knop ( X ) -->
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"> <!-- Modal inhoud -->
                    <p>
                        <div><?php echo form_label('E-mail:', 'email'); ?></div>
                        <div><?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30', 'class' => 'form-control')); ?></div>
                    </p>
                    <p>
                        <div><?php echo form_label('Wachtwoord:', 'wachtwoord'); ?></div>
                        <div><?php
                                    $data = array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'size' => '30', 'class' => 'form-control');
                                    echo form_password($data);
                                    ?></div>
                    </p>
                </div>
                <div class="modal-footer">
                    <?php echo form_submit('knop', 'Aanmelden', 'class="btn button-blue"'); ?>
                    <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- <p>Wachtwoord vergeten? <?php // echo anchor('/gebruiker/wachtwoordVergeten', "Wachtwoord vergeten");  ?></p> -->

