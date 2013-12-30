<?php
    
namespace HtMessaging\Form;

use HtMessaging\Options\MultipleReceiversOptionsInterface;
use ZfcBase\Form\ProvidesEventsForm;
use Zend\Form\Element;

class MessageForm extends ProvidesEventsForm
{
    protected $options;

    public function __construct(MultipleReceiversOptionsInterface $options, $name = 'message')
    {
        $this->options = $options;
        parent::__construct($name);
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function init()
    {
        $this->add(array(
            'name' => 'subject',
            'type' => 'Text',
            'options' => array(
                'label' => 'Subject',
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'sender_id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'message_text',
            'type' => 'Textarea',
            'options' => array(
                'label' => 'Message Body',
            ),
            'attributes' => array(
                'class' => 'form-control'
            )
        ));

        $receiver = new Element\Select('receiver_id');
        $receiver->setLabel('Receiver');
        $receiver->setAttributes(array(
            'class' => 'form-control',
            'multiple' => $this->getOptions()->getEnableMultipleReceivers()
        ));
        $this->add($receiver);
        $this->getEventManager()->trigger('init', $this);

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'class' => 'btn btn-lg btn-primary',
                "value" => "Send" 
            )
        ));
    }
}
