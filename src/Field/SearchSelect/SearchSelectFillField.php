<?php

namespace srag\RequiredData\Field\SearchSelect;

use srag\RequiredData\Field\MultiSearchSelect\MultiSearchSelectFillField;

/**
 * Class SearchSelectFillField
 *
 * @package srag\RequiredData\Field\SearchSelect
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SearchSelectFillField extends MultiSearchSelectFillField
{

    /**
     * @var SearchSelectField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(SearchSelectField $field)
    {
        parent::__construct($field);
    }


    /**
     * @inheritDoc
     */
    public function getFormFields() : array
    {
        return array_merge(
            parent::getFormFields(),
            [
                "setLimitCount" => 1
            ]);
    }
}
