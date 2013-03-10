<?php
define('root', $_SERVER['DOCUMENT_ROOT']);
// версия системы
define('version', '0.1');
// указатель на админ-интерфейс
define('isadmin', TRUE);

// подключаем файл конфигураций
require_once(root."/config.php");

// подключаем и инициируем все используемые классы движка
require_once(root."/load.php");

// загрузка интерфейса админ панели
$admin->doload();
echo $template->compile();
$template->cleanafterprint();

?>