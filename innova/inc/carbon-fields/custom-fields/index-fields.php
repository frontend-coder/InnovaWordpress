
<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Field\Complex_Field;

Container::make( 'post_meta', 'Социальные сети' )
 ->where( 'post_type', '=', 'page' )
  ->where( 'post_template', '=', 'front-page.php' )
->add_tab('Название блока Команда', array(

Field::make( 'complex', 'slide_socialspyfoure', 'Социальные сети' )
->add_fields( array(
Field::make( 'text', 'social_icon_foure', 'Иконка сети' )->set_width(50)
->set_help_text( 'Вы можете определить иконку социальной сети исходя из следующего набора: icon-pinterest, icon-linkedin, icon-flickr, icon-dribbble, icon-skype, icon-instagram, icon-pinterest, icon-twitter, icon-github, icon-vk, icon-facebook.' ),
Field::make( 'text', 'social_links_foure', 'Адрес социальной сети' )->set_width(50)
->set_help_text( 'Введите адрес вашего аккаунта социальной сети.' ),
))->set_header_template( '
    <% if (social_icon_foure) { %>
        Содержимое: иконка - <%- social_icon_foure %>, адрес сети - <%- social_links_foure ? "(" + social_links_foure + ")" : "" %>
    <% } %>
')

));
?>