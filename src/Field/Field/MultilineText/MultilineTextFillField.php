<?php

namespace srag\RequiredData\Field\Field\MultilineText;

use ILIAS\UI\Component\Input\Field\Input;
use srag\RequiredData\Field\Field\Text\TextFillField;

/**
 * Class MultilineTextFillField
 *
 * @package srag\RequiredData\Field\Field\MultilineText
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class MultilineTextFillField extends TextFillField
{

    /**
     * @var MultilineTextField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(MultilineTextField $field)
    {
        parent::__construct($field);
    }


    /**
     * @inheritDoc
     */
    public function formatAsString($fill_value) : string
    {
        return nl2br(parent::formatAsString($fill_value), false);
    }


    /**
     * @inheritDoc
     */
    public function getInput() : Input
    {
        return self::dic()->ui()->factory()->input()->field()->textarea($this->field->getLabel(), $this->field->getDescription())->withRequired($this->field->isRequired());
    }
}
