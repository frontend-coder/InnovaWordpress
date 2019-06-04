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
  Field::make('text', 'admin_telegram', 'Введите aдрес аккаунта в Тереграм')
  ->set_attribute( 'placeholder', '@frontendcoder' ),
  Field::make('text', 'admin_email', 'Введите Email адрес администратора сайта')
  ->set_attribute( 'placeholder', 'relaxerlife@gmail.com' ),
  Field::make('text', 'admin_skype', 'Введите никнейм Skype администратора сайта')
  ->set_attribute( 'placeholder', 'webrabcom' ),
));

Container::make( 'theme_options', 'Topmenu option theme' )
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

Container::make( 'theme_options', 'Header option theme' )
->set_page_parent( $basic_options_container )
->add_tab(__('Шапка'), array(
 Field::make('image', 'header_fon', 'Изображение')
 ->set_value_type( 'url' )
 ->set_help_text( 'Изображение для фона шапки сайта. Загрузите файл в формате  *.jpg.' ),
 Field::make('text', 'header_title', 'Название сайта')
 ->set_help_text( 'Введите название сайта, который выводится в шапке сайта.' ),
 Field::make('textarea', 'header_area', 'Описание')
 ->set_help_text( 'Введите описание сайта, который выводится в шапке сайта.' ),
 Field::make('text', 'header_button', 'Название кнопки')
 ->set_help_text( 'Введите название кнопки, которая размещена в шапке сайта и ведет на контактную форму обратной связи.' ),
))

->add_tab(__('Call to action line'), array(
  Field::make('text', 'callaction_title', 'Заглавие')
  ->set_help_text( 'Введите призыв к действию, который будет использоваться для вывода на синейм фоне под шапкой сайта.' ),
  Field::make('text', 'callaction_descr', 'Описание')
  ->set_help_text( 'Введите призыв к действию, который будет использоваться для вывода на синейм фоне под шапкой сайта.' ),
  Field::make('text', 'header_actionbutton', 'Название кнопки')
  ->set_help_text( 'Введите название кнопки, которая размещена на синем фоне под шапкой сайта.' ),
));

Container::make( 'theme_options', 'Who we are' )
->set_page_parent( $basic_options_container )
->add_tab(__('Название'), array(
  Field::make('text', 'who_we_are_title', 'Название блока')
  ->set_attribute( 'placeholder', 'Who we are' )
  ->set_help_text( 'Введите короткое название блока Кем мы являемся.' ),
  Field::make('image', 'who_we_are_photo', 'Фотография')->set_width(100)
  ->set_value_type( 'url' )
  ->set_help_text( 'Загрузите фотографиию человека, которая будет выводится в левой части блока, размер 500рх на 357рх, формат: *.jpg.' ),
))

->add_tab(__('Доводы'), array(
  Field::make( 'textarea', 'who_deskr', 'Текст довода' )->set_width(100)
  ->set_help_text( 'Разместите текст, коотрый будет отображен сразу же под названием блока.' ),
  Field::make( 'text', 'who_deskr_title', 'Название перечня' )->set_width(50)
  ->set_help_text( 'Разместите название перечня доводов.' ),
  Field::make( 'complex', 'who_deskr_list', 'Почему мы' )
  ->setup_labels( $assistants_labels )->set_collapsed( true )
  ->add_fields( array(
    Field::make( 'text', 'who_deskr_listing', 'Довод' )->set_width(50)
    ->set_help_text( 'Введите название довода почему мы.' ),
    ))->set_header_template( '
  <% if (who_deskr_listing) { %>
    Довод - <%- who_deskr_listing %>
    <% } %>
    ' ),
  ));

Container::make( 'theme_options', 'Our_Services', 'Our Services' )
->set_page_parent( $basic_options_container )
->add_tab(__('Название'), array(
  Field::make('text', 'our_services_title', 'Название блока')
  ->set_attribute( 'placeholder', 'Our Services' )
  ->set_help_text( 'Введите короткое название блока с нашими услугами.' ),
))
->add_tab(__('Услуги'), array(
  Field::make( 'complex', 'slide_our_services', 'Все наши услуги' )
  ->setup_labels( $assistants_labels )->set_collapsed( true )
  ->add_fields( array(

    Field::make('image', 'our_services_photo', 'Фотография')->set_width(50)
    ->set_value_type( 'url' )
    ->set_help_text( 'Загрузите фотографиию, которая характеризует услугу, размер 400рх на 250рх, формат: *.jpg.' ),

    Field::make( 'text', 'our_services_name', 'Название' )->set_width(50)
    ->set_help_text( 'Введите краткое название услуги.' ),
    Field::make( 'text', 'our_services_descr', 'Описание' )->set_width(50)
    ->set_help_text( 'Введите подробнрое описание услуги.' ),
    ))->set_header_template( '
  <% if (our_services_name) { %>
    Название работы - <%- our_services_name %>
    <% } %>
    ' ),
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
  ->setup_labels( $assistants_labels )->set_collapsed( true )
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
  Field::make( 'complex', 'slide_thestimonials', 'Перечень отзывов' )
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
   ))->set_header_template( '
  <% if (thestimonials_name) { %>
    Имя клиента - <%- thestimonials_name %>
    <% } %>
    ' ),
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
  Field::make( 'complex', 'slide_socialspytwo', 'Перечень сетей' )
  ->setup_labels( $assistants_labels )
  ->set_collapsed( true )
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