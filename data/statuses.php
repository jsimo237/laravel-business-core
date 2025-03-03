<?php


use Kirago\BusinessCore\Enums\Statuses;

return [
    [
        "code" => Statuses::PENDING,
        "name" => "Crée",
        "color" => "#ffcf22",
        "icon" => "warning",
        "style" => [
            "label" => [
                "color" => "#000 !important;",
                "background-color" => "#ffcf22 !important;",
            ]
        ],
    ],

    [
        "code" => Statuses::ONGOING,
        "name" => "En Cours",
        "color" => "#ffcf22",
        "icon" => "warning",
        "style" => [
            "label" => [
                "color" => "#000 !important;",
                "background-color" => "#ffcf22 !important;",
            ]
        ],
    ],

    [
        "code" => Statuses::UNDER_PROCESS,
        "name" => "En Cours de Traitement",
        "color" => "#ffcf22",
        "icon" => "warning",
        "style" => [
            "label" => [
                "color" => "#000 !important;",
                "background-color" => "#ffcf22 !important;",
            ]
        ],
    ],
    [
        "code" => Statuses::UNPROCESSED,
        "name" => "Non Traitée",
        "color" => "#3490dc",
        "icon" => "primary",
        "style" => [
            "label" => [
                "color" => "#fff !important;",
                "background-color" => "#3490dc !important;",
            ]
        ],
    ],
    [
        "code" => Statuses::FAILED,
        "name" => "Echouée",
        "color" => "#e3342f",
        "icon" => "danger",
        "style" => [
            "label" => [
                "color" => "#fff !important;",
                "background-color" => "#e3342f !important;",
            ]
        ],
    ],
    [
        "code" => Statuses::APPROVED,
        "name" => "Approuvée",
        "color" => "#38c172",
        "icon" => "success",
        "style" => [
            "label" => [
                "color" => "#fff !important;",
                "background-color" => "#38c172 !important;",
            ]
        ],

    ],
    [
        "code" => Statuses::SUCCESSFUL,
        "name" => "Réussie",
        "color" => "#38c172",
        "icon" => "success",
        "style" => [
            "label" => [
                "color" => "#fff !important;",
                "background-color" => "#38c172 !important;",
            ]
        ],

    ],

    [
        "code" => Statuses::PENDING,
        "name" => "En Cours",
        "color" => "#ffcf22",
        "icon" => "warning",
        "style" => [
            "label" => [
                "color" => "#000 !important;",
                "background-color" => "#ffcf22 !important;",
            ]
        ],
    ],
];
