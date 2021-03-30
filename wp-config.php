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
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wp_site' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'wp_site' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ' `;iJ 3%.,bR;*/`}9b.LuS,4J%lDAX.i)Ai+s2okbbvj.>o/46|wn F-OlS+3-L' );
define( 'SECURE_AUTH_KEY',  'o~s]K/oc3xNNJ=w.DbGU.*=vI%*G((/%Pn78]k~sg({Z*g6s5V+apZOzTy1V@c3S' );
define( 'LOGGED_IN_KEY',    'Emj9.:x7(R9Mj o{UuRRN00o2}E4c,HzVl+T2^@W_`dAG}CX!d*KxshW*}Keb/l9' );
define( 'NONCE_KEY',        'K|`9K`lnJU;fejev8<rLn:4>_uhB8t9cuivZwg2L<H%4>E_MoT{aY{Qx25U=Erjy' );
define( 'AUTH_SALT',        'R#Q60FBX!+kLU%]={Dfsgg_#m$a6wJhsC@zqVotE3AK<hn+]+xoZoX:h5*L=},I)' );
define( 'SECURE_AUTH_SALT', 'F^t L)mNr0<#TVkU7wNf@;wuSA[$x,,,pQOAlbo&/4 -<%S(bS<%o[KVr=$aK$4y' );
define( 'LOGGED_IN_SALT',   'mej~R1V`XC7myZm!=^:]FQN7hGpK }q]L;SvQ-Zx@hM]y>KA@aryIBST95wjk+^j' );
define( 'NONCE_SALT',       'paa|/VF!/<#oqIT7v_DYpkv;bp8d.A(nT;Xap]IZ9SU{j 9M.|]c/:gE9rNC4W{7' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
