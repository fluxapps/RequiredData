<?php

namespace srag\RequiredData\Fill;

use srag\DIC\DICTrait;
use srag\RequiredData\Field\AbstractFieldsCtrl;
use srag\RequiredData\Utils\RequiredDataTrait;

/**
 * Class AbstractFillCtrl
 *
 * @package srag\RequiredData\Fill
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
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
     * @var int
     */
    protected $parent_context;
    /**
     * @var int
     */
    protected $parent_id;
    /**
     * @var string|null
     */
    protected $fill_id;


    /**
     * AbstractFillCtrl constructor
     *
     * @param int         $parent_context
     * @param int         $parent_id
     * @param string|null $fill_id
     */
    public function __construct(int $parent_context, int $parent_id,/*?*/ string $fill_id = null)
    {
        $this->parent_context = $parent_context;
        $this->parent_id = $parent_id;
        $this->fill_id = $fill_id;
    }


    /**
     *
     */
    public function executeCommand()/*: void*/
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
     *
     */
    protected function setTabs()/*: void*/
    {
        self::dic()->tabs()->clearTargets();

        self::dic()->tabs()->setBackTarget(self::plugin()->translate("back", AbstractFieldsCtrl::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_CANCEL));

        self::dic()->tabs()->addTab(self::TAB_FILL_FIELDS, self::plugin()->translate("fill_fields", AbstractFieldsCtrl::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_FILL_FIELDS));

        self::dic()->tabs()->activateTab(self::TAB_FILL_FIELDS);
    }


    /**
     *
     */
    protected function fillFields()/*: void*/
    {
        $form = self::requiredData()->fills()->factory()->newFillFormInstance($this);

        self::output()->output($form, true);
    }


    /**
     *
     */
    protected function saveFields()/*: void*/
    {
        $form = self::requiredData()->fills()->factory()->newFillFormInstance($this);

        if (!$form->storeForm()) {
            self::output()->output($form, true);

            return;
        }

        self::dic()->ctrl()->redirect($this, self::CMD_BACK);
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
     * @return string|null
     */
    public function getFillId()/* : ?string*/
    {
        return $this->fill_id;
    }


    /**
     *
     */
    protected abstract function back()/* : void*/ ;


    /**
     *
     */
    protected abstract function cancel()/* : void*/ ;
}
