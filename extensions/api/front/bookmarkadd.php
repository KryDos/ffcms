<?php
/**
|==========================================================|
|========= @copyright Pyatinskii Mihail, 2013-2014 ========|
|================= @website: www.ffcms.ru =================|
|========= @license: GNU GPL V3, file: license.txt ========|
|==========================================================|
 */

use engine\user;
use engine\system;
use engine\property;
use engine\database;

class api_bookmarkadd_front extends \engine\singleton {

    public function make() {
        if(user::getInstance()->get('id') > 0) {
            $userid = user::getInstance()->get('id');
            $title = system::getInstance()->nohtml(system::getInstance()->post('title'));
            $url = system::getInstance()->nohtml(system::getInstance()->post('url'));
            // only self domain
            if(system::getInstance()->prefixEquals($url, property::getInstance()->get('script_url')) && filter_var($url, FILTER_VALIDATE_URL) && system::getInstance()->length($title) > 0) {
                $stmt = database::getInstance()->con()->prepare("SELECT COUNT(*) FROM ".property::getInstance()->get('db_prefix')."_user_bookmarks WHERE target = ? AND href = ?");
                $stmt->bindParam(1, $userid, PDO::PARAM_INT);
                $stmt->bindParam(2, $url, PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetch();
                $stmt = null;
                if($res[0] < 1) {
                    $stmt = database::getInstance()->con()->prepare("INSERT INTO ".property::getInstance()->get('db_prefix')."_user_bookmarks (`target`, `title`, `href`) VALUES (?, ?, ?)");
                    $stmt->bindParam(1, $userid, PDO::PARAM_INT);
                    $stmt->bindParam(2, $title, PDO::PARAM_STR);
                    $stmt->bindParam(3, $url, PDO::PARAM_STR);
                    $stmt->execute();
                    $stmt = null;
                }
            }
        }
    }
}