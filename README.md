# PetitCommer-cant

pré-requis: 
- PHP 7.2.5 a minima : pour tester votre version, dans un terminal « php --version »
- une base de données en MySQL, accessible via phpMyAdmin(wampserver)
-composer 
	- Go to le site officiel : https://getcomposer.org/download/ qui vous indique les 4 lignes de
	commande à taper, les unes après les autres.
	- A la fin de l’installation, vous devez avoir un unique fichier nommé « composer.phar » :
	renommez-le « composer » (sans l’extension).
	- Pour le tester, taper « composer --version » qui doit vous retourner un numéro de version et une
	date d’installation.

Installation du projet
-php bin/console cache:clear --env=dev
-aller dans le fichier .env et entrer les infos de la dbb de wampserver
	DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?
	serverVersion=5.7
-php bin/console doctrine:database:create
-php bin/console doctrine:schema:update --dump-sql
-php bin/console doctrine:schema:update --force
-php bin/console doctrine:fixtures:load

demarrer 
php bin/console server:run
