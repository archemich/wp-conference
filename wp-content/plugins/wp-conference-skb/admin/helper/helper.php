<?php
class ConfHelper
{
    public function __construct()
    {
        add_action('admin_menu', array($this,'top_submenu'));
        wp_register_style( 'helper_ui_css', plugin_dir_url(__FILE__) . '/css/helper_ui.css' );
        wp_enqueue_style( 'helper_ui_css');
    }


    public function top_submenu()
    {
        add_submenu_page(
            'conference_top',
            'Помощь',
            'Помощь',
            'manage_options',
            'conference_help',
            array($this, 'top_submenu_html')
        );
    }

    
    public function top_submenu_html()
    {
        ?>
        <div class="wrap">
            <h1>Conference Помощь</h1>
            <p>Плагин Conference добавляет новые типы записей, добавляет возможность их выгрузки в Excel, а также добавляет генератор приглашений</p>
            <h2>Настройка WP-Recall</h2>
            <p>ID в полях форм: 
                <ol>
                    <li>Форма заявки:
                        <ul>
                            <li>Фамилия - встроенное название поста (id = 'post_title')</li>
                            <li>Имя - 'imya'</li>
                            <li>Отчество - 'otchestvo'</li>
                            <li>Дата рождения - 'data_rozhdenia'</li>
                            <li>Город - 'gorod'</li>
                            <li>Основное место работы - 'organizaciya'</li>
                            <li>Место работы (аббревиатура) - 'organizaciya_abbreviatura'</li>
                            <li>Должность - 'dolzhnost'</li>
                            <li>Ученая степень - 'uchenaya_stepen'</li>
                            <li>Ученое звание- 'uchenoe_zvanie'</li>
                            <li>Телефон рабочий- 'telephon_rabochiy'</li>
                            <li>Телефон конференции- 'telephon_conferencia'</li>
                            <li>E-Mail - 'email'</li>
                            <li>Форма участия - 'forma_uchastia'</li>
                            <li>Я хочу получить печатное издание по локальной конференции - 'pechatnoe_izdanie'</li>
                            <li>Пользовательское соглашение - 'soglashenie'</li>
                        </ul>
                    </li>

                    <li>Форма доклада
                        <ul>
                            <li>Фамилия - familiya</li>
                            <li>Имя - imya</li>
                            <li>Отчество - otchestvo</li>
                            <li>Соавторы - soavtori</li>
                            <li>Название доклада - встроенное название поста (id = 'post_title')</li>
                            <li>Направления - встроенный выбор категории поста (id = 'taxonomy-subject')</li>
                            <li>Доклад - встроенный загрузчик файлов (id = 'post_uploader')</li>
                            <li>Секции соавторов ($ - порядковый номер, например familiya_soavtor1):
                                <ul>
                                    <li>Фамилия соавтора - familiya_soavtor$</li>
                                    <li>Имя соавтора - imya_soavtor$</li>
                                    <li>Отчество соавтора - otchestvo_soavtor$</li>
                                    <li>Город соавтора - gorod_soavtor$</li>
                                    <li>Должность соавтора - dolzhnost_soavtor$</li>
                                    <li>Ученая степень соавтора - uchenaya_stepen_soavtor$</li>
                                    <li>Ученое звание соавтора - uchenoe_zvanie_soavtor$</li>
                                    <li>Членство РАН соавтора - chlenstvo_ran_soavtor$</li>
                                    <li>E-Mail соавтора - email_soavtor$</li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li>Форма экспертного заключения:
                        <ul>
                            <li>ФИО - встроенное название поста (id = 'post_title')</li>
                            <li>Экспертное заключение - встроенный загрузчик файлов (id = 'post_uploader')</li>
                        </ul>
                    </li>

                    <li>Форма акта идентификационной экспертизы:
                        <ul>
                            <li>ФИО - встроенное название поста (id = 'post_title')</li>
                            <li>Акт идентификационной экспертизы - встроенный загрузчик файлов (id = 'post_uploader')</li>
                        </ul>
                    </li>

                    <li>Форма согласия на обработку персональных данных:
                        <ul>
                            <li>ФИО - встроенное название поста (id = 'post_title')</li>
                            <li>Согласие на обработку персональных данных - встроенный загрузчик файлов (id = 'post_uploader')</li>
                        </ul>
                    </li>

                    <li>Форма информации о прибытии:
                        <ul>
                            <li>ФИО - встроенное название поста (id = 'post_title')</li>
                            <li>Приезд - 'priezd'</li>
                            <li>Город приезда - 'gorod_priezda'</li>
                            <li>Дата приезда - 'data_priezda'</li>
                            <li>Планируемое время приезда - 'planiruemoe_vremya_priezda'</li>
                            <li>Отъезд - 'otezd'</li>
                            <li>Город отъезда - 'gorod_otezda'</li>
                            <li>Дата отъезда - 'data_otezda'</li>
                            <li>Планируемое время отъезда - 'planiruemoe_vremya_otezda'</li>
                        </ul>
                    </li>

                    <li>Форма заполненого договора:
                        <ul>
                            <li>ФИО - встроенное название поста (id = 'post_title')</li>
                            <li>Заполненый договор - встроенный загрузчик файлов (id = 'post_uploader')</li>
                        </ul>
                    </li>
                </ol>
            </p>

            <p>Поля профиля:
               <ul>
               <li>Отчество - 'otchestvo' </li>
               </ul> 
            </p>
        </div> 
        <?php
    }
}