# JDIY

## Installation ##

1. Copier le contenu du dossier "jdiy" dans la racine de votre serveur WEB.
2. Importer le fichier "database\createDataBase.sql" (création de la base de données).
3. Importer le fichier "database\insertTuples.sql" (données de base pour tests).
4. Modifier les lignes 28, 29, 30 de votre fichier "jdiy\admin\php\functions.php" avec vos identifiants de la base de données:
    - $dbhost = 'localhost'; //*adresse ip du serveur sql*
    - $dbuser = '<user>'; //*remplacer <user> par votre identifiant (mysql)*
    - $dbpass = '<passoword>'; //*remplacer <password> par votre mot de passe (mysql)*
4. Ouvrir le navigateur et accéder à « http://adresse_serveur/admin » pour administrer le site:
    - utilisateur: mf@jdiy.com
    - mot de passe: jdiy
5. Ouvrir le navigateur et accéder « http://adresse_serveur/ » pour voir le contenu.
