<?php


namespace Toast;

use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextField;

class HomePage extends Page
{

    private static $db = [
        'Hero_Header'       => 'Varchar',
        'Hero_Text'         => 'HTMLText',
        'Section1_Heading'  => 'Varchar',
        'Section1_Text'     => 'HTMLText',
        'Section1_Copy'     => 'HTMLText',
        'Section2_Heading'  => 'Varchar',
        'Section2_Text'     => 'HTMLText',
        'Section2_Copy'     => 'HTMLText',
        'Section3_Text'     => 'HTMLText',
        'Section3_Copy'     => 'HTMLText',
    ];

    private static $has_one = [
        'Section1_Image' => Image::class,
        'Section2_Image' => Image::class,
    ];

    private static $owns = [
        'Section1_Image',
        'Section2_Image'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        // Hero
        $fields->addFieldToTab(
            'Root.Hero',
            TextField::create('Hero_Header','Hero Header')
        );
        $fields->addFieldToTab(
            'Root.Hero',
            HTMLEditorField::create('Hero_Text','Hero Text')
        );

        // Section 1
        $fields->addFieldToTab('Root.Section',
            TextField::create(
                'Section1_Heading',
                'Section 1 Heading')
        );
        $fields->addFieldToTab('Root.Section',
            $section1Image = UploadField::create('Section1_Image','Section 1 Image'));

        $section1Image->setFolderName('Homepage-Images');
        $section1Image
            ->getValidator()
            ->setAllowedExtensions(['jpg','png','jpeg']);

        $fields->addFieldToTab('Root.Section',
            HTMLEditorField::create('Section1_Text','Section 1 Text'));
        $fields->addFieldToTab('Root.Section',
            HTMLEditorField::create('Section1_Copy','Section 1 Copy'));

        // Section 2
        $fields->addFieldToTab('Root.Section',
            TextField::create('Section2_Heading','Section 2 Heading'));
        $fields->addFieldToTab('Root.Section',
            $section2Image = UploadField::create('Section2_Image','Section 2 Image'));

        $section2Image->setFolderName('Homepage-Images');
        $section2Image
            ->getValidator()
            ->setAllowedExtensions(['jpg','png','jpeg']);

        $fields->addFieldToTab('Root.Section',
            HTMLEditorField::create('Section2_Text','Section 2 Text'));
        $fields->addFieldToTab('Root.Section',
            HTMLEditorField::create('Section2_Copy','Section 2 Copy'));

        // Section 3
        $fields->addFieldToTab('Root.Section',
            HTMLEditorField::create('Section3_Text','Section 3 Text'));
        $fields->addFieldToTab('Root.Section',
            HTMLEditorField::create('Section3_Copy','Section 3 Copy'));

        return $fields;
    }

/*    public function ContactForm()
    {
        FieldList::create(
            TextField::create('Name','')
                ->setAttribute('placeholder', 'Name'),
            EmailField::create('Email','')
                ->setAttribute('placeholder', 'Email'),
            TextField::create('Company','')
                ->setAttribute('placeholder', 'Company')
        );
    }*/


}
