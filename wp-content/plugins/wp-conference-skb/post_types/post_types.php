<?php
class ConfPostTypes
{
    public function __construct()
    {
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'register_post_types'));
    }

    public function register_post_types()
    {
        register_post_type('application', [
            'labels' => [
                'name'               => 'Заявки',
                'singular_name'      => 'Заявка',
                'add_new'            => 'Добавить новую',
                'add_new_item'       => 'Добавить новую заявку',
                'edit_item'          => 'Редактировать заявку',
                'new_item'           => 'Новая заявка',
                'view_item'          => 'Посмотреть заявку',
                'search_items'       => 'Найти заявку',
                'not_found'          => 'Заявка не найдена',
                'not_found_in_trash' => 'В корзине заявки не найдены',
                'parent_item_colon'  => '',
                'menu_name'          => 'Заявки'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 4,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
        ]);

        register_post_type('report', [
            'labels' => [
                'name'               => 'Доклады',
                'singular_name'      => 'Доклад',
                'add_new'            => 'Добавить новый',
                'add_new_item'       => 'Добавить новый доклад',
                'edit_item'          => 'Редактировать доклад',
                'new_item'           => 'Новый доклад',
                'view_item'          => 'Посмотреть доклад',
                'search_items'       => 'Найти доклад',
                'not_found'          => 'Доклад не найден',
                'not_found_in_trash' => 'В корзине доклады не найдены',
                'parent_item_colon'  => '',
                'menu_name'          => 'Доклады'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 5,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
        ]);

        register_post_type('expert_opinion', [
            'labels' => [
                'name'               => 'Экспертные заключения',
                'singular_name'      => 'Экспертное заключение',
                'add_new'            => 'Добавить новое',
                'add_new_item'       => 'Добавить новое экспертное заключение',
                'edit_item'          => 'Редактировать экспертное заключение',
                'new_item'           => 'Новое экспертное заключение',
                'view_item'          => 'Посмотреть экспертное заключение',
                'search_items'       => 'Найти экспертное заключение',
                'not_found'          => 'Экспертное заключение не найдено',
                'not_found_in_trash' => 'В корзине экспертные заключения не найдены',
                'parent_item_colon'  => '',
                'menu_name'          => 'Экспертные заключения'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 6,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
        ]);
        
        register_post_type('identification_act', [
            'labels' => [
                'name'               => 'Акты идентификационной экспертизы',
                'singular_name'      => 'Акт идентификационной экспертизы',
                'add_new'            => 'Добавить новый',
                'add_new_item'       => 'Добавить новый акт идентификационной экспертизы',
                'edit_item'          => 'Редактировать акт идентификационной экспертизы',
                'new_item'           => 'Новый акт идентификационной экспертизы',
                'view_item'          => 'Посмотреть акт идентификационной экспертизы',
                'search_items'       => 'Найти акт идентификационной экспертизы',
                'not_found'          => 'Акт идентификационной экспертизы не найден',
                'not_found_in_trash' => 'В корзине акты идентификационной экспертизы не найдены',
                'parent_item_colon'  => '',
                'menu_name'          => 'Акты идентификационной экспертизы'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 7,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,

        ]);

        register_post_type('consent', [
            'labels' => [
                'name'               => 'Согласия на обработку персональных данных',
                'singular_name'      => 'Согласие',
                'add_new'            => 'Добавить новое',
                'add_new_item'       => 'Добавить новое согласие на обработку персональных данных',
                'edit_item'          => 'Редактировать согласие на обработку персональных данных',
                'new_item'           => 'Новое согласие на обработку персональных данных',
                'view_item'          => 'Посмотреть согласие на обработку персональных данных',
                'search_items'       => 'Найти согласие на обработку персональных данных',
                'not_found'          => 'Согласие на обработку персональных данных не найдено',
                'not_found_in_trash' => 'В корзине согласия на обработку персональных данных не найдены',
                'parent_item_colon'  => '',
                'menu_name'          => 'Согласия на обработку персональных данных'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 8,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
        ]);

        register_post_type('arrival_information', [
            'labels' => [
                'name'               => 'Информация о прибытии',
                'singular_name'      => 'Информация о прибытии',
                'add_new'            => 'Добавить новую',
                'add_new_item'       => 'Добавить новую информацию о прибытии',
                'edit_item'          => 'Редактировать информацию о прибытии',
                'new_item'           => 'Новая информация о прибытии',
                'view_item'          => 'Посмотреть информацию о прибытии',
                'search_items'       => 'Найти информацию о прибытии',
                'not_found'          => 'Информация о прибытии не найдена',
                'not_found_in_trash' => 'В корзине информация о прибытии не найдена',
                'parent_item_colon'  => '',
                'menu_name'          => 'Информация о прибытия'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 8,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,

        ]);
        
        
        register_post_type('contract', [
            'labels' => [
                'name'               => 'Договор',
                'singular_name'      => 'Договор',
                'add_new'            => 'Добавить новый',
                'add_new_item'       => 'Добавить новый договор',
                'edit_item'          => 'Редактировать договор',
                'new_item'           => 'Новый договор',
                'view_item'          => 'Посмотреть договор',
                'search_items'       => 'Найти договор',
                'not_found'          => 'Договор не найден',
                'not_found_in_trash' => 'В корзине договоры не найдена',
                'parent_item_colon'  => '',
                'menu_name'          => 'Договоры'
            ],
            'public'                => true,
            'show_in_admin_bar'     => true,
            'menu_position'         => 8,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => true,
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
        ]);
        
    }


    public function register_taxonomies()
    {
        register_taxonomy('subject','report', [
            'labels' => [
                'name'              => 'Направления',
                'singular_name'     => 'Направление',
                'all_items'         => 'Все направления',
                'view_item'         => 'Посмотреть направление',
                'parent_item'       => 'Родительское направление',
                'parent_item_colon'       => 'Родительское направление:',
                'edit_item'         => 'Изменить направление',
                'update_item'       => 'Обновить направление',
                'add_new_item'      => 'Добавить новое направление',
                'new_item_name'     => 'Новое имя направления',
                'menu_name'         => 'Направления'
            ],
            'public'            => true,
            'hierarchical'      => true,
            'publicy_queryable' => false,
        ]);
    }
}