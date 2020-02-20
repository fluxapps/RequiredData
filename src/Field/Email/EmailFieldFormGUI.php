<?php

namespace srag\RequiredData\Field\Email;

use srag\RequiredData\Field\FieldCtrl;
use srag\RequiredData\Field\Text\TextFieldFormGUI;

/**
 * Class EmailFieldFormGUI
 *
 * @package srag\RequiredData\Field\Email
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class EmailFieldFormGUI extends TextFieldFormGUI
{

    /**
     * @var EmailField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, EmailField $field)
    {
        parent::__construct($parent, $field);
    }
}
