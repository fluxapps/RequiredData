<?php

namespace srag\RequiredData\Field\Integer;

use ilCheckboxInputGUI;
use ilNumberInputGUI;
use srag\RequiredData\Field\AbstractFieldFormGUI;
use srag\RequiredData\Field\FieldCtrl;

/**
 * Class IntegerFieldFormGUI
 *
 * @package srag\RequiredData\Field\Integer
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class IntegerFieldFormGUI extends AbstractFieldFormGUI
{

    /**
     * @var IntegerField
     */
    protected $object;


    /**
     * @inheritDoc
     */
    public function __construct(FieldCtrl $parent, IntegerField $object)
    {
        parent::__construct($parent, $object);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            case "min_value_checkbox":
                return ($this->object->getMinValue() !== null);

            case "max_value_checkbox":
                return ($this->object->getMaxValue() !== null);

            default:
                return parent::getValue($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*:void*/
    {
        parent::initFields();

        $this->fields = array_merge(
            $this->fields,
            [
                "min_value_checkbox" => [
                    self::PROPERTY_CLASS    => ilCheckboxInputGUI::class,
                    self::PROPERTY_SUBITEMS => [
                        "min_value" => [
                            self::PROPERTY_CLASS => ilNumberInputGUI::class
                        ]
                    ],
                    "setTitle"              => $this->txt("min_value")
                ],
                "max_value_checkbox" => [
                    self::PROPERTY_CLASS    => ilCheckboxInputGUI::class,
                    self::PROPERTY_SUBITEMS => [
                        "max_value" => [
                            self::PROPERTY_CLASS => ilNumberInputGUI::class
                        ]
                    ],
                    "setTitle"              => $this->txt("max_value")
                ]
            ]
        );
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            case "min_value_checkbox":
                $this->object->setMinValue($value ? 0 : null);
                break;

            case "min_value":
                if ($this->object->getMinValue() !== null) {
                    $this->object->setMinValue($value);
                }
                break;

            case "max_value_checkbox":
                $this->object->setMaxValue($value ? 0 : null);
                break;

            case "max_value":
                if ($this->object->getMaxValue() !== null) {
                    $this->object->setMaxValue($value);
                }
                break;

            default:
                parent::storeValue($key, $value);
                break;
        }
    }
}
