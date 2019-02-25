<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Field\Complex_Field;

$assistants_labels = array(
	'plural_name'   => 'блоки',
	'singular_name' => 'блок',
);

 $basic_options_container = Container::make( 'theme_options', __('Basic option', 'innova'))
                ->add_fields(array(
       							 	Field::make('text', 'admin_phone', 'Введите номер телефона администратора сайта'),
                Field::make('text', 'admin_email', 'Введите Email адрес администратора сайта'),
                Field::make('text', 'admin_skype', 'Введите никнейм Skype администратора сайта'),
        ));













Container::make( 'theme_options', 'Header option theme' )
->set_page_parent( $basic_options_container )
->add_tab(__('Фавикон'), array(
			Field::make('image', 'site_favicon', 'Фавикон')
    ->set_value_type( 'url' )
    ->set_help_text( 'Загрузите файл в формате  *.ico.' ),
))
->add_tab(__('Логотип'), array(
			Field::make('text', 'site_logo', 'Логотип сайта')->set_help_text( 'Введите название сайта, который будет использоваться для вывода логотипа сайта.' ),
))
->add_tab(__('Телефон'), array(
				 	Field::make('text', 'header_voice', 'Призыв к действию')->set_help_text( 'Введите короткий текст - призыв к действию позвонить.' ),
      Field::make('text', 'header_phpne', 'Введите название сайта')->set_help_text( 'Введите номер телефона своей службы поддержки в международном стандарте, Пример: +7 (090) 343-44-43.' ),
));










Container::make( 'theme_options', 'Our_Works', 'Our Works' )
->set_page_parent( $basic_options_container )
->add_tab(__('Название'), array(
	Field::make('text', 'our_works_title', 'Название блока')
	->set_attribute( 'placeholder', 'Our Works' )
	->set_help_text( 'Введите короткое название блока с нашими работами.' ),
))
->add_tab(__('Работы'), array(
Field::make( 'complex', 'slide_our_works', 'Все наши работы' )
->setup_labels( $assistants_labels )
->add_fields( array(

	Field::make('image', 'our_works_photo', 'Фотография')->set_width(50)
    ->set_value_type( 'url' )
    ->set_help_text( 'Загрузите фотографиию человека, который размещает отзыв о ваших услугвх, размер 64рх на 64рх, формат: *.jpg.' ),
Field::make( 'text', 'our_works_name', 'Описание' )->set_width(50)
->set_help_text( 'Введите краткое описание работы.' ),
))->set_header_template( '
    <% if (our_works_name) { %>
        Название работы - <%- our_works_name %>
    <% } %>
' ),













));
































Container::make( 'theme_options', 'Thestimonials' )
->set_page_parent( $basic_options_container )
->add_tab(__('Название'), array(
	Field::make('text', 'thestimonials_title', 'Название блока')
	->set_attribute( 'placeholder', 'Testimonials' )
	->set_help_text( 'Введите короткое название блока с отзывами.' ),
))
->add_tab(__('Отзывы'), array(
Field::make( 'complex', 'slide_thestimonials', 'Перечень отзыввов' )
->setup_labels( $assistants_labels )
->set_collapsed( true )
->add_fields( array(

	Field::make('image', 'thestimonials_photo', 'Фотография')->set_width(100)
    ->set_value_type( 'url' )
    ->set_help_text( 'Загрузите фотографиию человека, который размещает отзыв о ваших услугвх, размер 64рх на 64рх, формат: *.jpg.' ),
Field::make( 'textarea', 'thestimonials_text', 'Текст отзыва' )->set_width(50)
->set_help_text( 'Разместите текст отзыва о вашей продукции.' ),
Field::make( 'text', 'thestimonials_name', 'Имя клиента' )->set_width(50)
->set_help_text( 'Разместите имя и фамилию клиента.' ),


Field::make( 'complex', 'slide_socialspytwo2', 'Социальные сети' )
->setup_labels( $assistants_labels )->set_collapsed( true )
->add_fields( array(
Field::make( 'text', 'social_icon_two2', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links_two2', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template( '
    <% if (social_icon_two2) { %>
        Содержимое: иконка - <%- social_icon_two2 %>, адрес сети - <%- social_links_two2 ? "(" + social_links_two2 + ")" : "" %>
    <% } %>
' ),

))->set_header_template( '
    <% if (thestimonials_name) { %>
        Имя клиента - <%- thestimonials_name %>
    <% } %>
' ),
));

Container::make( 'theme_options', 'Slider Data' )
   ->add_fields( array(
        Field::make( 'complex', 'crb_slides' )
            ->add_fields( array(
                Field::make( 'image', 'image' )->set_value_type( 'url' ),
                Field::make( 'complex', 'slide_fragments' )
                    ->add_fields( array(
                        Field::make( 'text', 'fragment_text' ),
                        Field::make( 'text', 'fragment_position' ),
                    ))
            )),
    ));




Container::make( 'theme_options', 'Footer option theme' )
->set_page_parent( $basic_options_container )
        ->add_tab(__('Контактная форма'), array(
Field::make('text', 'footer_contactform_title', 'Название блока')
->set_attribute( 'placeholder', 'Get In Touch' )
->set_attribute( 'type', 'text' )
->set_help_text( 'Введите название формы обратной связи, которая размещена в подвале сайте.' ),

Field::make('text', 'footer_contactform_descr', 'Описание блока')
->set_attribute( 'placeholder', 'Please fill out the form below to send us an email and we will get back to you as soon as possible' )
->set_attribute( 'type', 'text' )
->set_help_text( 'Введите описание блока формы обратной связи, которая размещена в подвале сайте.' ),

Field::make('text', 'footer_contactform_shotcode', ' ФОС Contact Forms 7')
->set_help_text( 'Вставьте шот-код Contact Forms 7, которвый был создан и адаптирован под работу этого шаблона.' ),
))
 ->add_tab(__('Адрес'), array(
 Field::make('text', 'footer_contact_title', 'Название блока')
->set_attribute( 'placeholder', 'Контактная информация' )
 ->set_attribute( 'type', 'text' )
 ->set_help_text( 'Введите название блока Контактов, который размещен в подвале сайта.' ),
 Field::make('rich_text', 'footer_contact_adress', 'Адрес сайта')
 ->set_help_text( 'Введите полный почтовый адрес вашего офиса.' ),
 Field::make('text', 'footer_contact_phone', 'Телефон')->set_help_text( 'Введите контактный телефон, который будет вводиться в подвале сайта' ),
 Field::make('text', 'footer_contact_email', 'E-mail')->set_help_text( 'Введите контактный почтовый адрес, который будет вводиться в подвале сайта' ),
))
->add_tab(__('Сети'), array(

Field::make( 'complex', 'slide_socialspytwo' )
->setup_labels( $assistants_labels )
->add_fields( array(
Field::make( 'text', 'social_icon_two', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links_two', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template( '
    <% if (social_icon_two) { %>
        Содержимое: иконка - <%- social_icon_two %>, адрес сети - <%- social_links_two ? "(" + social_links_two + ")" : "" %>
    <% } %>
' ),













))
         ->add_tab(__('Копирайты'), array(
       							 	Field::make('textarea', 'footer_copyright', 'Социальные сети')->set_help_text( 'Введите копирайт вашей фирмы, используя HTML-теги.' ),
));

















?>