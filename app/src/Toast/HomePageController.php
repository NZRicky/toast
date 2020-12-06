<?php


namespace Toast;

use PageController;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Environment;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use Toast\Model\Contact;

class HomePageController extends PageController
{
    private static $allowed_actions = [
        'ContactForm'
    ];

    /**
     * Contact form
     * @return Form
     */
    public function ContactForm()
    {
        $contactForm = Form::create(
            $this,
            'ContactForm',
            FieldList::create(
                TextField::create('Name','Name'),
                EmailField::create('Email', 'Email'),
                TextField::create('Company', 'Company')
            ),
            FieldList::create(
                FormAction::create('handleContactForm', 'Submit')
                    ->setUseButtonTag(true)
            )
        );

        $required = new RequiredFields([
            'Name', 'Email'
        ]);

        $contactForm->setValidator($required);

        // debug only, can be removed in production
        $contactForm->setAttribute('novalidate', true);

        $contactForm->setTemplate('Form\\ContactForm');

        return $contactForm;
    }

    /**
     * contact form process
     *
     * @param $data
     * @param Form $form
     * @return mixed
     */
    public function handleContactForm($data, $form)
    {
        $name = $data['Name'];
        $email = $data['Email'];
        $company = $data['Company'];

        try {
            $contact = Contact::create();
            $contact->Name = $name;
            $contact->Email = $email;
            $contact->Company = $company;
            $contact->write();

            // send notification email to admin
            $email = Email::create()
                ->setHTMLTemplate('Email\\NotificationEmail')
                ->setData([
                    'Name' => $name,
                    'Email' => $email,
                    'Company' => $company
                ])
                ->setFrom('noreply@email.com')
                ->setTo(Environment::getEnv('ADMIN_EMAIL'))
                ->setSubject('Contact form submission data.');

            if (!$email->send()) {
                throw new \Exception('Unable to send notification email');
            }

            $form->sessionMessage('Thanks for your message.', 'good');
            return $this->redirectBack();
        } catch (\Exception $ex) {
            // todo: log error?
            die($ex->getMessage());
        }
    }
}
