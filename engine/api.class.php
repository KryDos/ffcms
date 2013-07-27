<?php
class api
{
    public function load()
    {
        global $system, $file, $language, $template;
        $apiresult = null;
        switch ($system->get('action')) {
            case "readwall":
                $apiresult = $this->loadUserWall();
                break;
            case "postwall":
                $apiresult = $this->doPostWall();
                break;
            case "adminfiles":
                return $file->elfinderForAdmin();
                break;
            case "imperaviimageload":
                return $file->imperaviLoad();
                break;
            case "commentupload":
                return $file->commentUserUpload();
                break;
            case "redirect":
                $apiresult = $this->userLeaveRedirect();
                break;
            case "encodedredirect":
                $apiresult = $this->userEncodedLeaveRedirect();
                break;
            case "js":
                $apiresult = $this->showRequestJs();
                break;
            case "postcomment":
                $apiresult = $this->postComment();
                break;
            case "viewcomment":
                $apiresult = $this->viewComment();
                break;
            case "commenteditform":
                $apiresult = $this->editComment();
                break;
            case "commenteditpost":
                return $this->editPostComment();
                break;
            case "commentdelete":
                return $this->deleteComment();
                break;
            case "addbookmark":
                return $this->addBookMark();
                break;
            case "apicallback":
                return $this->apiCallBack();
                break;
            default:
                break;
        }
        $apiresult = $template->ruleCheck($apiresult);
        return $language->set($apiresult);
    }

    private function apiCallBack()
    {
        global $constant, $system;
        $name = $system->get('object');
        $file = $constant->root . "/extensions/apicallback/" . $name . "/front.php";
        if(file_exists($file))
        {
            require_once($file);
            $class_name = "api_{$name}_front";
            if(class_exists($class_name)) {
                $init = new $class_name;
                if(method_exists($init, 'load')) {
                    return $init->load();
                }
            }
        }
        return;
    }

    private function addBookMark()
    {
        global $database, $constant, $system, $user;
        if($user->get('id') < 1) {
            return;
        }
        $title = $system->nohtml($system->post('title'));
        $url = $system->nohtml($system->post('url'));
        $userid = $user->get('id');
        if($system->prefixEquals($url, $constant->url)) {
            $stmt = $database->con()->prepare("SELECT COUNT(*) FROM {$constant->db['prefix']}_user_bookmarks WHERE target = ? AND href = ?");
            $stmt->bindParam(1, $userid, PDO::PARAM_INT);
            $stmt->bindParam(2, $url, PDO::PARAM_STR);
            $stmt->execute();
            $res = $stmt->fetch();
            if($res[0] == 0) {
                $stmt = null;
                $stmt = $database->con()->prepare("INSERT INTO {$constant->db['prefix']}_user_bookmarks (`target`, `title`, `href`) VALUES (?, ?, ?)");
                $stmt->bindParam(1, $userid, PDO::PARAM_INT);
                $stmt->bindParam(2, $title, PDO::PARAM_STR);
                $stmt->bindParam(3, $url, PDO::PARAM_STR);
                $stmt->execute();
            }
        }
    }

    private function showRequestJs()
    {
        global $system, $constant, $template;
        header('Content-Type: text/javascript');
        $dir = $system->get('dir');
        $file = $system->get('name');
        if (file_exists($constant->root . $constant->ds . $constant->tpl_dir . $constant->ds . $constant->tpl_name . $constant->ds . $dir . $constant->ds . $file . ".tpl")) {
            return $template->get($file, $dir . $constant->ds);
        }
    }

    private function deleteComment()
    {
        global $user, $system, $constant, $database;
        if($database->isDown())
            return;
        if ($user->get('id') > 0 && $user->get('mod_comment_delete') > 0) {
            $comment_id = (int)$system->get('id');
            $stmt = $database->con()->prepare("DELETE FROM {$constant->db['prefix']}_mod_comments WHERE id = ?");
            $stmt->bindParam(1, $comment_id, PDO::PARAM_INT);
            $stmt->execute();
            $stmt = null;
        }
        return;
    }

    private function editPostComment()
    {
        global $system, $database, $constant, $user;
        if($database->isDown())
            return;
        $comment_id = (int)$system->post('comment_id');
        if ($user->get('id') > 0 && ($user->get('mod_comment_edit') > 0 || $this->commentEditCondition($comment_id))) {
            $comment_text = $system->nohtml($system->post('comment_text'));
            if ($comment_id > 0 && strlen($comment_text) > 0) {
                $stmt = $database->con()->prepare("UPDATE {$constant->db['prefix']}_mod_comments set comment = ? where id = ?");
                $stmt->bindParam(1, $comment_text, PDO::PARAM_STR);
                $stmt->bindParam(2, $comment_id, PDO::PARAM_INT);
                $stmt->execute();
                $stmt = null;
            }
        }
        return;
    }

