<?php

class system
{

	public $post_data = array();
	public $get_data = array();

	function __construct()
	{
		$this->post_data = $_POST;
		$this->get_data = $_GET;
	}

	public function post($key = null)
	{
		return $key == null ? $this->post_data : $this->noParam($this->post_data[$key]);
	}

	public function get($key)
	{
		return urldecode($this->get_data[$key]);
	}

	/**
	 * Замена глобальных переменных на сущности ANSI там, где они не нужны(USER INPUT данные). Т.к. сущесвуют методы, позволяющие работать
	 * в суперпозиции - необходимо очистить вводимый пользователем контент от {$vars} в целях безопасности.
	 * @param unknown_type $data
	 * @return mixed
	 */
	public function noParam($data)
	{
		// если это multiarray $_POST['key1']['key2']['keyN']
		if(is_array($data))
		{
			$output_data = array();
			foreach($data as $key=>$value)
			{
				// это еще 1 уровень вложенности, используем рекурсию
				if(is_array($value))
				{
					$output_data[$key] = $this->noParam($value);
				}
				else
				{
					$output_data[$key] = $this->stringNoParam($value);
				}
			}
			return $output_data;
		}
		return $this->stringNoParam($data);
	}
	
	private function stringNoParam($data)
	{
		preg_match_all('/{\$(.*?)}/i', $data, $matches, PREG_PATTERN_ORDER);
		foreach($matches[1] as $clear)
		{
			$data = preg_replace('/{\$(.*?)}/i', "&#123;&#036;$clear&#125;", $data, 1);
		}
		return $data;
	}

	/**
	 * Boolean функция, отвечающая true если $what обнаружено в $where
	 */
	public function contains($what, $where)
	{
		$answer = false;
		if(strpos($where, $what)!==false)
		{
			$answer = true;
		}
		return $answer;
	}

	/**
	 * Удаляет расширение у $var (indexxxx.html => index, vasya.exe => vasya)
	 * Не спасет от идиотизма вида index.html.html.ht.html.ml но нам это и не нужно.
	 */
	public function noextention($var)
	{
		// режем
		$split = explode(".", $var);
		// крутим цикл, исключаем последний элемент
		if(sizeof($split) > 1)
		{
			$return = null;
			for($i=0;$i<(sizeof($split)-1);$i++)
			{
				$return .= $split[$i];
			}
			return $return;
		}
		return $var;
	}


	/**
	 * Безопасный html. Применять к входящим данным от пользователя.
	 */
	public function safeHtml($data, $allowed = '')
	{
		$unsafe_attributes = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavaible', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragdrop', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterupdate', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmoveout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
		return preg_replace('/<(.*?)>/ie', "'<' . preg_replace(array('/javascript:[^\"\']*/i', '/(" . implode('|', $unsafe_attributes) . ")[ \\t\\n]*=[ \\t\\n]*[\"\'][^\"\']*[\"\']/i', '/\s+/'), array('', '', ' '), stripslashes('\\1')) . '>'", strip_tags($data, $allowed));
	}

	/**
	 * Удаление html тегов
	 */
	public function nohtml($data)
	{
		return strip_tags($data);
	}

	/**
	 * Псевдо-случайная A-Za-z0-9 строка с заданной длиной
	 * Алгоритм достаточно устойчив к бруту, если его длина не менее 16 символов
	 * Однако, для токенов или подобных алгоритмов, рекомендуем функцию md5random()
	 */
	public function randomString($length)
	{
		$ret = 97;
		$out = null;
		for($i=0;$i<$length;$i++)
		{
			$offset = rand(0,15);
			$char = chr($ret+$offset);
			$posibility = rand(0,2);
			if($posibility == 0)
			{
				// 33% - подмешиваем случайное число
				$out .= rand(0,9);
			}
			elseif($posibility == 1)
			{
				// 33% - поднимаем в верхний регистр из offset+ret
				$out .= strtoupper($char);
			}
			else
			{
				$out .= $char;
			}
		}
		return $out;
	}

