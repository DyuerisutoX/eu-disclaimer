<?php
  /**
  * Plugin Name: eu-disclaimer
  * Plugin URI: https://wordpress.org/
  * Description: Plugin sur la législation des produits à base de nicotine.
  * Version: 1.5
  * Author: Nicolas LAW-SHUN | Devlog.e06
  * Author URI: http://www.afpar.com
  * License: License
  */

  //Création du fichier eu-disclaimer.php à créer indirectement une extension du fichier <<functions.php>>

  //Création de la fonction ajouter au menu
  function ajouterAuMenu()
  {
    $page = 'eu-disclaimer';
    $menu = 'eu-disclaimer';
    $capability = 'edit_pages';
    $slug = 'eu-disclaimer';
    $function = 'disclaimerFonction';
    $icon = '';
    $position = 80;

    //Sur page admin:
    if(is_admin())
    {//add_menu_page permet d'afficher un raccourci du plugin
      add_menu_page($page, $menu, $capability, $slug, $function, $icon, $position);
    }

  }

  //add_action est un hook pour réaliser l'action dans 'admin_menu' <- emplacement / ajouterAuMenu <- fonction à appeler / <- priorité.
  //Va s'afficher sur le menu latéral sur la page admin
  add_action("admin_menu", "ajouterAuMenu", 10);

  // fonction à appeler lorsque l'on clic sur le menu.
  function disclaimerFonction()
  {//Charge la page disclaimer-menu.php
    require_once ('views/disclaimer-menu.php');     //<- Vérifie si le fichier disclaimer-menu.php est inclus (1 seule fois seulement)
  }

  //Requiert le fichier DisclaimerGestionTable.php
  require_once ('Model/Repository/DisclaimerGestionTable.php');

  //Si la classe DisclaimerGestionTable exist
  if (class_exists("DisclaimerGestionTable"))
  {//Création d'un objet $gerer_table
    $gerer_table = new DisclaimerGestionTable();
  }

  //Si $gerer_table non null
  if (isset($gerer_table))
  {
    register_activation_hook(__FILE__, array($gerer_table, 'creerTable'));  //à l'activation du plugin, appel la fonction creerTable pour créer la table vapo_disclaimer_options
    register_deactivation_hook(__FILE__, array($gerer_table,'supprimerTable')); //à l'désactivation du plugin, appel la fonction creerTable pour créer la table vapo_disclaimer_options
  }

  add_action('init', 'inserer_js_dans_footer');

  //insere le cdn jquery
  function inserer_js_dans_footer()
  {
    if(!is_admin()):
    //wp_register_script enregistre un nouveau script
    wp_register_script('jQuery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js', null, null, true);
    
    //wp_enqueue_script mets en file d'attente le script
    wp_enqueue_script('jQuery');

    wp_register_script('jQuery_modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js', null, null, true);
    wp_enqueue_script('jQuery_modal');

    //Ajout du JS à l'activation du plugin
    //plugins_url récupère une URL dans le répertoire plugins ou multi-plugins.
    wp_register_script ('jQuery_eu', plugins_url('assets/js/eu-disclaimer.js', __FILE__), array('jquery'), '1.1', true);    
    wp_enqueue_script('jQuery_eu');

    endif;
  }

  add_action('wp_head', 'ajouter_css', 1);

  ////insere le cdn style jquery 
  function ajouter_css()
  {
    if(!is_admin()):

    //Ajout du CSS à l'activation du plugin
    wp_register_style('eu-disclaimer-css', plugins_url('assets/css/eu-disclaimer-css.css', __FILE__), null, null, false);
    wp_enqueue_style('eu-disclaimer-css');


    //wp_register_style enregistre une feuille de style css
    wp_register_style('modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.css', null, null, false);
    //wp_enqueue_style mets en file d'attente une feuille de style CSS.
    wp_enqueue_style('modal');

    endif;
  }

  /**
  * Active le modal sans utilisation du shortcode.
  * Utilisation : add_action('nom du hook', 'nom de lafonction');
  * @author Ryad Afpa
  */
  add_action( 'wp_body_open', 'afficherModalDansBody');
  
  function afficherModalDansBody()
  {
    echo DisclaimerGestionTable::AfficherDonneModal();
  }
  
?>