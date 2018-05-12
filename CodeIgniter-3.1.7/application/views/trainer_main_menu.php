
<!-- Profielfoto en naam in de verticale menu -->

<div id="account-foto" class="d-flex align-items-center flex-column justify-content-center">
    <div>
        <?php
        echo toonAfbeelding('Profiel/Avatar_' . $persoonAangemeld->voornaam . '_' . $persoonAangemeld->achternaam . '.jpg', 'id="avatar" class="shadow img-circle"');
        ?>
    </div>
    <p class="text-white pt-2 mb-0"><?php echo $persoonAangemeld->voornaam . ' ' . $persoonAangemeld->achternaam ?></p>
</div>

<!-- Links in de verticale menu -->

<ul class="nav nav-pills flex-column" id="sidenav">
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#profielSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="profielSubMenu"><i class="material-icons md-18 mr-3">person</i><span class="menu-text">Profiel</span></a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="profielSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="<?php // echo site_url('/Trainer/Profiel') ?>">Profiel</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="<?php // echo site_url('/Trainer/Profiel/Aanpassen') ?>">Profiel aanpassen</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#agendaSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="agendaSubMenu"><i class="material-icons md-18 mr-3">event_note</i><span class="menu-text">Agenda</span></a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="agendaSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Agenda/index') ?>">Agenda</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Agenda/index') ?>">Agenda beheren</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="<?php echo site_url('/Trainer/Supplement') ?>"><i class="fas fa-pills md-18 mr-3"></i><span class="menu-text">Supplementen</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#wedstrijdSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="wedstrijdSubMenu"><i class="material-icons md-18 mr-3">flag</i><span class="menu-text">Wedstrijden</span></a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="wedstrijdSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Wedstrijden/index?pagina=weergaven') ?>">Wedstrijden</a>
                </li>
                <li>
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Wedstrijden/index?pagina=aanpassen') ?>">Wedstrijden beheren</a>
                </li>
                <li>
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=weergaven') ?>">Wedstrijdresultaten</a>
                </li>
                <li>
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/WedstrijdResultaten/index?pagina=aanpassen') ?>">Wedstrijdresultaten beheren</a>
                </li>
                <li>
                    <a class="nav-link1" href="<?php // echo site_url('/Trainer/Inschrijvingen') ?>">Inschrijvingen</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="<?php // echo site_url('/Trainer/Inschrijvingen/aanpassen') ?>">Inschrijvingen beheren</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="#teamSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="teamSubMenu"><i class="material-icons md-18 mr-3">group</i><span class="menu-text">Team</span></a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="teamSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Team') ?>">Team</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Team/aanpassen') ?>">Team beheren</a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" href="#meldingenSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="meldingenSubMenu"><span class="d-flex align-items-center"><i class="material-icons md-18 mr-3">notifications</i><span class="menu-text">Meldingen</span></span>
            <span class="menu-text"><div id="melding-menu" class="img-circle d-flex align-items-center justify-content-center">2</div></span>
        </a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="meldingenSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Melding') ?>">Meldingen</a>
                </li>
                <li class="pb-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Melding/beheren') ?>">Meldingen beheren</a>
                </li>
            </ul>
        </div>        
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center" href="#startpaginaSubMenu" data-toggle="collapse" aria-expanded="false" aria-controls="startpaginaSubMenu"><span class="d-flex align-items-center"><i class="material-icons md-18 mr-3">public</i><span class="menu-text">Startpagina</span></span>
            <span class="menu-text"></span>
        </a>
        <div id="submenu" class="kleur">
            <ul class="collapse list-unstyled pl-4 submenu-links" id="startpaginaSubMenu" data-parent="#sidenav">
                <li class="pt-2">
                    <a class="nav-link1" href="<?php echo site_url('/Trainer/Startpagina') ?>">Startpagina beheren</a>
                </li>
            </ul>
        </div>        
    </li>
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="<?php echo site_url('/Welcome/meldAf') ?>"><i class="material-icons md-18 mr-3">exit_to_app</i><span class="menu-text">Afmelden</span></a>
    </li>
    <div id="menu-footer" class="position-absolute">
        <p class="text-center">&copy; Trainingscentrum Wezenberg</p>
    </div>
</ul>

<!-- Voetnoot in de verticale menu -->
