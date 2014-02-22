<?php

use engine\system;
use engine\extension;

class api_commentview_front {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function make() {
        $this->loadComments();
    }

    private function loadComments() {
        $comment_way = system::getInstance()->post('pathway');
        $comment_position = (int)system::getInstance()->post('comment_position');
        $load_all = system::getInstance()->post('comment_all') === "true" ? true : false; // to bool :D
        $result = extension::getInstance()->call(extension::TYPE_MODULE, 'comments')->buildCommentTemplate($comment_way, $comment_position, $load_all);
        echo $result;
    }
}