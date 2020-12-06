<?php

use SilverStripe\Admin\ModelAdmin;
use Toast\Model\Contact;

class ContactAdmin extends ModelAdmin
{
    private static $managed_models = [
        Contact::class
    ];

    private static $url_segment = 'contacts';

    private static $menu_title = 'Contacts';
}
