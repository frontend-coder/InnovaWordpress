
## Посадка бесплатного HTML шаблона Innova на CMS WordPress

Выполняю ручную посадку бесплатного минималистичного шаблона Whisper, испрользую базовый стартовый шаблон, его сгенерировал с помощью сервиса
underscores.me, и c использованием фрейворка Carbon Fields.

InnovaHTML - директория, в ней размещен HTML шаблон, который будет посажен на CMS WordPress
innova - в этот каталог будет заливаться тема WordPress в процессе посадки

## Как подключить Carbon Fields 2.2 к теме Innova на CMS WordPress

Я скачал в официального сайта Carbon Fields - * [Carbon Fields v.2.2.0](https://carbonfields.net/release-archive/), полученный архив разорхивировал,
полученный каталог carbon-fields поместил в подкаталог inc/, она по умолчанию размещена в папке темы innova.
В подкаталоге  carbon-fields создал подкаталог custom-fields, в нем создал несколько файлов(custom-fields.php, index-fields.php), в которых буду выполнять настройку панель управления темой.

### В файле function.php подключаю фреймворк

#### Первый вариант подключения фреймворка

```

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {

	require get_template_directory() . '/inc/carbon-fields/custom-fields/custom-fields.php';
require get_template_directory() . '/inc/carbon-fields/custom-fields/index-fields.php';
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
//    require_once( ABSPATH . '/inc/carbon-fields/vendor/autoload.php' );
require get_template_directory() . '/inc/carbon-fields/vendor/autoload.php';
  \Carbon_Fields\Carbon_Fields::boot();
}
```

#### Второй вариант подключения фреймворка

```
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
require_once __DIR__  . '/inc/carbon-fields/custom-fields/custom-fields.php';
require_once __DIR__  . '/inc/carbon-fields/custom-fields/index-fields.php';
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
//    require_once( ABSPATH . '/inc/carbon-fields/vendor/autoload.php' );
require_once __DIR__  . '/inc/carbon-fields/vendor/autoload.php';
    \Carbon_Fields\Carbon_Fields::boot();
}

```

### В файле custom-fields.php активиирую опции темы

```

<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

    Container::make( 'theme_options', __( 'Theme Options' ) )
        ->add_fields( array(
            Field::make( 'text', 'crb_text', 'Text Field' ),
            Field::make( 'text', 'crb_text11', 'Text Field' ),
        ) );
?>

```

### В файле index-fields.php активирую метабоксы

В этом примере я выполняю настройку метабоксов, которые будут привязываться к шаблону страницы front-page.php(главной страницы)

```
<?php
/*
Template Name: main-page-tamplate
Template Post Type: post, page
*/
?>

```

```
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
```






## Связаться по вопросам верстки:

* [facebook](https://www.facebook.com/frontendercode)
* [github](https://github.com/frontend-coder)
* [skype:webrabcom](href="skype:webrabcom")
* [telegram](https://t.me/frontendcoder)

## Портфолио
* [Портфолио](https://frontend-coder.github.io)
