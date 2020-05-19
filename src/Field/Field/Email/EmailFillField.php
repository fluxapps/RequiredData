<?php

namespace srag\RequiredData\Field\Field\Email;

use srag\RequiredData\Field\Field\Text\TextFillField;

/**
 * Class EmailFillField
 *
 * @package srag\RequiredData\Field\Field\Email
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class EmailFillField extends TextFillField
{

    /**
     * @var EmailField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(EmailField $field)
    {
        parent::__construct($field);
    }
}
