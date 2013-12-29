<?php
    
namespace HtMessaging\Form;
    
use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\Filter\Int;

class MessageInputFilter extends ProvidesEventsInputFilter
{

    protected $options;

    public function __construct(MultipleReceiversOptionsInterface $options)
    {
        $this->options = $options;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function init()
    {
        $this->add(array(
            'name' => 'subject',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
            
            )
        ));

        $this->add(array(
            'name' => 'receiver_id',
            'required' => false
        ));

        $this->add(array(
            'name' => 'message_text',
            'required' => true
        ));

        if ($this->getOptions()->getEnableMultipleReceivers()) {
            $this->add(array(
                'name' => 'receiver_id',
                'filters' => array(
                    array(
                        'name' => 'Callback',
                        'options' => array(
                            'callback' => function($values) {
                                $output = array();
                                $filter = new Int();
                                foreach ($values as $value) {
                                    $output[] = $filter->filter($value);
                                }
                                return $output;
                            }
                        )
                    )
                )
            ));            
        } else {
            $this->add(array(
                'name' => 'receiver_id',
                'filters' => array(
                    array(
                        'name' => 'Int',
                    )
                )
            ));            
        }
    }
}
