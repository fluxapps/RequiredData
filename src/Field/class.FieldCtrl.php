<?php

namespace srag\RequiredData\Field;

use ilConfirmationGUI;
use ilUtil;
use srag\DIC\DICTrait;
use srag\RequiredData\Field\StaticMultiSearchSelect\SMSSAjaxAutoCompleteCtrl;
use srag\RequiredData\Utils\RequiredDataTrait;

/**
 * Class FieldCtrl
 *
 * @package           srag\RequiredData\Field
 *
 * @author            studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy srag\RequiredData\Field\FieldCtrl: srag\RequiredData\Field\FieldsCtrl
 * @ilCtrl_isCalledBy srag\RequiredData\Field\StaticMultiSearchSelect\SMSSAjaxAutoCompleteCtrl: srag\RequiredData\Field\FieldCtrl
 */
class FieldCtrl
{

    use DICTrait;
    use RequiredDataTrait;
    const CMD_ADD_FIELD = "addField";
    const CMD_BACK = "back";
    const CMD_CREATE_FIELD = "createField";
    const CMD_EDIT_FIELD = "editField";
    const CMD_MOVE_FIELD_DOWN = "moveFieldDown";
    const CMD_MOVE_FIELD_UP = "moveFieldUp";
    const CMD_REMOVE_FIELD = "removeField";
    const CMD_REMOVE_FIELD_CONFIRM = "removeFieldConfirm";
    const CMD_UPDATE_FIELD = "updateField";
    const GET_PARAM_FIELD_ID = "field_id";
    const GET_PARAM_FIELD_TYPE = "field_type";
    const TAB_EDIT_FIELD = "field_data";
    /**
     * @var FieldsCtrl
     */
    protected $parent;
    /**
     * @var AbstractField|null
     */
    protected $field;


    /**
     * FieldCtrl constructor
     *
     * @param FieldsCtrl $parent
     */
    public function __construct(FieldsCtrl $parent)
    {
        $this->parent = $parent;
    }


