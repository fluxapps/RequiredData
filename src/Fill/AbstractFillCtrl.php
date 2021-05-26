<?php

namespace srag\RequiredData\Fill;

use srag\DIC\DICTrait;
use srag\RequiredData\Field\FieldsCtrl;
use srag\RequiredData\Utils\RequiredDataTrait;

/**
 * Class AbstractFillCtrl
 *
 * @package srag\RequiredData\Fill
 */
abstract class AbstractFillCtrl
{

    use DICTrait;
    use RequiredDataTrait;

    const CMD_BACK = "back";
    const CMD_CANCEL = "cancel";
    const CMD_FILL_FIELDS = "fillFields";
    const CMD_SAVE_FIELDS = "saveFields";
    const TAB_FILL_FIELDS = "fill_fields";
    /**
     * @var string|null
     */
    protected $fill_id;
    /**
     * @var int
     */
    protected $parent_context;
    /**
     * @var int
     */
    protected $parent_id;


    /**
     * AbstractFillCtrl constructor
     *
     * @param int         $parent_context
     * @param int         $parent_id
     * @param string|null $fill_id
     */
    public function __construct(int $parent_context, int $parent_id, ?string $fill_id = null)
    {
        $this->parent_context = $parent_context;
        $this->parent_id = $parent_id;
        $this->fill_id = $fill_id;
    }


    /**
     *
     */
    public function executeCommand() : void
    {
        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_BACK:
                    case self::CMD_CANCEL:
                    case self::CMD_FILL_FIELDS:
                    case self::CMD_SAVE_FIELDS:
                        $this->{$cmd}();
                        break;

                    default:
                        break;
                }
                break;
        }
    }


    /**
     * @return string|null
     */
    public function getFillId() : ?string
    {
        return $this->fill_id;
    }


    /**
     * @return int
     */
    public function getParentContext() : int
    {
        return $this->parent_context;
    }


    /**
     * @return int
     */
    public function getParentId() : int
    {
        return $this->parent_id;
    }


    /**
     *
     */
    protected abstract function back() : void;


    /**
     *
     */
    protected abstract function cancel() : void;


    /**
     *
     */
    protected function fillFields() : void
    {
        $form = self::requiredData()->fills()->factory()->newFormBuilderInstance($this);

        self::output()->output($form, true);
    }


    /**
     *
     */
    protected function saveFields() : void
    {
        $form = self::requiredData()->fills()->factory()->newFormBuilderInstance($this);

        if (!$form->storeForm()) {
            self::output()->output($form, true);

            return;
        }

        self::dic()->ctrl()->redirect($this, self::CMD_BACK);
    }


    /**
     *
     */
    protected function setTabs() : void
    {
        self::dic()->tabs()->clearTargets();

        self::dic()->tabs()->setBackTarget(self::requiredData()->getPlugin()->translate("back", FieldsCtrl::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_CANCEL));

        self::dic()->tabs()->addTab(self::TAB_FILL_FIELDS, self::requiredData()->getPlugin()->translate("fill_fields", FieldsCtrl::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_FILL_FIELDS));

        self::dic()->tabs()->activateTab(self::TAB_FILL_FIELDS);
    }
}
