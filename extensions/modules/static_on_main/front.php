<?php

use engine\extension;
use engine\template;

class modules_static_on_main_front {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function make() {
        $page_id = extension::getInstance()->getConfig('news_id', 'static_on_main', 'modules', 'int');
        $show_date = extension::getInstance()->getConfig('show_date', 'static_on_main', 'modules', 'boolean');
        // call to component static pages and display it
        $page_content = extension::getInstance()->call(extension::TYPE_COMPONENT, 'static')->display('', $page_id, $show_date);
        template::getInstance()->set(template::TYPE_CONTENT, 'body', $page_content);
    }
}