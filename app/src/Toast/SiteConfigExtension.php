<?php


namespace Toast;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;


class SiteConfigExtension extends DataExtension
{
    private static $db = [
        'FacebookLink' => 'Varchar',
        'LinkedInLink' => 'Varchar',
        'FooterCopyright' => 'Varchar',
        'CompanyPhone' => 'Varchar'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Social', [
            TextField::create('FacebookLink', 'Facebook'),
            TextField::create('LinkedInLink', 'LinkedIn')
        ]);

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('FooterCopyright', 'Copyright text'),
            TextField::create('CompanyPhone', 'Company Phone')
        ]);
    }

}