    private function commentEditCondition($id)
    {
        global $database, $constant, $user, $extension;
        if($database->isDown())
            return;
        if ($id > 0) {
            $stmt = $database->con()->prepare("SELECT author,time FROM {$constant->db['prefix']}_mod_comments WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($result = $stmt->fetch()) {
                $editconfig = $extension->getConfig('edit_time', 'comments', 'modules', 'int');
                if ($result['author'] == $user->get('id') && (time() - $result['time']) <= $editconfig) {
                    return true;
                }
            }
        }
        return false;
    }

    private function editComment()
    {
        global $system, $template, $database, $constant, $language;
        if($database->isDown())
            return;
        $comment_id = (int)$system->get('id');
        $stmt = $database->con()->prepare("SELECT * FROM {$constant->db['prefix']}_mod_comments WHERE id = ?");
        $stmt->bindParam(1, $comment_id, PDO::PARAM_INT);
        $stmt->execute();
        $content = null;
        if ($result = $stmt->fetch()) {
            $content = $template->assign(array('comment_id', 'comment_text'), array($comment_id, $system->nohtml($result['comment'])), $template->get('comment_api_edit', 'modules/mod_comments/'));
        } else {
            $content = $template->stringNotify('error', $language->get('comment_api_edit_nocomment'));
        }
        $stmt = null;
        return $content;
    }

