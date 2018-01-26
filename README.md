Louvre
======

Projet 4 : Développez un back-end pour un client

# Installation
## 1. Récupérer le code
Vous avez deux solutions pour le faire :

1. Via Git, en clonant ce dépôt ;

    * Tout d'abord, ouvrez le terminal et placez-vous dans le répertoire prêt à recevoir l'application.
    * Lancez la commande suivante :

            git clone https://github.com/Wil4Cs/Louvre.git
 
    *   Toujours dans le terminal, placez-vous à la racine du projet.

2. Via le téléchargement du code source en une archive ZIP, à cette adresse : https://github.com/Wil4Cs/louvre.git

    * Décompressez ce fichier et placez-le dans le répertoire prêt à recevoir l'application.
    * Ouvrez votre terminal et placez-vous à la racine du projet fraichement créé.

## 2. Télécharger les vendors
Avec Composer bien évidemment :

    composer install

Renseignez les champs demandés par composer lors de l'installation :

* database_host:
* database_port:
* database_name:
* database_user:
* database_password:
* mailer_transport:
* mailer_host: Si vous utilisez gmail [Gmail avec Symfony](https://symfony.com/doc/3.4/email/gmail.html)
* mailer_user:
* mailer_password:
* secret:
* app_webmaster: Facultatif - Renseignez votre nom ou celui de l'entreprise par exemple

## 3. Créez la base de données
Si la base de données que vous avez renseignée dans l'étape 2 n'existe pas déjà, créez-la :

    php bin/console doctrine:database:create

Puis créez les tables correspondantes au schéma Doctrine :

    php bin/console doctrine:schema:update --dump-sql
    php bin/console doctrine:schema:update --force

## 4. Publiez les assets
Publiez les assets dans le répertoire web :

    php bin/console assets:install web
    
### ENJOY !!!
