<?php

namespace srag\RequiredData\Field\Field\SearchSelect\Form;

use srag\RequiredData\Field\Field\MultiSearchSelect\Form\MultiSearchSelectFieldFormBuilder;
use srag\RequiredData\Field\Field\SearchSelect\SearchSelectField;
use srag\RequiredData\Field\FieldCtrl;

/**
 * Class SearchSelectFieldFormBuilder
 *
 * @package srag\RequiredData\Field\Field\SearchSelect\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SearchSelectFieldFormBuilder extends MultiSearchSelectFieldFormBuilder
{

    /**
     * @var SearchSelectField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, SearchSelectField $field)
    {
        parent::__construct($parent, $field);
    }
}
