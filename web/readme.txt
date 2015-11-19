############################# Marche à suivre pour tester l'application WEB #############################

1. Copier le dossier "jdiy" dans la racine de votre serveur WEB (WAMPP par exemple).
2. Importer le fichier "database\createDataBase.sql" sur votre serveur WEB.
3. Importer le fichier "database\insertTuples.sql" sur votre serveur WEB.
4. Modifier les lignes 28, 29, 30 de votre fichier "jdiy\admin\php\functions.php" avec vos identifiants de la base de données:
	$dbhost = 'localhost'; 	// normalement laisser localhost fonction
	$dbuser = '<user>';	// remplacer <user> par votre identifiant (mysql)
	$dbpass = '<passowrd>';	// remplacer <passoword> par votre mot de passe (mysql)
5. Ouvrir le navigateur et acceder à "http://127.0.0.1/jdiy/admin" pour administrer le site
	utilisateur: mf@jdiy.com
	mot de passe: jdiy
6. Ouvrir le navigateur et acceder "http://127.0.0.1/jdiy/" pour voir les modifications