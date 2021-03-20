<?php
class ConfPostTypes
{
    public function __construct()
    {
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this,'register_post_types'));
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
            'publicly_queryable'    => true,
            'exclude_from_search'   => true,
            'show_in_admin_bar'     => true,

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
            'publicly_queryable'    => true,
            'exclude_from_search'   => true,
            'show_in_admin_bar'     => true,

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
            'public'            =>  true,
            'hierarchical'      => true,
            'publicy_queryable' => false,
        ]);
    }
}