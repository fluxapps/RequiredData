<?php

namespace srag\RequiredData\Field\Checkbox;

use srag\RequiredData\Field\AbstractField;

/**
 * Class CheckboxField
 *
 * @package srag\RequiredData\Field\Checkbox
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class CheckboxField extends AbstractField
{

    const TABLE_NAME_SUFFIX = "chck";


    /**
     * @inheritDoc
     */
    public function getFieldDescription() : string
    {
        return "";
    }
}
