
<!-- Profielfoto en naam in de verticale menu -->

<div id="account-foto" class="d-flex align-items-center flex-column justify-content-center">
    <div>
        <?php
        echo toonAfbeelding('Profiel/Avatar_Pieter Timmers.png', 'id="avatar" class="shadow img-circle"');
        ?>
    </div>
    <p class="text-white pt-2 mb-0">Pieter Timmers</p>
</div>

<!-- Links in de verticale menu -->

<ul class="nav nav-pills flex-column" id="sidenav">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#profielSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="profielSubMenu"><i class="material-icons md-18 mr-3">person</i><span class="menu-text">Profiel</span></a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="profielSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="#">Profiel</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="#">Aanpassen</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="<?php echo site_url('/Zwemmer/Agenda') ?>"><i class="material-icons md-18 mr-3">event_note</i><span class="menu-text">Agenda</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#wedstrijdSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="wedstrijdSubMenu"><i class="material-icons md-18 mr-3">flag</i><span class="menu-text">Wedstrijden</span></a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="wedstrijdSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="#">Wedstrijden</a>
                </li>
                <li>
                    <a class="nav-link1" href="#">Wedstrijdresultaten</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="#">Inschrijven</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="<?php echo site_url('/Trainer/Team') ?>"><i class="material-icons md-18 mr-3">group</i><span class="menu-text">Team</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" href="#"><span class="d-flex align-items-center"><i class="material-icons md-18 mr-3">notifications</i><span class="menu-text">Meldingen</span></span>
            <span class="menu-text"><div id="melding-menu" class="img-circle d-flex align-items-center justify-content-center">2</div></span>

        </a>
        <div id="melding-menu-2" class="img-circle d-flex align-items-center justify-content-center">2</div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="<?php echo site_url('/Welcome/meldAf') ?>"><i class="material-icons md-18 mr-3">exit_to_app</i><span class="menu-text">Afmelden</span></a>
    </li>
</ul>

<!-- Voetnoot in de verticale menu -->

<div id="menu-footer" class="position-absolute">
    <p class="text-center">&copy; Trainingscentrum Wezenberg</p>
</div>
