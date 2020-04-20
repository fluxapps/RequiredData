<?php

namespace srag\RequiredData\Fill\Form;

use srag\CustomInputGUIs\FormBuilder\AbstractFormBuilder;
use srag\RequiredData\Field\FieldsCtrl;
use srag\RequiredData\Fill\AbstractFillCtrl;
use srag\RequiredData\Utils\RequiredDataTrait;

/**
 * Class FormBuilder
 *
 * @package srag\RequiredData\Fill\Form
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class FormBuilder extends AbstractFormBuilder
{

    use RequiredDataTrait;
    /**
     * @var array
     */
    protected $fill_values;


    /**
     * @inheritDoc
     *
     * @param AbstractFillCtrl $parent
     */
    public function __construct(AbstractFillCtrl $parent)
    {
        $this->fill_values = self::requiredData()->fills()->getFillValues($parent->getFillId());

        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getButtons() : array
    {
        $buttons = [
            AbstractFillCtrl::CMD_SAVE_FIELDS => self::requiredData()->getPlugin()->translate("save", FieldsCtrl::LANG_MODULE),
            AbstractFillCtrl::CMD_CANCEL      => self::requiredData()->getPlugin()->translate("cancel", FieldsCtrl::LANG_MODULE)
        ];

        return $buttons;
    }


    /**
     * @inheritDoc
     */
    protected function getData() : array
    {
        //$data = $this->fill_values;
        $data = [];

        return $data;
    }


    /**
     * @inheritDoc
     */
    protected function getFields() : array
    {
        $fields = self::requiredData()->fills()->getFormFields($this->parent->getParentContext(), $this->parent->getParentId(), $this->fill_values);

        return $fields;
    }


    /**
     * @inheritDoc
     */
    protected function getTitle() : string
    {
        return self::requiredData()->getPlugin()->translate("fill_fields", FieldsCtrl::LANG_MODULE);
    }


    /**
     * @inheritDoc
     */
    protected function storeData(array $data) : void
    {
        $this->fill_values = self::requiredData()->fills()->formatAsJsons($this->parent->getParentContext(), $this->parent->getParentId(), $data);

        self::requiredData()->fills()->storeFillValues($this->parent->getFillId(), $this->fill_values);
    }
}
