# Administrateur Web

Ce projet combine des éléments des trois projets précédents. Il avance sur ces concepts en ajoutant des contrôles d'administrateur. L'administrateur peut définir le contenu disponible pour les utilisateurs. L'accès administrateur est protégé par un mot de passe à l'aide de la fonctionnalité Apache `.htaccess`. Certaines fonctionnalités supplémentaires ont été ajoutées ainsi que des améliorations de la mise en page et de la cohérence de l'application.

Fichiers inclus :
- `indexUser.php` -- Le script pour le côté utilisateur de l'application permet de visualiser et de télécharger des fichiers dans la galerie d'images.
- `user-styles.css` -- La feuille de style CSS utilisée pour cette application.
- **admin** -- Répertoire administrateur.
  - `indexAdmin.php` -- Script avec fonctionnalité de gestion de fichiers et de bases de données, réservé à l'usage de l'administrateur.
  - `.htaccess` -- Fichier de contrôle d'accès Apache.
  - `.htpasswd` -- Le mot de passe haché de l'administrateur de l'application.
- **images** -- Répertoire de données d'image utilisé pour tester l'application.
- `tp4_db.sql` -- Le script SQL pour construire le schéma de base de données utilisé pour cette application.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_4_Web_Admin/assets/admin_page.png">
</p>

## La page d'administrateur

Illustrée ci-dessus, cette page permet à l'administrateur de gérer l'application. L'accès à cette page est contrôlé via le mécanisme `.htaccess` d'Apache. Il y a plusieurs étapes pour configurer ce contrôle d'accès et je vais les expliquer ici car elles se rapportent à Ubuntu Linux. Cette méthode peut être utilisée sur n'importe quel système d'exploitation compatible avec Apache, bien que les étapes de configuration puissent différer.

### Configurer les contrôles d'accès

Afin de définir des contrôles d'accès pour un répertoire Apache, nous devons d'abord déclarer le répertoire dans le fichier de configuration Apache "sites-available". Ceci est accompli en ajoutant le texte suivant à */etc/apache2/sites-available/000-default.conf* :
```
<Directory /var/www/html/admin> 
	Options Indexes Includes FollowSymLinks MultiViews 
	AllowOverride All 
	Require all granted 
</Directory>
```
Ensuite, nous devons définir le nom d'utilisateur et le mot de passe qui seront utilisés pour accéder au répertoire admin. J'ai accompli cela en utilisant l'utilitaire *htpasswd*. htpasswd utilise une version modifiée du hachage md5 pour empêcher l'accès non autorisé à un attaquant qui pourrait accéder à ce fichier. L'algorithme de hachage utilisé par htpasswd "salts" le hachage de sorte que chaque nouveau mot de passe génère un hachage unique, même si nous utilisons le même mot de passe. la commande suivante montre comment créer un mot de passe pour l'utilisateur admin.
```
htpasswd -c /admin/.htpasswd admin password123
```
Cette commande générera un fichier de mot de passe haché pour l'utilisateur 'admin' à la destination *admin/*.

Enfin, nous devons ajouter un fichier `.htaccess` à notre répertoire protégé, */admin/.htaccess*. Cela définira quels utilisateurs peuvent accéder à notre répertoire d'administration. Il définit également où se trouvent les mots de passe pour l'authentification.. Veuillez consulter le fichier `.htaccess` inclus avec ce repo pour plus de détails.

Note: Il est probable que vous deviez accorder à Apache l'accès au répertoire et aux fichiers pour qu'il puisse accéder au fichier *.htpasswd*. Cela peut être accompli avec la commande suivante :
```
chown -R www-data:www-data /var/www/html/admin
```
Avec tout configuré, redémarrez Apache et maintenant, lorsque vous accédez à *http://localhost/admin/indexAdmin.php*, vous verrez la boîte de dialogue contextuelle suivante.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_4_Web_Admin/assets/admin_login.png">
</p>

### Arborescence des répertoires

L'arborescence des répertoires a été améliorée par rapport à l'application précédente. Il trace maintenant une ligne de connexion entre les répertoires et les fichiers pour illustrer plus clairement la disposition de l'arborescence des répertoires. La saisie d'un répertoire n'effectue plus une recherche mais constitue plutôt le mécanisme de définition du répertoire racine de la galerie d'images. Le filtre a le même objectif. C'est-à-dire que les résultats de la recherche dans le répertoire définiront le contenu de l'image visible pour les utilisateurs de la galerie d'images accessible au public.

<p align="center">
  <img style="width: 50%; height:50%; text-align: center;" src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_4_Web_Admin/assets/source_tree.png">
</p>

### Image deletion

Vous avez peut-être déjà remarqué que les images affichées sur la page d'administration comportent un bouton supplémentaire, "Remove". Cela permet à l'administrateur de supprimer sélectivement des images de la base de données. Une image supprimée ne sera plus visible pour les utilisateurs.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_4_Web_Admin/assets/remove_image.png">
</p>

## La page utilisateur - Galerie d'images

La page utilisateur (galerie d'images) reprend tous les éléments développés dans les projets précédents. Cela inclut le téléchargement d'une image, le zoom sur l'image au survol de la souris et les contrôles de pagination au bas de la page.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_4_Web_Admin/assets/user_gallery.png">
</p>

### Ajouts de pages utilisateur

Si vous avez pris le temps de tester le projet précédent, vous remarquerez peut-être l'ajout de deux éléments de sélection déroulants. La sélection déroulante située à côté des commandes de téléchargement de fichiers permet la classification des images de la galerie. Les catégories disponibles sont définies par les noms de répertoire situés dans le répertoire racine des images. En bas de la page, au-dessus des contrôles de pagination, la deuxième popup bascule la visibilité des images. Sélectionnez une catégorie et vous ne verrez que les images de cette catégorie. 

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_4_Web_Admin/assets/category_select.png">
</p>



