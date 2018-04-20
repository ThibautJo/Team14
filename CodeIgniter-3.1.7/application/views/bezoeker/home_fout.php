<script>
    
    $(document).ready(function(){
        $('#aanmeldFormulier').modal('show');   
    
        $("#aanmeldFormulier").on('hidden.bs.modal', function () {
            alert('The modal is now hidden.');
            // redirect naar meldAan hier (?)
    });
});
</script>

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
                    <p>De combinatie van het email-adres en wachtwoord is foutief! Probeer opnieuw.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn button-blue" data-dismiss="modal">Sluiten</button> <!-- Modal sluit knop -->
                </div>
            </div>
        </div>
    </div>
</div>
