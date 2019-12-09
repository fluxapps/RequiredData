<?php

namespace srag\RequiredData\Fill;

use srag\CustomInputGUIs\PropertyFormGUI\PropertyFormGUI;
use srag\RequiredData\Field\FieldsCtrl;
use srag\RequiredData\Utils\RequiredDataTrait;

/**
 * Class FillFormGUI
 *
 * @package srag\RequiredData\Fill
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class FillFormGUI extends PropertyFormGUI
{

    use RequiredDataTrait;
    const LANG_MODULE = FieldsCtrl::LANG_MODULE;
    /**
     * @var array
     */
    protected $fill_values;


    /**
     * FillFormGUI constructor
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
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            case (strpos($key, "field_") === 0):
                $field_id = substr($key, strlen("field_"));

                return $this->fill_values[$field_id];

            default:
                return null;
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(AbstractFillCtrl::CMD_SAVE_FIELDS, $this->txt("save"));
        $this->addCommandButton(AbstractFillCtrl::CMD_CANCEL, $this->txt("cancel"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        foreach (self::requiredData()->fields()->getFields($this->parent->getParentContext(), $this->parent->getParentId()) as $field) {
            $this->fields["field_" . $field->getId()] = array_merge(
                [
                    "setTitle" => $field->getLabel(),
                    "setInfo"  => $field->getDescription()
                ],
                self::requiredData()->fills()->factory()->newFillFieldInstance($field)->getFormFields(),
                [
                    self::PROPERTY_REQUIRED => $field->isRequired()
                ]);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt("fill_fields"));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            case (strpos($key, "field_") === 0):
                $field_id = substr($key, strlen("field_"));

                $this->fill_values[$field_id] = $value;
                break;

            default:
                break;
        }
    }


    /**
     * @inheritDoc
     */
    public function storeForm()/*: void*/
    {
        if (!parent::storeForm()) {
            return false;
        }

        $this->fill_values = self::requiredData()->fills()->formatAsJsons($this->parent->getParentContext(), $this->parent->getParentId(), $this->fill_values);

        self::requiredData()->fills()->storeFillValues($this->parent->getFillId(), $this->fill_values);

        return true;
    }


    /**
     * @inheritDoc
     */
    public function txt(/*string*/ $key,/*?string*/ $default = null) : string
    {
        if ($default !== null) {
            return self::requiredData()->getPlugin()->translate($key, self::LANG_MODULE, [], true, "", $default);
        } else {
            return self::requiredData()->getPlugin()->translate($key, self::LANG_MODULE);
        }
    }
}
