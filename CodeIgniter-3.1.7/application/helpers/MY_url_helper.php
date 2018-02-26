<?php

function divAnchor($uri = '', $title = '', $attributes = '') {
    return "<div>" . anchor($uri, $title, $attributes) . "</div>\n";
}

function smallDivAnchor($uri = '', $title = '', $attributes = '') {
    return "<div style='margin-top: 4px'>" .
            anchor($uri, $title, $attributes) . "</div>\n";
}

?>
