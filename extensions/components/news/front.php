<?php

use engine\template;
use engine\router;
use engine\system;
use engine\database;
use engine\property;
use engine\language;
use engine\extension;
use engine\meta;
use engine\user;

class components_news_front {
    protected static $instance = null;

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function make() {
        template::getInstance()->set(template::TYPE_CONTENT, 'body', $this->buildNews());
    }

    private function buildNews() {
        $content = null;
        $way = router::getInstance()->shiftUriArray();
        // get latest object
        $last_object = array_pop($way);
        // save extracted array
        $category_array = $way;
        if($way[0] == "tag" && system::getInstance()->suffixEquals($last_object, '.html')) {
            $content = $this->viewTagList($last_object);
        }
        // its a single news
        elseif (system::getInstance()->suffixEquals($last_object, '.html')) {
            $content = $this->viewFullNews($last_object, $category_array);
        } else { // its a category
            $content = $this->viewCategory();
        }
        return $content;
    }

    private function viewFullNews($url, $categories)
    {
        $viewTags = extension::getInstance()->getConfig('enable_tags', 'news', 'components', 'boolean');
        $viewCount = extension::getInstance()->getConfig('enable_views_count', 'news', 'components', 'boolean');
        $stmt = null;
        $category_link = null;
        $category_text = null;
        $link_cat = system::getInstance()->altimplode("/", $categories);
        $time = time();
        $catstmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_news_category WHERE path = ?");
        $catstmt->bindParam(1, $link_cat, PDO::PARAM_STR);
        $catstmt->execute();
        if ($catresult = $catstmt->fetch()) {
            $category_link = $catresult['path'];
            $category_serial_text = unserialize($catresult['name']);
            $category_text = $category_serial_text[language::getInstance()->getUseLanguage()];
            $stmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_news_entery WHERE link = ? AND category = ? AND display = 1 AND date <= ?");
            $stmt->bindParam(1, $url, PDO::PARAM_STR);
            $stmt->bindParam(2, $catresult['category_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $time, PDO::PARAM_INT);
            $stmt->execute();
        }
        if ($stmt != null && $result = $stmt->fetch()) {
            $news_view_id = $result['id'];
            $lang_text = unserialize($result['text']);
            $lang_title = unserialize($result['title']);
            $lang_description = unserialize($result['description']);
            $lang_keywords = unserialize($result['keywords']);
            meta::getInstance()->add('title', $lang_title[language::getInstance()->getUseLanguage()]);
            meta::getInstance()->add('keywords', $lang_keywords[language::getInstance()->getUseLanguage()]);
            meta::getInstance()->add('description', $lang_description[language::getInstance()->getUseLanguage()]);
            $tagPrepareArray = system::getInstance()->altexplode(',', $lang_keywords[language::getInstance()->getUseLanguage()]);
            $tag_array = array();
            foreach($tagPrepareArray as $tagItem) {
                $tag_array[] = system::getInstance()->noSpaceOnStartEnd($tagItem);
            }
            $similar_array = array();
            $search_similar_string = $lang_title[language::getInstance()->getUseLanguage()];
            $stmt = null;
            $stmt = database::getInstance()->con()->prepare("SELECT a.*, b.path, MATCH (a.title) AGAINST (? IN BOOLEAN MODE) AS relevance
                                        FROM ".property::getInstance()->get('db_prefix')."_com_news_entery a,
                                        ".property::getInstance()->get('db_prefix')."_com_news_category b
                                        WHERE a.category = b.category_id AND a.id != ? AND a.display = 1
                                        AND MATCH (a.title) AGAINST (? IN BOOLEAN MODE)
                                        ORDER BY relevance LIMIT 0,5");
            $stmt->bindParam(1, $search_similar_string, PDO::PARAM_STR);
            $stmt->bindParam(2, $news_view_id, PDO::PARAM_INT);
            $stmt->bindParam(3, $search_similar_string, PDO::PARAM_STR);
            $stmt->execute();
            $simBody = null;
            if($stmt->rowCount() > 0) {
                $simRes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($simRes as $simRow) {
                    $similar_title = unserialize($simRow['title']);
                    $similar_path = $simRow['path'];
                    $similar_full_path = $similar_path == null ? $simRow['link'] : $similar_path . "/" . $simRow['link'];
                    $similar_text_serialize = unserialize($simRow['text']);
                    $similar_text_full = system::getInstance()->nohtml($similar_text_serialize[language::getInstance()->getUseLanguage()]);
                    $similar_text_short = system::getInstance()->sentenceSub($similar_text_full, 200);
                    $similar_array[] = array(
                        'link' => $similar_full_path,
                        'title' => $similar_title[language::getInstance()->getUseLanguage()],
                        'preview' => $similar_text_short
                    );
                }
            }

            if($viewCount) {
                $vstmt = database::getInstance()->con()->prepare("UPDATE ".property::getInstance()->get('db_prefix')."_com_news_entery SET views = views+1 WHERE id = ?");
                $vstmt->bindParam(1, $news_view_id, PDO::PARAM_INT);
                $vstmt->execute();
                $vstmt = null;
            }
            $comment_list = extension::getInstance()->call(extension::TYPE_MODULE, 'comments')->buildCommentTemplate();
            $theme_array = array(
                'tags' => $tag_array,
                'title' => $lang_title[language::getInstance()->getUseLanguage()],
                'text' => $lang_text[language::getInstance()->getUseLanguage()],
                'date' => system::getInstance()->toDate($result['date'], 'h'),
                'category_url' => $category_link,
                'category_name' => $category_text,
                'author_id' => $result['author'],
                'author_nick' => user::getInstance()->get('nick', $result['author']),
                'view_count' => $result['views'],
                'similar_items' => $similar_array,
                'pathway' => router::getInstance()->getUriString(),
                'cfg' => array(
                    'view_tags' => $viewTags,
                    'view_count' => $viewCount
                )
            );
            return template::getInstance()->twigRender('components/news/full_view.tpl', array('local' => $theme_array, 'comments' => $comment_list));
        }
        return null;
    }

    private function viewTagList($tagname)
    {
        $cleartag = system::getInstance()->nohtml(substr($tagname, 0, -5));
        $stmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_news_entery a, ".property::getInstance()->get('db_prefix')."_com_news_category b WHERE a.category = b.category_id AND a.keywords like ? LIMIT 100");
        $buildSearch = '%'.$cleartag.'%';
        $stmt->bindParam(1, $buildSearch, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() < 1){
            return null;
        }
        $prepared_array = array('tagname' => $cleartag);
        while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $news_full_link = null;
            if ($result['path'] == null) {
                $news_full_link = $result['link'];
            } else {
                $news_full_link = $result['path'] . "/" . $result['link'];
            }
            $news_serial_title = unserialize($result['title']);
            $prepared_array['newsinfo'][] = array('link' => $news_full_link, 'title' => $news_serial_title[language::getInstance()->getUseLanguage()]);
        }
        return template::getInstance()->twigRender('components/news/tag_view.tpl', array('local' => $prepared_array));
    }

    public function viewCategory()
    {
        $viewTags = extension::getInstance()->getConfig('enable_tags', 'news', 'components', 'boolean');
        $viewCount = extension::getInstance()->getConfig('enable_views_count', 'news', 'components', 'boolean');
        $way = router::getInstance()->shiftUriArray();
        $pop_array = $way;
        $last_item = array_pop($pop_array);
        $page_index = 0;
        $page_news_count = extension::getInstance()->getConfig('count_news_page', 'news', 'components', 'int');
        $total_news_count = 0;
        $cat_link = null;
        if (system::getInstance()->isInt($last_item)) {
            $page_index = $last_item;
            $cat_link = system::getInstance()->altimplode("/", $pop_array);
        } else {
            $cat_link = system::getInstance()->altimplode("/", $way);
        }
        $select_coursor_start = $page_index * $page_news_count;

        $category_select_array = array();
        $category_list = null;
        $fstmt = null;
        $page_title = null;
        if (extension::getInstance()->getConfig('multi_category', 'news', 'components', 'boolean')) {
            $fstmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_news_category WHERE path like ?");
            $path_swarm = "$cat_link%";
            $fstmt->bindParam(1, $path_swarm, PDO::PARAM_STR);
            $fstmt->execute();
        } else {
            $fstmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_news_category WHERE path = ?");
            $fstmt->bindParam(1, $cat_link, PDO::PARAM_STR);
            $fstmt->execute();
        }
        while ($fresult = $fstmt->fetch()) {
            $category_select_array[] = $fresult['category_id'];
            if ($cat_link == $fresult['path']) {
                $serial_name = unserialize($fresult['name']);
                meta::getInstance()->add('title', $page_title = language::getInstance()->get('news_view_category').': '.$serial_name[language::getInstance()->getUseLanguage()]);
            }
        }
        $category_list = system::getInstance()->altimplode(',', $category_select_array);
        $theme_array = array();
        $fstmt = null;
        if (system::getInstance()->isIntList($category_list)) {
            $max_preview_length = extension::getInstance()->getConfig('short_news_length', 'news', 'components', 'int');
            $time = time();
            $stmt = database::getInstance()->con()->prepare("SELECT COUNT(*) FROM ".property::getInstance()->get('db_prefix')."_com_news_entery WHERE category in ($category_list) AND date <= ?");
            $stmt->bindParam(1, $time, PDO::PARAM_INT);
            $stmt->execute();
            if ($countRows = $stmt->fetch()) {
                $total_news_count = $countRows[0];
            }
            $stmt = null;
            // TODO: remove delay_news_public from admin panel!!!
            $stmt = database::getInstance()->con()->prepare("SELECT * FROM ".property::getInstance()->get('db_prefix')."_com_news_entery a,
												  ".property::getInstance()->get('db_prefix')."_com_news_category b
												  WHERE a.category in ($category_list) AND a.date <= ?
												  AND a.category = b.category_id
												  AND a.display = 1
												  ORDER BY a.important DESC, a.date DESC LIMIT ?,?");
            $stmt->bindParam(1, $time, PDO::PARAM_INT);
            $stmt->bindParam(2, $select_coursor_start, PDO::PARAM_INT);
            $stmt->bindParam(3, $page_news_count, PDO::PARAM_INT);
            $stmt->execute();
            if (sizeof($category_select_array) > 0) {
                while ($result = $stmt->fetch()) {
                    $lang_text = unserialize($result['text']);
                    $lang_title = unserialize($result['title']);
                    $lang_keywords = unserialize($result['keywords']);
                    $news_short_text = $lang_text[language::getInstance()->getUseLanguage()];
                    if (system::getInstance()->contains('<hr />', $news_short_text)) {
                        $news_short_text = strstr($news_short_text, '<hr />', true);
                    } elseif (system::getInstance()->length($news_short_text) > $max_preview_length) {
                        $news_short_text = system::getInstance()->sentenceSub($news_short_text, $max_preview_length) . "...";
                    }
                    if ($result['path'] == null) {
                        $news_full_link = $result['link'];
                    } else {
                        $news_full_link = $result['path'] . "/" . $result['link'];
                    }
                    $tagPrepareArray = system::getInstance()->altexplode(',', $lang_keywords[language::getInstance()->getUseLanguage()]);
                    $tag_array = array();
                    foreach($tagPrepareArray as $tagItem) {
                        $tag_array[] = system::getInstance()->noSpaceOnStartEnd($tagItem);
                    }
                    $comment_count = 0;
                    if(is_object(extension::getInstance()->call(extension::TYPE_HOOK, 'comment')))
                        $comment_count = extension::getInstance()->call(extension::TYPE_HOOK, 'comment')->getCount('/news/'.$news_full_link);
                    $cat_serial_text = unserialize($result['name']);
                    $theme_array[] = array(
                        'tags' => $tag_array,
                        'title' => $lang_title[language::getInstance()->getUseLanguage()],
                        'text' => $news_short_text,
                        'date' => system::getInstance()->toDate($result['date'], 'h'),
                        'category_url' => $result['path'],
                        'category_name' => $cat_serial_text[language::getInstance()->getUseLanguage()],
                        'author_id' => $result['author'],
                        'author_nick' => user::getInstance()->get('nick', $result['author']),
                        'full_news_uri' => $news_full_link,
                        'comment_count' => $comment_count,
                        'view_count' => $result['views']
                    );
                }
            }
            $stmt = null;
        }
        $page_link = $cat_link == null ? "news" : "news/" . $cat_link;
        $pagination = template::getInstance()->showFastPagination($page_index, $page_news_count, $total_news_count, $page_link);
        return template::getInstance()->twigRender('/components/news/short_view.tpl',
            array('local' => $theme_array,
                'pagination' => $pagination,
                'cfg' => array(
                    'view_tags' => $viewTags,
                    'view_count' => $viewCount
                ),
                'page_title' => $page_title
            )
        );
    }


}