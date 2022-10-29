<?php
/*
Plugin Name: Module d'optimisation d'irisimages'
Plugin URI: https://irisimages.fr
Description: Ce plugin sert à rajouter des optimisations à Wordpress. Merci de ne pas le désactiver.
Author: Iris | irisimages
Version: 1.0
Author URI: https://irisimages.fr/
*/


/***********************/
/***** Optimisation ****/
/***********************/

// Redirige le logo de l'interface de connexion vers le site et non vers le site de Wordpress
add_filter('login_headerurl', 'wpm_custom_login_url');
function wpm_custom_login_url($url)
{
    // On définit la nouvelle URL du lien ici
    return '/';
}

add_action('admin_bar_menu', 'wpm_add_custom_items', 100);

function wpm_add_custom_items($admin_bar)
{

    // On définit d'abord notre menu principal
    $admin_bar->add_menu(array(
        'id'    => 'IrisDessine',  // On défini l'identifiant du menu
        'title' => 'IrisDessine',  // On défini le titre du menu
        'href'  => 'https://irisimages.fr',  // On défini le lien vers quoi pointera le menu
        'meta'  => array(
            'title' => __('IrisDessine'),
        ),
    ));

    // On définit un premier sous-menu
    $admin_bar->add_menu(array(
        'id'    => 'Web',
        'parent' => 'Nord-image',  // On défini le menu parent
        'title' => 'Web',  // Titre de mon sous menu
        'href'  => 'https://irisimages.fr/contact',
        'meta'  => array(
            'title' => __('Web'),
            'target' => '_blank',  // Cela signifie que le lien s'ouvrira dans un nouvel onglet
            'class' => 'menu-perso'  // On définit une class CSS si jamais on souhaite le personnaliser dans un second temps
        ),
    ));
    // On définit un second sous-menu
    $admin_bar->add_menu(array(
        'id'    => 'Aide',
        'parent' => 'IrisDessine',  // On défini le menu parent
        'title' => 'Aide',  // Titre de mon sous menu
        'href'  => 'https://irisimages.fr/contact/',
        'meta'  => array(
            'title' => __('Besoin d aide ?'),
            'target' => '_blank',  // Cela signifie que le lien s'ouvrira dans un nouvel onglet
            'class' => 'menu-perso'  // On définit une class CSS si jamais on souhaite le personnaliser dans un second temps
        ),
    ));
}

// Supression du logo de wordpress dans le back-office (en haut à gauche)
add_action('admin_bar_menu', 'wpm_remove_wp_logo', 999);
function wpm_remove_wp_logo($wp_admin_bar)
{
    $wp_admin_bar->remove_node('wp-logo');
}

// Redirection vers la page d'accueil après une déconnexion

add_action('wp_logout', 'wpm_home_redirect_after_logout');

function wpm_home_redirect_after_logout()
{
    // On redirige vers la page d'accueil
    wp_safe_redirect(home_url('/'));
    exit();
}

// Modifier les crédits dans l'administration
function wpm_admin_footer()
{
    echo "Site créé par <a href='https://irisimages.fr' target='_blank'>irisimages</a>";
}
add_filter('admin_footer_text', 'wpm_admin_footer');

// Changer le logo de l'interface d'administration
function wpdev_filter_login_head()
{

    if (has_custom_logo()) :

        $image = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
?>
        <style type="text/css">
            .login h1 a {
                background-image: url(<?php echo esc_url($image[0]); ?>);
                -webkit-background-size: contain;
                background-size: contain;
                width: 300px;
                height: 250px;
            }
        </style>
<?php
    endif;
}

add_action('login_head', 'wpdev_filter_login_head', 100);
