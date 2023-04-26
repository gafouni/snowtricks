## Description
* Snowtricks est un site communautaire de partage de figures de snowboard,  ce projet m'a permis d'apprendre le framework Symfony.  Les diagrammes UML se trouvent dans le dossier "Diagrams".  Versions: PHP 7.4.12  Symfony 5.4
* L'analyse SymfonyInsight est disponible avec le lien suivant: https://insight.symfony.com/projects/d47c2a56-e3d7-4c81-ad93-7b2b5aaeac2b/analyses/61
---------------------------------
## Installation
* Cloner le depot:  git clone https://github.com/gafouni/snowtricks.git

* Telecharger les dependances:  
  composer install 
  
* Parametrer la base de donnees:  
  editer le fichier intitule ".env", modifier les valeurs de parametrage de la base de donnees 
  
* Creer la base de donnees: 
  importer le fichier "snowtricks.sql" situe a la racine du projet

* Identifiants de l'administrateur:  
  pour se connecter en tant qu'administrateur, utiliser :  
  email : js@snow.com  
  mot de passe : jimmysweat  
  
* Envoi de mails:  
  Si vous souhaitez utiliser un serveur de mail afin d'envoyer des mails,  vous pouvez le configurer dans le fichier ".env", dans la partie MAILER_URL.  
  Pour ce projet, j'ai utilise Mailtrap pour le transport de mails.
  
* Lancer le projet:  
  lancer le serveur de developpement (Xampp ou autre)  
  lancer le serveur de symfony: symfony server:start  
