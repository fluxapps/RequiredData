<?php

namespace srag\RequiredData\Field\Text;

use ilTextInputGUI;
use srag\CustomInputGUIs\PropertyFormGUI\PropertyFormGUI;
use srag\RequiredData\Fill\AbstractFillField;

/**
 * Class TextFillField
 *
 * @package srag\RequiredData\Field\Text
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TextFillField extends AbstractFillField
{

    /**
     * @var TextField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(TextField $field)
    {
        parent::__construct($field);
    }


    /**
     * @inheritDoc
     */
    public function getFormFields() : array
    {
        return [
            PropertyFormGUI::PROPERTY_CLASS => ilTextInputGUI::class
        ];
    }


    /**
     * @inheritDoc
     */
    public function formatAsJson($fill_value)
    {
        return strval($fill_value);
    }


    /**
     * @inheritDoc
     */
    public function formatAsString($fill_value) : string
    {
        return strval($fill_value);
    }
}