	/**
	 * Случайный Integer
	 * @param Integer $sequence - показатель длины случайного числа
	 * @return number
	 */
	public function randomInt($sequence)
	{
		$start = pow(10, $sequence-1);
		$end = pow(10, $sequence);
		return rand($start, $end);
	}

	/**
	 * Случайный md5-хеш на основе функции randomString
	 * $min и $max - показатели для выборки случайного размера исходной строки
	 */
	public function md5random($min = 16, $max = 20)
	{
		return md5($this->randomString(rand($min,$max)));
	}

	/**
	 * Случайная величина отталкиваясь от уникального значения $data
	 */
	public function randomWithUnique($data, $min = 16, $max = 30)
	{
		$offset_min = $min-strlen($data);
		$offset_max = $max-strlen($data);
		if($offset_max < 0)
		{
			return $this->md5random();
		}
		elseif($offset_min < 0)
		{
			$data .= $this->randomString(rand(1, $offset_max));
		}
		else
		{
			$data .= $this->randomString(rand($offset_min, $offset_max));
		}
		return md5($data);
	}

	/**
	 * Перенаправление пользователей, обязателен корень /
	 */
	public function redirect($uri = null)
	{
		global $constant;
		header("Location: {$constant->url}{$uri}");
	}

	public function isLatinOrNumeric($data)
	{
		return !preg_match('/[^A-Za-z0-9_]/s', $data) && $this->length($data) > 0;
	}

	/**
	 * Длина строки с корректной обработкой UTF-8
	 * @param unknown_type $data
	 * @return number
	 */
	public function length($data)
	{
		return mb_strlen($data, "UTF-8");
	}

	/**
	 * Приведение $data к Integer
	 * @param unknown_type $data
	 * @return mixed
	 */
	public function toInt($data)
	{
		$result = preg_replace('/[^0-9]/s', '', $data);
		if($result < 0)
			$result = 0;
		return $result;
	}

	/**
	 * Проверка $data на принадлежность к диапазону 0-9
	 * @param unknown_type $data
	 * @return boolean
	 */
	public function isInt($data)
	{
		return !preg_match('/[^0-9]/s', $data) && $this->length($data) > 0;
	}

	/**
	 * Специфическая проверка на принадлежность $data к "integer string list", к примеру - 1,2,3,8,25,91,105
	 * @param unknown_type $data
	 */
	public function isIntList($data)
	{
		return !preg_match('/[^0-9,]/s', $data) && $this->length($data) > 0;
	}

	/**
	 * Удаляет из массива $array значение $value (не ключ!)
	 * @param unknown_type $value
	 * @param unknown_type $array
	 * @return multitype:
	 */
	public function valueUnsetInArray($value, $array)
	{
		return array_values(array_diff($array, array($value)));
	}

	/**
	 * Функция альтернативного имплода массива в адекватную строку (без $decimal в конце или первым элементом, отброс null елементов)
	 * @param unknown_type $decimal
	 * @param unknown_type $array
	 * @return NULL|unknown
	 */
	public function altimplode($decimal, $array)
	{
		$array = $this->nullArrayClean($array);
		if(!is_array($array))
		{
			return null;
		}
		$output = null;
		// перебираем исключая последний элемент
		for($i=0;$i<sizeof($array)-1;$i++)
		{
			$output .= $array[$i].$decimal;
		}
		$output .= $array[sizeof($array)-1];
		return $output;
	}
	
	/**
	 * Альтернативное разрезание строки по $deciaml и отбросом null элементов
	 * @param unknown_type $decimal
	 * @param unknown_type $string
	 * @return Ambigous <multitype:unknown, multitype:unknown >
	 */
	public function altexplode($decimal, $string)
	{
		$array = explode($decimal, $string);
		return $this->nullArrayClean($array);
	}

	/**
	 * Отбрасывание null-элементов из массива. Индекс массива не сохраняется.
	 * @param unknown_type $array
	 * @return multitype:unknown
	 */
	public function nullArrayClean($array)
	{
		$outarray = array();
		foreach($array as $values)
		{
			if($values != null && $values != '')
			{
				$outarray[] = $values;
			}
		}
		return $outarray;
	}

