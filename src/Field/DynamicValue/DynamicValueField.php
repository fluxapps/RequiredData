<?php

namespace srag\RequiredData\Field\DynamicValue;

use arConnector;
use srag\RequiredData\Field\AbstractField;
use srag\RequiredData\Field\FieldsCtrl;

/**
 * Class DynamicValueField
 *
 * @package srag\RequiredData\Field\DynamicValue
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class DynamicValueField extends AbstractField
{

    /**
     * @var bool
     *
     * @con_has_field    true
     * @con_fieldtype    integer
     * @con_length       1
     * @con_is_notnull   true
     */
    protected $hide = false;


    /**
     * @inheritDoc
     */
    public function __construct(/*int*/ $primary_key_value = 0, arConnector $connector = null)
    {
        $this->hide = $this->getInitHide();

        parent::__construct($primary_key_value, $connector);
    }


    /**
     * @inheritDoc
     */
    public function getFieldDescription() : string
    {
        $descriptions = [];

        if ($this->hide) {
            $descriptions[] = self::plugin()->translate("hide", FieldsCtrl::LANG_MODULE);
        }

        $descriptions[] = self::requiredData()->getPlugin()->translate("dynamic_value", FieldsCtrl::LANG_MODULE, [$this->deliverDynamicValue()]);

        return nl2br(implode("\n", array_map(function (string $description) : string {
            return htmlspecialchars($description);
        }, $descriptions)), false);
    }


    /**
     * @return string
     */
    public abstract function deliverDynamicValue() : string;


    /**
     * @return bool
     */
    protected abstract function getInitHide() : bool;


    /**
     * @return bool
     */
    public function isHide() : bool
    {
        return $this->hide;
    }


    /**
     * @param bool $hide
     */
    public function setHide(bool $hide)/* : void*/
    {
        $this->hide = $hide;
    }
}
