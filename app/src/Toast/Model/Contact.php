<?php

namespace Toast\Model;

use SilverStripe\ORM\DataObject;

class Contact extends DataObject
{
    private static $db = [
        'Name' => 'Varchar',
        'Email' => 'Varchar',
        'Company' => 'Varchar',

    ];

    private static $searchable_fields = [
        'Name',
        'Email',
        'Company'
    ];

    private static $summary_fields = [
        'Name',
        'Email',
        'Company',
        'Created'
    ];
}
