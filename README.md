Après avoir cloné le projet avec git clone https://github.com/w4cwac/projet_symfony

Exécutez la commande :
cd projet_symfony 

pour vous rendre dans le dossier depuis le terminal.

Ensuite, dans l'ordre taper les commandes dans votre terminal :

1 composer install afin d'installer toutes les dépendances composer du projet.

2 installer la base de donnée MySQL. Pour paramétrer la création de votre base de donnée, rdv dans le fichier .env du projet, et modifier la variable d'environnement selon vos paramètres :

DATABASE_URL=mysql://User:Password@127.0.0.1:3306/nameDatabasse?serverVersion=5.7

Puis exécuter la création de la base de donnée avec la commande : symfony console doctrine:database:create

3 importer le fichier sql dans votre base de données créé sur phpMyadmin

4 Vous pouvez maintenant accéder au site en vous connectant au serveur : symfony serve -d
