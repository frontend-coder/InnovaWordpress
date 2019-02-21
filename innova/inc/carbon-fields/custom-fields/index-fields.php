<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;


Container::make( 'post_meta', 'Настройка блока команды' )
->show_on_post_type( 'page')
->show_on_template('front-page.php')
->add_tab('Название блока Команда', array(
 Field::make('text', 'name_comand_block', 'Название блока Наша команда')
 ->set_help_text( 'Предоставьте информацию о участинках нашей комонды, по умолчанию пребуется предоставить информацию по 4 специалистам.' ),
        ))
->add_tab('Первый участник команды', array(
Field::make('separator', 'first_separator_number', 'Данные о сотруднике'),
Field::make('image', 'first_foto_number', 'Фотография')->set_value_type('url')->set_width(33)
->set_help_text( 'Вставьте фотографию вашего сотрудника. Рекомендую размер файла 294px X 294px.' ),

Field::make('text', 'first_name_number', 'Имя сотрудника')->set_width(33)
->set_help_text( 'Введите имя и фамилию вашего сотрудника.' ),

Field::make('text', 'first_text_number', 'Краткое описание')->set_width(33)
->set_help_text( 'Предоставьте краткое описание сотрудника.' ),
Field::make('separator', 'firsttwo_separator_number', 'Социальные аккаунты'),
Field::make( 'complex', 'slide_socialspy', 'Социальные сети' )
->add_fields( array(
Field::make( 'text', 'social_icon', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template('
<# if (social_links) { #>
{{ social_links }} {{ social_links ? " " + "social_links" : "" }}
<# } #>')
))
->add_tab('Второй участник команды', array(

Field::make('separator', 'two_separator_number', 'Данные о сотруднике'),
Field::make('image', 'two_foto_number', 'Фотография')->set_value_type('url')->set_width(33)
->set_help_text( 'Вставьте фотографию вашего сотрудника. Рекомендую размер файла 294px X 294px.' ),

Field::make('text', 'two_name_number', 'Имя сотрудника')->set_width(33)
->set_help_text( 'Введите имя и фамилию вашего сотрудника.' ),

Field::make('text', 'two_text_number', 'Краткое описание')->set_width(33)
->set_help_text( 'Предоставьте краткое описание сотрудника.' ),
Field::make('separator', 'twotwo_separator_number', 'Социальные аккаунты'),

Field::make( 'complex', 'slide_socialspytwo', 'Социальные сети' )
->add_fields( array(
Field::make( 'text', 'social_icon_two', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links_two', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template('
<# if (social_links_two) { #>
{{ social_links_two }} {{ social_links_two ? " " + "social_links_two" : "" }}
<# } #>')

))

->add_tab('Третий участник команды', array(
Field::make('separator', 'three_separator_number', 'Данные о сотруднике'),
Field::make('image', 'three_foto_number', 'Фотография')->set_value_type('url')->set_width(33)
->set_help_text( 'Вставьте фотографию вашего сотрудника. Рекомендую размер файла 294px X 294px.' ),

Field::make('text', 'three_name_number', 'Имя сотрудника')->set_width(33)
->set_help_text( 'Введите имя и фамилию вашего сотрудника.' ),

Field::make('text', 'three_text_number', 'Краткое описание')->set_width(33)
->set_help_text( 'Предоставьте краткое описание сотрудника.' ),
Field::make('separator', 'threetwo_separator_number', 'Социальные аккаунты'),
Field::make( 'complex', 'slide_socialspythree', 'Социальные сети' )
->add_fields( array(
Field::make( 'text', 'social_icon_three', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links_three', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template('
<# if (social_links_three) { #>
{{ social_links_three }} {{ social_links_three ? " " + "social_links_three" : "" }}
<# } #>')

))

->add_tab('Четвертый учаcтник команды', array(
Field::make('separator', 'foure_separator_number', 'Данные о сотруднике'),
Field::make('image', 'foure_foto_number', 'Фотография')->set_value_type('url')->set_width(33)
->set_help_text( 'Вставьте фотографию вашего сотрудника. Рекомендую размер файла 294px X 294px.' ),

Field::make('text', 'foure_name_number', 'Имя сотрудника')->set_width(33)
->set_help_text( 'Введите имя и фамилию вашего сотрудника.' ),

 Field::make('text', 'foure_text_number', 'Краткое описание')->set_width(33)
->set_help_text( 'Предоставьте краткое описание сотрудника.' ),

Field::make('separator', 'fouretwo_separator_number', 'Социальные аккаунты'),

Field::make( 'complex', 'slide_socialspyfoure', 'Социальные сети' )
->add_fields( array(
Field::make( 'text', 'social_icon_foure', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links_foure', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template('
<# if (social_links_foure) { #>
{{ social_links_foure }} {{ social_links_foure ? " " + "social_links_foure" : "" }}
<# } #>')

));

// второй контейнер начало

Container::make( 'post_meta', 'Настройка блока преимуществ' )
->show_on_post_type( 'page')
->show_on_template('front-page.php')
->add_tab('Название блока Команда', array(
 Field::make('text', 'name_features_block', 'Название блока Наша команда')
 ->set_help_text( 'Предоставьте информацию о участинках нашей комонды, по умолчанию пребуется предоставить информацию по 4 специалистам.' ),
  ))
->add_tab('Перечень преимуществ', array(
Field::make( 'complex', 'slide_features', 'Перечень преимуществ' )
->add_fields( array(
Field::make( 'text', 'features_foto', 'Иконка преимущества' )->set_width(50)
->set_help_text( 'Вы можете определить иконку блока преимущества исходя из набора иконочных шрифтов iconmoon, к примеру icon-heart, icon-umbrella.' ),
Field::make( 'text', 'features_name', 'Название блока' )->set_width(50)
->set_help_text( 'Введите краткое название блока преимущества, используйте 2 - 3 короких слова.' ),
Field::make( 'text', 'features_text', 'Описание блока' )->set_width(50)
->set_help_text( 'Введите подробное описание блока блока преимущества, ориентировочно используйте 18 - 20 слова.' ),
))->set_header_template('
<# if (features_name) { #>
{{"Название блока: " + features_name + " " }}
<# } #>'),
));
// третий когнтейнер начало

?>