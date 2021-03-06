<?php
/**
|==========================================================|
|========= @copyright Pyatinskii Mihail, 2013-2014 ========|
|================= @website: www.ffcms.ru =================|
|========= @license: GNU GPL V3, file: license.txt ========|
|==========================================================|
 */

use engine\property;
use engine\database;
use engine\language;
use engine\meta;
use engine\system;
use engine\template;
use engine\router;
use engine\extension;

class components_static_front extends \engine\singleton {

    public function make() {
        $way = router::getInstance()->shiftUriArray();
        $path = system::getInstance()->altimplode('/', $way);
        $content = $this->display($path);
        if($content != null) {
            template::getInstance()->set(template::TYPE_CONTENT, 'body', $content);
        }
    }

    /**
     * Set in body position static page for $pathway
     * @param string $pathway
     * @param int $id
     * @param boolean $show_date
     * @param boolean $is_main
     * @return string|null
     */
    public function display($pathway, $id = null, $show_date = true, $is_main = false) {
        $stmt = null;
        if(is_null($id)) {
            $stmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_static WHERE pathway = ?");
            $stmt->bindParam(1, $pathway, PDO::PARAM_STR);
            $stmt->execute();
        } else {
            $stmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_static WHERE id = ?");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        if($stmt != null && $result = $stmt->fetch()) {
            $serial_title = unserialize($result['title']);
            $serial_text = unserialize($result['text']);
            $serial_keywords = unserialize($result['keywords']);
            $serial_description = unserialize($result['description']);
            if(system::getInstance()->length($serial_title[language::getInstance()->getUseLanguage()]) < 1 || system::getInstance()->length($serial_text[language::getInstance()->getUseLanguage()]) < 1)
                return null;
            $urlfix_object = extension::getInstance()->call(extension::TYPE_HOOK, 'urlfixer');
            if(is_object($urlfix_object))
                $serial_text = $urlfix_object->fix($serial_text);
            if($pathway) {
                meta::getInstance()->add('title', $serial_title[language::getInstance()->getUseLanguage()]);
                meta::getInstance()->add('keywords', $serial_keywords[language::getInstance()->getUseLanguage()]);
                meta::getInstance()->add('description', $serial_description[language::getInstance()->getUseLanguage()]);
            }
            $params = array(
                'title' => $serial_title[language::getInstance()->getUseLanguage()],
                'text' => $serial_text[language::getInstance()->getUseLanguage()],
                'date' => system::getInstance()->toDate($result['date'], 'd'),
                'show_date' => $show_date,
                'is_main' => $is_main,
                'pathway' => property::getInstance()->get('url') . '/static/' . $pathway
            );
            if(system::getInstance()->get('print') == 'true')
                template::getInstance()->justPrint(template::getInstance()->twigRender('components/static/print.tpl', array('local' => $params)));
            return template::getInstance()->twigRender('components/static/page.tpl', array('local' => $params));
        }
        return null;
    }
}