<?php

use engine\permission;

class api_ckbrowser_back {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function make() {
        if(!permission::getInstance()->have('global/owner'))
            return;
        if(file_exists(root . "/resource/ckeditor/browser.php")) {
            require_once(root . "/resource/ckeditor/browser.php");
        }
    }
}