<?php
use engine\template;
use engine\database;
use engine\property;
use engine\system;
use engine\user;

class api_wallview_front {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function make() {
        $post_id = (int)system::getInstance()->get('id');
        $stmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_user_wall_answer WHERE wall_post_id = ? ORDER BY id DESC");
        $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        user::getInstance()->listload(system::getInstance()->extractFromMultyArray('poster', $result));
        $params = array();
        foreach($result as $item) {
            $params['answer'][] = array(
                'poster_id' => $item['poster'],
                'poster_name' => user::getInstance()->get('nick', $item['poster']),
                'poster_avatar' => user::getInstance()->buildAvatar('small', $item['poster']),
                'message' => $item['message'],
                'time' => system::getInstance()->toDate($item['time'], 'h')
            );
        }
        echo template::getInstance()->twigRender('components/user/profile/profile_answer.tpl', array('local' => $params));
    }
}