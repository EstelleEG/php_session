<?php
 //  connexion DB
        // echo $_SERVER['REMOTE_ADDR'];
        if ($_SERVER['REMOTE_ADDR']=="127.0.0.1" || $_SERVER['REMOTE_ADDR']=="::1") {
            //  En local sur wamp
            try
                {
                    $bdd = new PDO("mysql:host=localhost;dbname=php_soutien", "root", "");
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(Exception $e) {die($erreur_sql='Erreur connect bd: '.$e->getMessage());}
        }
        else {
            //  Chez l(hebergeur)
            try
                {
                    $bdd = new PDO("mysql:host=[sql hote];dbname=[nom de la base]", "[utilisateur]", "[mot de passe]");
                    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(Exception $e) {die($erreur_sql='Erreur connect bd: '.$e->getMessage());}
        }
?>