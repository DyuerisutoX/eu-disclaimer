<?php
    //définition du chemin d'accès à la classe DisclaimerOptions
    define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
    //Importer la classe DisclaimerOptions qui se trouve dans notre fichier DisclaimerOptions.php
    include( MY_PLUGIN_PATH . '../Entity/DisclaimerOptions.php');

    //Création de notre classe DisclaimerGestionTable et de ses fonctions
    class DisclaimerGestionTable
    {
        /**
        * function creerTable()
        * Permet de créer la table vapo_disclaimer_options dans la BDD
        * @return Ø
        */
        public function creerTable()
        {
            // instanciation de la classe DisclaimerOptions
            $message = new DisclaimerOptions();

            // on alimente l'objet message avec les valeurs par défaut grâce au setter (mutateur)
            $message->setMessageDisclaimer("Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans pour visiter ce site ?");
            $message->setRedirectionko("https://www.google.com/");

            global $wpdb;   //est utilisée pour interagir avec une base de données sans avoir besoin d'utiliser des instructions SQL brutes

            //création de la table vapo_disclaimer_options
            $tableDisclaimer = $wpdb->prefix.'disclaimer_options';

            //Dans la database uservapobar
            if ($wpdb->get_var("SHOW TABLES LIKE $tableDisclaimer") != $tableDisclaimer) 
            {//Si aucune des tables présentes ne correspondent pas à la valeur de $tableDisclaimer (=vapo_disclaimer_options), on créer la table
             $sql = "CREATE TABLE $tableDisclaimer ( id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, message_disclaimer TEXT NOT NULL, redirection_ko TEXT NOT NULL )
             ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; ";

                // Message d'erreur
                if(!$wpdb->query($sql))
                {
                    die("Une erreur est survenue, contactez le développeur du plugin...");
                }

                // Insertion du message par défaut
                $wpdb->insert($wpdb->prefix . 'disclaimer_options',array('message_disclaimer' => $message->getMessageDisclaimer(),'redirection_ko' => $message->getRedirectionko(),), 
                array('%s', '%s'));

                $wpdb->query($sql);
            }
        }

        /**
        * function supprimerTable()
        * Permet de suprimer la table vapo_disclaimer_options dans la BDD
        * @return Ø
        */
        public function supprimerTable()
        {
            // $wpdb sert à récuperer l'objet contenant les informations relatives à la base de données.
            global $wpdb;
            $table_disclaimer = $wpdb->prefix."disclaimer_options";     //vapo_disclaimer_options
            $sql = "DROP TABLE $table_disclaimer";                      //Supprime la table
            $wpdb->query($sql);
        }

        /**
         * function insererDansTable()
         * Insere les nouveaux message et liens de redirection dans la table vapo_disclaimer_options
         * @param $option
         * @return $message_inserer_valeur
         */
        function insererDansTable(DisclaimerOptions $option)
        {
            global $wpdb;
            try
            {
                $table_disclaimer = $wpdb->prefix.'disclaimer_options';

                //Met à jour dans la table vapo_disclaimer_options le message de disclaimer
                $sql = $wpdb->prepare("UPDATE $table_disclaimer SET message_disclaimer = '%s', redirection_ko = '%s' WHERE id_disclaimer = %s", $option->getMessageDisclaimer(), 
                $option->getRedirectionko(), 1);
                
                $wpdb->query($sql);         //Exécute une requête de base de données MySQL, en utilisant la connexion à la base de données actuelle.

                //Msg confirmation
                return $message_inserer_valeur = '<span style="color:green; font-size:16px;">Les données ont correctement été mises à jour !</span>';
    
            }

            catch (Exception $e)
            {//Msg erreur
                return $message_inserer_valeur = '<span style="color:red; font-size:16px;">Une erreur est survenue !<span>';
            }
        }

        function recupDonnee()
        {
            global $wpdb;
            $table_disclaimer= $wpdb->prefix.'disclaimer_options';
            $sql=$wpdb->prepare(
                                    "
                                    SELECT message_disclaimer,redirection_ko
                                    FROM $table_disclaimer"
                                );

            $resultat = $wpdb->get_results($sql,ARRAY_A);
             

            return $resultat;


        }

        /**
        * function AfficherDonneModal()
        * Affiche la fenetre modal
        * @return string
        */

        function AfficherDonneModal()
        {
            global $wpdb;
            $query = "SELECT * FROM $wpdb->prefix"."disclaimer_options";       //Sélectionne depuis la table vapo_disclaimer_options
            $row = $wpdb->get_row($query);                          //Récupère une ligne de la base de données
            $message_disclaimer = $row->message_disclaimer;         //Stocke dans la variable $message_disclaimer la valeur de la colonne message_disclaimer de la bdd
            $lien_redirection = $row->redirection_ko;               //Stocke dans la variable $lien_redirection la valeur de la colonne redirection_ko de la bdd

            return '<div id="monModal" class="modal">
                        <p>Le vapobar, vous souhaite la bienvenue !</p>
                        <p>' .$message_disclaimer.'</p>
                        <a href="' .$lien_redirection. '" type="button" class="btn-red">Non</a>
                        <a href="" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer">Oui</a>

                    </div>';
        }

    }

       
?>