	/**
	 * Добавление элемента в массив если такой элемент уже НЕ содержиться в массиве.
	 * @param unknown_type $item
	 * @param unknown_type $array
	 */
	public function arrayAdd($item, $array)
	{
		if(!in_array($item, $array))
		{
			$array[] = $item;
		}
		return $array;
	}
	
	/**
	 * Вытаскивание из массива 2го уровня значения ключа с учетом того что массив содержит ряд элементов 2го уровня ([0] => array(a => b), [1] => array(c=>d) ... n)
	 * @param unknown_type $key_name
	 * @param unknown_type $array
	 * @return Ambigous <NULL, unknown>
	 */
	public function extractFromMultyArray($key_name, $array)
	{
		$output = array();
		foreach($array as $item)
		{
			$object = $item[$key_name];
			if(!in_array($object, $output))
				$output[] = $item[$key_name];
		}
		return $output;
	}
	
	/**
	 * Преобразование популярных форматов даты в 1 формат отображения. Формат - d = d.m.Y, h = d.m.y hh:mm, s = d.m.Y hh:mm:ss.
	 * Так же принимаются значения unix time.
	 * @param unknown_type $object
	 * @param unknown_type $out_format
	 * @return Ambigous <NULL, string>
	 */
	public function toDate($object, $out_format)
	{
		$result = null;
		if($this->isInt($object))
		{
			$object = date('d.m.Y H:i:s', $object);
		}
		$date_object = new DateTime($object);
		switch($out_format)
		{
			case "h":
				$result = $date_object->format('d.m.Y H:i');
				break;
			case "s":
				$result = $date_object->format('d.m.Y H:i:s');
				break;
			default:
				$result = $date_object->format('d.m.Y');
				break;
		}
		return $result;
	}
	
	public function generateIntRangeArray($start, $end)
	{
		$output = array();
		for($start;$start<=$end;$start++)
		{
			$output[] = $start;
		}
		return $output;
	}
	
	/**
	 * Проверка формата строки на пренадлежность к телефонному номеру. 
	 * @param unknown_type $phone
	 * @return boolean
	 */
	public function validPhone($phone)
	{
		return preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $phone) ? true : false;
	}
	
	/**
	 * Валидность длины пароля. В дальнейшем вынести в конфиг.
	 * @param string|array $password
	 * @return boolean
	 */
	public function validPasswordLength($password)
	{
		if(is_array($password))
		{
			foreach($password as $item)
			{
				if(strlen($item) < 4 || strlen($item) > 32)
					return false;
			}
			return true;
		}
		else
		{
			return (strlen($password) >= 4 && strlen($password) <= 32) ? true : false;
		}
	}
	
	/**
	 * Получение IP-адресса пользователя с учетом возможных проксей и CDN
	 * @return unknown
	 */
	public function getRealIp()
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		// адаптация для cloudflare
		if(isset($_SERVER["HTTP_CF_CONNECTING_IP"]))
		{
			// переопределяем
			$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		return $ip;
	}
	
	/**
	 * Получение двойного MD5 хеша от строки $string с использованием неслучайной уникальной соли.
	 * @param unknown_type $string
	 * @return string
	 */
	public function doublemd5($string)
	{
		global $constant;
		return md5(md5($string).$constant->password_salt);
	}
	
	/**
	 * Генерация строки для SQL запроса. Пример: array('length' => '15', 'color' => 'red') будет приобразовано в: `length` = '15', `color` = 'red'
	 * @param unknown_type $keyArray
	 * @return Ambigous <NULL, string>
	 */
	public function prepareKeyDataToDbUpdate($keyArray)
	{
		$outstring = null;
		$index = 1;
		foreach($keyArray as $column=>$data)
		{
			$outstring .= "`$column` = '$data'";
			if($index != sizeof($keyArray))
			{
				$outstring .= ", ";
			}
			$index++;
		}
		return $outstring;
	}
	
	public function validIP($ip)
	{
		return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}

}

?>