<?php
class api
{
	public $separator = "/";
	
	public function load()
	{
		global $system;
		switch($system->get('action'))
		{
			case "readwall":
				return $this->loadUserWall();
				break;
			case "postwall":
				return $this->doPostWall();
				break;
			case "elfinder":
				$file->elfinder();
				break;
			case "redirect":
				return $this->userLeaveRedirect();
				break;
			case "js":
				return $this->showRequestJs();
				break;
			default:
				break;
		}
	}
	
	private function showRequestJs()
	{
		global $system,$constant,$template;
		header('Content-Type: text/javascript');
		$dir = $system->get('dir');
		$file = $system->get('name');
		if(file_exists($constant->root.$constant->ds.$constant->tpl_dir.$constant->ds.$constant->tpl_name.$constant->ds.$dir.$constant->ds.$file.".tpl"))
		{
			return $template->tplget($file, $dir.$constant->ds);
		}
	}
	
	private function userLeaveRedirect()
	{
		global $system,$template;
		return $template->assign('target_url', $system->get('url'), $template->tplget('redirect'));
	}
	
	public function doPostWall()
	{
		global $system,$user,$database,$constant,$extension;
		$root_post_id = $system->get('id');
		$writer_id = $user->get('id');
		$message = $system->nohtml($system->post('message'));
		$time = time();
		$limit = false;
		if($system->isInt($root_post_id) && strlen($system->post('message')) > 0 && $writer_id > 0)
		{
			$time_between_posts = $extension->getConfig('wall_post_delay', 'usercontrol', 'components', 'int');
			$stmt = $database->con()->prepare("SELECT time FROM {$constant->db['prefix']}_user_wall_answer WHERE poster = ? ORDER BY id DESC LIMIT 1");
			$stmt->bindParam(1, $writer_id, PDO::PARAM_INT);
			$stmt->execute();
			$res = $stmt->fetch();
			$last_post_time = $res['time'];
			$stmt = null;
			$current_time = time();
			if(($current_time - $last_post_time) >= $time_between_posts)
			{
				$stmt = $database->con()->prepare("INSERT INTO {$constant->db['prefix']}_user_wall_answer (wall_post_id, poster, message, time) VALUES(?, ?, ?, ?)");
				$stmt->bindParam(1, $root_post_id, PDO::PARAM_INT);
				$stmt->bindParam(2, $writer_id, PDO::PARAM_INT);
				$stmt->bindParam(3, $message, PDO::PARAM_STR);
				$stmt->bindParam(4, $time, PDO::PARAM_INT);
				$stmt->execute();
			}
			else
			{
				$limit = true;
			}
		}
		return $this->loadUserWall($limit);
	}
	
	public function loadUserWall($limit = false)
	{
		global $system,$database,$constant,$user,$language,$extension,$template;
		$root_post_id = $system->get('id');
		if($system->isInt($root_post_id))
		{
			$theme = $template->tplget('api_wallanswer', 'components/usercontrol/');
			$compiled = null;
			if($limit)
			{
				$compiled .= $template->stringNotify('error', $language->get('usercontrol_profile_wall_answer_spamdetect'));
			}
			$stmt = $database->con()->prepare("SELECT * FROM {$constant->db['prefix']}_user_wall_answer WHERE wall_post_id = ? ORDER BY id DESC");
			$stmt->bindParam(1, $root_post_id, PDO::PARAM_INT);
			$stmt->execute();
			while($result = $stmt->fetch())
			{
				$from_id = $result['poster'];
				$compiled .= $template->assign(array('wall_from_id', 'wall_from', 'user_avatar', 'wall_message'), 
						array($from_id, $user->get('nick', $from_id), $user->buildAvatar('small', $from_id), $result['message']), 
						$theme);
			}
			if($compiled == null)
			{
				$compiled = $language->get('usercontrol_profile_wall_noanswer');
			}
			return $compiled;
		}
	}
}
?>