    /**
     *
     */
    public function executeCommand() : void
    {
        $this->field = self::requiredData()
            ->fields()
            ->getFieldById($this->parent->getParentContext(), $this->parent->getParentId(), strval(filter_input(INPUT_GET, self::GET_PARAM_FIELD_TYPE)),
                intval(filter_input(INPUT_GET, self::GET_PARAM_FIELD_ID)));

        if ($this->field !== null) {
            self::dic()->ctrl()->setParameter($this, self::GET_PARAM_FIELD_TYPE, $this->field->getType());
            self::dic()->ctrl()->setParameter($this, self::GET_PARAM_FIELD_ID, $this->field->getFieldId());
        }

        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            case strtolower(SMSSAjaxAutoCompleteCtrl::class):
                self::dic()->ctrl()->forwardCommand(new SMSSAjaxAutoCompleteCtrl($this));
                break;

            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_ADD_FIELD:
                    case self::CMD_BACK:
                    case self::CMD_CREATE_FIELD:
                    case self::CMD_EDIT_FIELD:
                    case self::CMD_MOVE_FIELD_DOWN:
                    case self::CMD_MOVE_FIELD_UP:
                    case self::CMD_REMOVE_FIELD:
                    case self::CMD_REMOVE_FIELD_CONFIRM:
                    case self::CMD_UPDATE_FIELD:
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
    protected function setTabs() : void
    {
        self::dic()->tabs()->clearTargets();

        self::dic()->tabs()->setBackTarget(self::requiredData()->getPlugin()->translate("fields", FieldsCtrl::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTarget($this, self::CMD_BACK));

        if ($this->field !== null) {
            if (self::dic()->ctrl()->getCmd() === self::CMD_REMOVE_FIELD_CONFIRM) {
                self::dic()->tabs()->addTab(self::TAB_EDIT_FIELD, self::requiredData()->getPlugin()->translate("remove_field", FieldsCtrl::LANG_MODULE), self::dic()->ctrl()
                    ->getLinkTarget($this, self::CMD_REMOVE_FIELD_CONFIRM));
            } else {
                self::dic()->tabs()->addTab(self::TAB_EDIT_FIELD, self::requiredData()->getPlugin()->translate("edit_field", FieldsCtrl::LANG_MODULE), self::dic()->ctrl()
                    ->getLinkTarget($this, self::CMD_EDIT_FIELD));

                self::dic()->locator()->addItem($this->field->getFieldTitle(), self::dic()->ctrl()->getLinkTarget($this, self::CMD_EDIT_FIELD));
            }
        } else {
            self::dic()->tabs()->addTab(self::TAB_EDIT_FIELD, self::requiredData()->getPlugin()->translate("add_field", FieldsCtrl::LANG_MODULE), self::dic()->ctrl()
                ->getLinkTarget($this, self::CMD_ADD_FIELD));
        }

        self::dic()->tabs()->activateTab(self::TAB_EDIT_FIELD);
    }


    /**
     *
     */
    protected function back() : void
    {
        self::dic()->ctrl()->redirect($this->parent, FieldsCtrl::CMD_LIST_FIELDS);
    }


    /**
     *
     */
    protected function moveFieldDown()
    {
        list($type, $field_id) = explode("_", self::requiredData()->fields()->factory()->newTableInstance($this->parent)->build()->getBrowserFormat()->getActionRowId(self::requiredData()
            ->fields()
            ->factory()
            ->newTableInstance($this->parent)
            ->build()
            ->getTableId()));

        self::requiredData()->fields()->moveFieldDown(self::requiredData()
            ->fields()
            ->getFieldById($this->parent->getParentContext(), $this->parent->getParentId(), $type, $field_id));

        exit;
    }


    /**
     *
     */
    protected function moveFieldUp()
    {
        list($type, $field_id) = explode("_", self::requiredData()->fields()->factory()->newTableInstance($this->parent)->build()->getBrowserFormat()->getActionRowId(self::requiredData()
            ->fields()
            ->factory()
            ->newTableInstance($this->parent)
            ->build()
            ->getTableId()));

        self::requiredData()->fields()->moveFieldUp(self::requiredData()
            ->fields()
            ->getFieldById($this->parent->getParentContext(), $this->parent->getParentId(), $type, $field_id));

        exit;
    }


    /**
     *
     */
    protected function addField() : void
    {
        $form = self::requiredData()->fields()->factory()->newCreateFormInstance($this);

        self::output()->output($form);
    }


    /**
     *
     */
    protected function createField() : void
    {
        $form = self::requiredData()->fields()->factory()->newCreateFormInstance($this);

        if (!$form->storeForm()) {
            self::output()->output($form);

            return;
        }

        $this->field = $form->getField();

        self::dic()->ctrl()->setParameter($this, self::GET_PARAM_FIELD_TYPE, $this->field->getType());
        self::dic()->ctrl()->setParameter($this, self::GET_PARAM_FIELD_ID, $this->field->getFieldId());

        ilUtil::sendSuccess(self::requiredData()->getPlugin()->translate("added_field", FieldsCtrl::LANG_MODULE, [$this->field->getFieldTitle()]), true);

        self::dic()->ctrl()->redirect($this, self::CMD_EDIT_FIELD);
    }


    /**
     *
     */
    protected function editField() : void
    {
        $form = self::requiredData()->fields()->factory()->newFormInstance($this, $this->field);

        self::output()->output($form);
    }


    /**
     *
     */
    protected function updateField() : void
    {
        $form = self::requiredData()->fields()->factory()->newFormInstance($this, $this->field);

        if (!$form->storeForm()) {
            self::output()->output($form);

            return;
        }

        ilUtil::sendSuccess(self::requiredData()->getPlugin()->translate("saved_field", FieldsCtrl::LANG_MODULE, [$this->field->getFieldTitle()]), true);

        self::dic()->ctrl()->redirect($this, self::CMD_EDIT_FIELD);
    }


    /**
     *
     */
    protected function removeFieldConfirm() : void
    {
        $confirmation = new ilConfirmationGUI();

        $confirmation->setFormAction(self::dic()->ctrl()->getFormAction($this));

        $confirmation->setHeaderText(self::requiredData()->getPlugin()
            ->translate("remove_field_confirm", FieldsCtrl::LANG_MODULE, [$this->field->getFieldTitle()]));

        $confirmation->addItem(self::GET_PARAM_FIELD_ID, $this->field->getId(), $this->field->getFieldTitle());

        $confirmation->setConfirm(self::requiredData()->getPlugin()->translate("remove", FieldsCtrl::LANG_MODULE), self::CMD_REMOVE_FIELD);
        $confirmation->setCancel(self::requiredData()->getPlugin()->translate("cancel", FieldsCtrl::LANG_MODULE), self::CMD_BACK);

        self::output()->output($confirmation);
    }


    /**
     *
     */
    protected function removeField() : void
    {
        self::requiredData()->fields()->deleteField($this->field);

        ilUtil::sendSuccess(self::requiredData()->getPlugin()->translate("removed_field", FieldsCtrl::LANG_MODULE, [$this->field->getFieldTitle()]), true);

        self::dic()->ctrl()->redirect($this, self::CMD_BACK);
    }


    /**
     * @return AbstractField
     */
    public function getField() : AbstractField
    {
        return $this->field;
    }


    /**
     * @return FieldsCtrl
     */
    public function getParent() : FieldsCtrl
    {
        return $this->parent;
    }
}
