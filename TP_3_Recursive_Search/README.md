# Parcours récursif des arborescences de répertoires

Ce projet présente certains éléments des deux projets précédents tout en ajoutant une fonction de recherche récursive qui permet de cartographier les arborescences de répertoires et de filtrer les résultats par une sous-chaîne définie par l'utilisateur. Après avoir cartographié une arborescence de répertoires définie par l'utilisateur, le programme affiche toutes les images trouvées (type jpg et png uniquement) dans la galerie d'images adjacente.

Fichiers inclus :
- `index_r.php` -- Ceci est le programme principal, exécutez-le depuis votre navigateur Web pour tester l'application.
- `recurs_style.css` -- Ceci est le CSS Stylesheet utilisée par `index_r.php`.
- `file_tree.sql` -- Le script SQL pour construire le schéma de base de données utilisé pour cette application.
- `TP_3_Comments.php` -- Ceci est juste la fonction récursive d'origine avec des commentaires ajoutés pour expliquer sa fonctionnalité.

Le programme fonctionne en lançant un parcours récursif d'un répertoire, défini dans le champ "Search directory". Tous les fichiers et sous-répertoires trouvés sont enregistrés dans une base de données MySQL. Après avoir terminé la fonction récursive, le programme lance une deuxième fonction récursive en utilisant les données de la base de données MySQL pour reconstruire la structure du répertoire sous forme de liste HTML. Toutes les images jpg et png trouvées dans le répertoire ciblé seront alors affichées dans la galerie d'images.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_3_Recursive_Search/assets/app_overview.png">
</p>

## Search Directory

Le programme est capable de rechercher n'importe quel répertoire accessible par l'utilisateur sur le serveur.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_3_Recursive_Search/assets/other_dirs.png">
</p>

## Filtrer les résultats de la recherche

En saisissant une chaîne de caractères dans le champ "Filter search by" avant de lancer une recherche. Les résultats de la recherche seront limités aux seuls fichiers contenant la chaîne de caractères saisie. Cela peut également être utile pour afficher des types d'images spécifiques. En effet, seuls les fichiers trouvés dans le résultat final de la recherche seront affichés. Ainsi, si, par exemple, nous saisissons 'png' dans le champ de filtre, la recherche ne renverra que des fichiers png (ou d'autres fichiers avec un nom contenant les caractères 'p', 'n' et 'g' dans cet ordre).

Noter que la recherche récursive passera toujours sur chaque fichier de l'arborescence de répertoires ciblée. Les résultats de la recherche sont filtrés avant l'archivage dans la base de données MySQL.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_3_Recursive_Search/assets/search_filter.png">
</p>

## Pagination

Lorsque plus de 6 images sont trouvées dans la recherche récursive, des pages de galerie d'images supplémentaires sont mises à disposition pour visualisation. Ils sont rendus accessibles par les liens du bouton de pagination affichés sous la galerie d'images. Des pages supplémentaires seront mises à disposition si nécessaire afin que l'utilisateur puisse toujours accéder à toutes les images disponibles sur le serveur.

## Survoler l'image

L'application dispose également d'une fonction de zoom automatique lorsque la souris survole une image. Cela restaure également l'image à son rapport d'aspect d'origine. Cette fonctionnalité est implémentée en utilisant du CSS pur.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_3_Recursive_Search/assets/image_hover.png">
</p>


