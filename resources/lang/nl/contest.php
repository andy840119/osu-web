<?php

/**
 *    Copyright (c) ppy Pty Ltd <contact@ppy.sh>.
 *
 *    This file is part of osu!web. osu!web is distributed with the hope of
 *    attracting more community contributions to the core ecosystem of osu!.
 *
 *    osu!web is free software: you can redistribute it and/or modify
 *    it under the terms of the Affero GNU General Public License version 3
 *    as published by the Free Software Foundation.
 *
 *    osu!web is distributed WITHOUT ANY WARRANTY; without even the implied
 *    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *    See the GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with osu!web.  If not, see <http://www.gnu.org/licenses/>.
 */

return [
    'header' => [
        'small' => 'Concurreer op meer manieren dan enkel het klikken van cirkels.',
        'large' => 'Community Wedstrijden',
    ],

    'index' => [
        'nav_title' => 'lijst',
    ],

    'voting' => [
        'over' => 'Je kan niet meer stemmen in deze wedstrijd',
        'login_required' => 'Log in om te kunnen stemmen.',

        'best_of' => [
            'none_played' => "Het lijkt erop dat je geen van de beatmaps in deze wedstrijd hebt gespeeld!",
        ],

        'button' => [
            'add' => 'Stem',
            'remove' => 'Verwijder stem',
            'used_up' => 'Je hebt al je stemmen opgebruikt',
        ],
    ],
    'entry' => [
        '_' => 'inzending',
        'login_required' => 'Log in om aan de wedstrijd mee te doen.',
        'silenced_or_restricted' => 'Je kan niet meedoen aan wedstrijden als je restricted of silenced bent.',
        'preparation' => 'We zijn nog bezig met de voorbereidingen van deze wedstrijd. Heb nog even geduld alsjeblieft!',
        'over' => 'Bedankt voor de inzendingen! Inzendingen zijn gesloten voor deze wedstrijd en de stembus gaan binnenkort open.',
        'limit_reached' => 'Je hebt de limiet voor inschrijvingen bereikt',
        'drop_here' => 'Sleep je inzending hier',
        'download' => 'Download .osz',
        'wrong_type' => [
            'art' => 'Alleen .jpg en .png bestanden worden geaccepteerd voor deze wedstrijd.',
            'beatmap' => 'Alleen .osu bestanden worden geaccepteerd voor deze wedstrijd.',
            'music' => 'Alleen .mp3 bestanden worden geaccepteerd voor deze wedstrijd.',
        ],
        'too_big' => 'Inzendingen voor deze wedstrijd kunnen maar :limit zijn.',
    ],
    'beatmaps' => [
        'download' => 'Download Inzending',
    ],
    'vote' => [
        'list' => 'stemmen',
        'count' => ':count stem|:count stemmen',
        'points' => ':count punt|:count punten',
    ],
    'dates' => [
        'ended' => 'Gesloten :date',

        'starts' => [
            '_' => 'Gestart :date',
            'soon' => 'binnenkort™',
        ],
    ],
    'states' => [
        'entry' => 'Inzendingen Open',
        'voting' => 'Stemmen Gestard',
        'results' => 'Resultaten uit',
    ],
];
