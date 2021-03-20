<?php
class ConfHelper
{
    public function __construct()
    {
        add_action('admin_menu', array($this,'top_submenu'));
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
            <p>ID в формах: 
                <ul>
                    <ul>Форма заявки:
                        <li>Имя - берется из профиля</li>
                        <li>Фамилия - берется из профиля</li>
                        <li>Отчество - 'otchestvo'</li>
                        <li>Дата рождения - 'data_rozhdenia'</li>
                        <li>Город - 'gorod'</li>
                        <li>Организация- 'organizaciya'</li>
                        <li>Организация аббревиатура- 'organizaciya_abbreviatura'</li>
                        <li>Должность - 'dolzhnost'</li>
                        <li>Ученая степень - 'uchenaya_stepen'</li>
                        <li>Ученое звание- 'uchenoe_zvanie'</li>
                        <li>Телефон рабочий- 'telephon_rabochiy'</li>
                        <li>Телефон конференции- 'telephon_conferencia'</li>
                        <li>E-Mail - 'email'</li>
                        <li>Форма участия - 'forma_uchastia'</li>
                        <li>Печатное издание- 'pechatnoe_izdanie'</li>
                        <li>Соглашение - 'soglashenie'</li>
                    </ul>

                    <ul>Форма доклада
                        <li>Конференция - берется из категории поста</li>
                        <li>Направление работы - берется из категории поста</li>
                        <li>Имя - imya</li>
                        <li>Отчество - otchestvo</li>
                        <li>Фамилия - familiya</li>
                        <li>Название доклада - встроенное название поста (id = 'post_title')</li>
                        <li>Направление доклада - встроенный выбор категории поста (id = 'taxonomy-subject')</li>
                        <li>Доклад - встроенный загрузчик файлов (id = 'post_uploader')</li>
                        <ul>Секции соавторов ($ - порядковый номер):
                            <li>Имя соавтора - imya_soavtor$</li>
                            <li>Отчество соавтора - otchestvo_soavtor$</li>
                            <li>Фамилия соавтора - familiya_soavtor$</li>
                            <li>Город соавтора - gorod_soavtor$</li>
                            <li>Должность соавтора - dolzhnost_soavtor$</li>
                            <li>Ученая степень соавтора - uchenaya_stepen_soavtor$</li>
                            <li>Ученое звание соавтора - uchenoe_zvanie_soavtor$</li>
                            <li>Членство РАН соавтора - chlenstvo_ran_soavtor$</li>
                            <li>E-Mail соавтора - email_soavtor$</li>
                        </ul>
                    </ul>
                </ul>
            </p>
        </div> 
        <?php
    }
}