<?php


namespace Toast;

use PageController;
use Psr\Log\LoggerInterface;
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

    private static $dependencies = [
        'Logger' => '%$' . LoggerInterface::class,
    ];


    /** @var LoggerInterface */
    protected $logger;

    protected function init()
    {
        $this->logger->debug("Start logging home page...");
        parent::init();
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

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
                TextField::create('Name','')
                    ->setFieldHolderTemplate('Form\\FormField_holder')
                    ->setAttribute('placeholder', 'Name')
                    ->addExtraClass('form-field w-6/12 float-left md:pr-2'),
                EmailField::create('Email', '')
                    ->setFieldHolderTemplate('Form\\FormField_holder')
                    ->setAttribute('placeholder', 'Email')
                    ->addExtraClass('form-field w-6/12 float-right'),
                TextField::create('Company', '')
                    ->setFieldHolderTemplate('Form\\FormField_holder')
                    ->setAttribute('placeholder', 'Company')
                    ->addExtraClass('form-field w-full')
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

        $contactForm->setAttribute('novalidate', true)
            ->setRedirectToFormOnValidationError(true);

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
            // todo: require more validation here?

            // Save to database
            $contact = Contact::create();
            $contact->Name = $name;
            $contact->Email = $email;
            $contact->Company = $company;
            $contact->write();

            // send notification email to admin
            try {
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
            } catch (\Exception $ex) {
                // log email process to file,
                // but we still let it continue to show successful result to frontend
                $this->logger->error($ex->getMessage());
            }

            $form->sessionMessage('Thanks for your message.', 'good');
            return $this->redirect('/#Form_ContactForm');
        } catch (\Exception $ex) {
            // Show friendly response to frontend and log the error to investigate
            $this->logger->error($ex->getMessage());
            $form->sessionMessage('Sorry, we are unable to process your request. Please try again later.');
            return $this->redirect('/#Form_ContactForm');
        }
    }
}