    private function postComment()
    {
        global $system, $constant, $database, $user, $extension, $template, $language;
        if($database->isDown())
            return;
        $text = $system->nohtml($system->post('comment_message'));
        $object = $system->post('object');
        $id = $system->post('id');
        $hash = $system->post('hash');
        if ($text != null && $object != null && $id != null && $system->isInt($id) && $hash != null && strlen($hash) == 32) {
            $notify = null;
            if ($user->get('id') > 0 && $user->get('content_post') > 0 && $user->get('mod_comment_add') > 0) {
                $time = time();
                $userid = $user->get('id');
                // узнаем время последнего комментария
                $stmt = $database->con()->prepare("SELECT `time` FROM {$constant->db['prefix']}_mod_comments WHERE author = ? ORDER BY `time` DESC LIMIT 1");
                $stmt->bindParam(1, $userid, PDO::PARAM_INT);
                $stmt->execute();
                if ($result = $stmt->fetch()) {
                    $lastposttime = $result['time'];
                    if (($time - $lastposttime) < $extension->getConfig('time_delay', 'comments', 'modules', 'int')) {
                        $notify .= $template->stringNotify('error', $language->get('comments_api_delay_exception'));
                    }
                }
                if ($system->length($text) < $extension->getConfig('min_length', 'comments', 'modules', 'int') || $system->length($text) > $extension->getConfig('max_length', 'comments', 'modules', 'int')) {
                    $notify .= $template->stringNotify('error', $language->get('comments_api_incorrent_length'));
                }
                if ($notify == null) {
                    $stmt = $database->con()->prepare("INSERT INTO {$constant->db['prefix']}_mod_comments (target_hash, object_name, object_id, comment, author, time)
                    VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bindParam(1, $hash, PDO::PARAM_STR, 32);
                    $stmt->bindParam(2, $object, PDO::PARAM_STR);
                    $stmt->bindParam(3, $id, PDO::PARAM_STR);
                    $stmt->bindParam(4, $text, PDO::PARAM_STR);
                    $stmt->bindParam(5, $userid, PDO::PARAM_INT);
                    $stmt->bindParam(6, $time, PDO::PARAM_INT);
                    $stmt->execute();
                    $notify .= $template->stringNotify('success', $language->get('comments_api_add_success'));
                }
            } else {
                $notify .= $template->stringNotify('error', $language->get('comments_api_add_fail'));
            }
            return $this->viewComment($notify);
        }
        return;
    }

    public function viewComment($notify = null)
    {
        global $system, $database, $constant, $user, $template, $extension, $hook;
        if($database->isDown())
            return;
        $object = $system->post('object');
        $id = $system->post('id');
        $hash = $system->post('hash');
        $position = $system->post('comment_position');
        if ($object != null && $id != null && $system->isInt($id) && $hash != null && strlen($hash) == 32 && $system->isInt($position)) {
            $userid = $user->get('id');
            $config_on_page = $extension->getConfig('comments_count', 'comments', 'modules', 'int');
            $end_point = $position == 0 ? $config_on_page : $position * $config_on_page + $config_on_page;
            $theme_list = $template->get('comment_list', 'modules/mod_comments/');
            $content = null;
            $content .= $notify;
            $stmt = $database->con()->prepare("SELECT COUNT(*) FROM {$constant->db['prefix']}_mod_comments WHERE target_hash = ? AND object_name = ? AND object_id = ?");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR, 32);
            $stmt->bindParam(2, $object, PDO::PARAM_STR);
            $stmt->bindParam(3, $id, PDO::PARAM_STR);
            $stmt->execute();
            $rowRes = $stmt->fetch();
            $commentCount = $rowRes[0];
            $stmt = null;
            $stmt = $database->con()->prepare("SELECT * FROM {$constant->db['prefix']}_mod_comments WHERE target_hash = ? AND object_name = ? AND object_id = ? ORDER BY id DESC LIMIT 0,?");
            $stmt->bindParam(1, $hash, PDO::PARAM_STR, 32);
            $stmt->bindParam(2, $object, PDO::PARAM_STR);
            $stmt->bindParam(3, $id, PDO::PARAM_INT);
            $stmt->bindParam(4, $end_point, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = null;
            $user->listload($system->extractFromMultyArray('author', $result));
            foreach ($result as $item) {
                $edit_link = null;
                $delete_link = null;
                $poster_id = $item['author'];
                $editconfig = $extension->getConfig('edit_time', 'comments', 'modules', 'int');
                if ($userid > 0) {
                    if (($poster_id == $userid && (time() - $item['time']) <= $editconfig) || $user->get('mod_comment_edit') > 0) {
                        $edit_link = $template->assign('comment_id', $item['id'], $template->get('comment_link_edit', 'modules/mod_comments/'));
                    }
                    if ($user->get('mod_comment_delete') > 0) {
                        $delete_link = $template->assign('comment_id', $item['id'], $template->get('comment_link_delete', 'modules/mod_comments/'));
                    }
                }
                $content .= $template->assign(array('poster_id', 'poster_nick', 'poster_avatar', 'comment_text', 'comment_date', 'comment_id', 'comment_link_edit', 'comment_link_delete'),
                    array($poster_id, $user->get('nick', $poster_id), $user->buildAvatar('small', $poster_id), $hook->get('bbtohtml')->bbcode2html($item['comment']), $system->toDate($item['time'], 'h'), $item['id'], $edit_link, $delete_link),
                    $theme_list);
            }
            if ($end_point > $commentCount) {
                $content .= '<script>$(\'#loader_comment\').remove();</script>';
            }
            return $content;
        }
    }

    private function userLeaveRedirect()
    {
        global $system, $template;
        return $template->assign('target_url', $system->get('url'), $template->get('redirect'));
    }

    private function userEncodedLeaveRedirect()
    {
        global $system, $template;
        $url = base64_decode($system->get('url'));
        return $template->assign('target_url', $url, $template->get('redirect'));
    }

    public function doPostWall()
    {
        global $system, $user, $database, $constant, $extension;
        if($database->isDown())
            return;
        $root_post_id = $system->get('id');
        $writer_id = $user->get('id');
        $message = $system->nohtml($system->post('message'));
        $time = time();
        $limit = false;
        if ($system->isInt($root_post_id) && strlen($system->post('message')) > 0 && $writer_id > 0) {
            $time_between_posts = $extension->getConfig('wall_post_delay', 'usercontrol', 'components', 'int');
            $stmt = $database->con()->prepare("SELECT time FROM {$constant->db['prefix']}_user_wall_answer WHERE poster = ? ORDER BY id DESC LIMIT 1");
            $stmt->bindParam(1, $writer_id, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetch();
            $last_post_time = $res['time'];
            $stmt = null;
            $current_time = time();
            if (($current_time - $last_post_time) >= $time_between_posts) {
                $stmt = $database->con()->prepare("INSERT INTO {$constant->db['prefix']}_user_wall_answer (wall_post_id, poster, message, time) VALUES(?, ?, ?, ?)");
                $stmt->bindParam(1, $root_post_id, PDO::PARAM_INT);
                $stmt->bindParam(2, $writer_id, PDO::PARAM_INT);
                $stmt->bindParam(3, $message, PDO::PARAM_STR);
                $stmt->bindParam(4, $time, PDO::PARAM_INT);
                $stmt->execute();
            } else {
                $limit = true;
            }
        }
        return $this->loadUserWall($limit);
    }

    public function loadUserWall($limit = false)
    {
        global $system, $database, $constant, $user, $language, $template;
        if($database->isDown())
            return;
        $root_post_id = $system->get('id');
        if ($system->isInt($root_post_id)) {
            $theme = $template->get('api_wallanswer', 'components/usercontrol/');
            $compiled = null;
            if ($limit) {
                $compiled .= $template->stringNotify('error', $language->get('usercontrol_profile_wall_answer_spamdetect'));
            }
            $stmt = $database->con()->prepare("SELECT * FROM {$constant->db['prefix']}_user_wall_answer WHERE wall_post_id = ? ORDER BY id DESC");
            $stmt->bindParam(1, $root_post_id, PDO::PARAM_INT);
            $stmt->execute();
            while ($result = $stmt->fetch()) {
                $from_id = $result['poster'];
                $compiled .= $template->assign(array('wall_from_id', 'wall_from', 'user_avatar', 'wall_message'),
                    array($from_id, $user->get('nick', $from_id), $user->buildAvatar('small', $from_id), $result['message']),
                    $theme);
            }
            if ($compiled == null) {
                $compiled = $language->get('usercontrol_profile_wall_noanswer');
            }
            return $compiled;
        }
    }
}

?>