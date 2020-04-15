<?php

namespace srag\RequiredData\Field\Field\Select;

use ILIAS\UI\Component\Input\Field\Input;
use srag\RequiredData\Field\FieldsCtrl;
use srag\RequiredData\Fill\AbstractFillField;

/**
 * Class SelectFillField
 *
 * @package srag\RequiredData\Field\Field\Select
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SelectFillField extends AbstractFillField
{

    /**
     * @var SelectField
     */
    protected $field;


    /**
     * @inheritDoc
     */
    public function __construct(SelectField $field)
    {
        parent::__construct($field);
    }


    /**
     * @inheritDoc
     */
    public function getInput() : Input
    {
        return self::dic()->ui()->factory()->input()->field()->select($this->field->getLabel(), ($this->field->isRequired() && count($this->field->getSelectOptions()) === 1
                ? []
                : [
                    "&lt;" . self::requiredData()
                        ->getPlugin()
                        ->translate("please_select", FieldsCtrl::LANG_MODULE) . "&gt;"
                ]) + $this->field->getSelectOptions(), $this->field->getDescription())->withRequired($this->field->isRequired());
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
        return strval($this->field->getSelectOptions()[strval($fill_value)]);
    }
}
