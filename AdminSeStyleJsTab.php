<?php

class AdminSeStyleJsTab extends AdminTab {

    /**
     * @var sestylejs
     */
    protected $module;

    public function __construct(sestylejs $module) {
        parent::__construct();
        $this->module = $module;
    }

    public function install() {
        $tab = new Tab();
        $tab->class_name = $this->module->tabClassName;
        $tab->module = $this->module->name;
        $languages = Language::getLanguages();
        foreach ($languages as $language)
            $tab->name[$language['id_lang']] = $this->module->displayName;
        return $tab->save();
    }

    public function uninstall() {
        $tab = Tab::getInstanceFromClassName($this->module->tabClassName);
        if ($tab) {
            $tab->delete();
        }

        return true;
    }

    public function viewAccess($disable = false){
        $result = true;
        return $result;
    }

    public function display() {
        $do = '';
        return 'Style & Js';
    }
}