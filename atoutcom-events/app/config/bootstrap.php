<?php

MvcConfiguration::set(array(
    'Debug' => false
));

MvcConfiguration::append(array(
    'AdminPages' => array(
        'events' => array(
            'intervenants',
            'participants',
            'sponsor',
            'facture_participant',
            'facture_globale'
        )
    )
));

