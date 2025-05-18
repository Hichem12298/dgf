# Projet Hébergé sur GitHub

## Configuration de la Base de Données

1. Assurez-vous d'avoir XAMPP ou un autre serveur local installé.
2. Importez le fichier `arbres.sql` ou `utilisateur.sql` dans votre base de données locale via phpMyAdmin ou un outil similaire.
3. Configurez le fichier `db.php` en suivant le modèle fourni dans `db.example.php`.

## Lancer le Projet

1. Clonez ce dépôt :
   ```bash
   git clone <lien_du_dépôt>
   ```
2. Placez les fichiers dans le dossier `htdocs` de XAMPP.
3. Démarrez Apache et MySQL depuis le panneau de contrôle XAMPP.
4. Accédez au projet via `http://localhost/dissier` dans votre navigateur.

## Rendre le Projet Accessible à Distance

1. Configurez MySQL pour autoriser les connexions distantes :
   - Modifiez `my.ini` et remplacez `bind-address = 127.0.0.1` par `bind-address = 0.0.0.0`.
2. Configurez le pare-feu pour autoriser les ports 80 (HTTP) et 3306 (MySQL).
3. Configurez le NAT (Port Forwarding) sur votre routeur pour rediriger ces ports vers votre machine locale.
4. Utilisez votre adresse IP publique pour accéder au projet depuis l'extérieur.

## Sécurité
- Assurez-vous d'utiliser des mots de passe forts pour votre base de données.
- Limitez les adresses IP autorisées à se connecter à votre serveur.