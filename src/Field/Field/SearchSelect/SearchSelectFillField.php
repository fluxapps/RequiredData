<?php

namespace srag\RequiredData\Field\Field\SearchSelect;

use ILIAS\UI\Component\Input\Field\Input;
use srag\RequiredData\Field\Field\MultiSearchSelect\MultiSearchSelectFillField;

/**
 * Class SearchSelectFillField
 *
 * @package srag\RequiredData\Field\Field\SearchSelect
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
    public function getInput() : Input
    {
        $input = parent::getInput();

        $input->getInput()->setLimitCount(1);

        return $input;
    }
}
