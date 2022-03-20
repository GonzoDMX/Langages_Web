# Parcours récursif des arborescences de répertoires

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_3_Recursive_Search/assets/app_overview.png">
</p>


<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_3_Recursive_Search/assets/other_dirs.png">
</p>

## Filtrer les résultats de la recherche

En saisissant une chaîne de caractères dans le champ "Filter search by" avant de lancer une recherche. Les résultats de la recherche seront limités aux seuls fichiers contenant la chaîne de caractères saisie. Cela peut également être utile pour afficher des types d'images spécifiques. En effet, seuls les fichiers trouvés dans le résultat final de la recherche seront affichés. Ainsi, si, par exemple, nous saisissons 'png' dans le champ de filtre, la recherche ne renverra que des fichiers png (ou d'autres fichiers contenant les caractères 'p', 'n' et 'g' dans cet ordre).

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


