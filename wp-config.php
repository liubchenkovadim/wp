<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'wp');

/** Имя пользователя MySQL */
define('DB_USER', 'wp');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'root');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Z!QCxn*d*XcE7?MNO>Z>_UvMP~gu/h$Ac`6.N&KNMc~VYcpS+.lS]B+jhl;v0$h9');
define('SECURE_AUTH_KEY',  ',/f@?PLK]e5=},ymc/sY/FvTwJ$PfV#ebXRw_1p{v8#)$PS(,kUTk@p/Ee#OxIj+');
define('LOGGED_IN_KEY',    'X?c6@90swVV:S`+Dj(xe!%DihYNi61Hw/|9=)8.**3d9>8aALdkQO|:pD#&k50;6');
define('NONCE_KEY',        'BoGqm:A!EHUYDi4cH#OYoj=NJUS1^#r&,~iopUy!Qk.V6yl4^]gflvFH^3R8FO^Z');
define('AUTH_SALT',        'IWY!J.^R6PofV(D<#|ZPHL1z!#,8OSt@Y5 |q7m.3$lLpm)rz8^$A((7hXw/J~YN');
define('SECURE_AUTH_SALT', 'HI`jA9u!n*7[P~uU>mWp3H#av!uNk%+d-Y&Tvg:_SIv-6)#cURcNJ|r^v?#20DQ~');
define('LOGGED_IN_SALT',   '^n[&Ju]ONOk{RE|fPL_e&fWZm)`6;F2aGv|Tm/B5zB<OK];.pQd,^RXp<h{:RMBT');
define('NONCE_SALT',       'Nv|{w].E*yp`2U1-4EV%+DFm-!Cn8)Ht@L+EMPcC,D1oFcCW$+r=u2~<UPD9N$pO');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');

define('FS_METHOD', 'direct');
