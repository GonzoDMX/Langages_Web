# PHP Image Viewer a.k.a. "Televerser une Image"

Il s'agit d'un projet démontrant le téléversement d'une image. Écrit en PHP, HTML et CSS, ce projet implémente une base de données MySQL pour l'archivage des données d'image. Les images envoyées au serveur Web sont stockées sur le serveur, puis rendues disponibles pour visualisation.

Lorsqu'une image est télécversée, à l'aide des boutons en haut de la page, la galerie de visualisation d'images est immédiatement mise à jour. Les images sont affichées de la plus récente (en haut à gauche) à la plus ancienne (en bas à droite). Les données d'image (nom, type, taille et date de téléchargement) sont affichées sous chaque image.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_2_Televerser_une_Image/assets/page_overview.png">
</p>

## Pagination

Lorsque plus de 8 images ont été téléchargées sur le serveur, des pages de galerie d'images supplémentaires sont mises à disposition pour visualisation. Ils sont rendus accessibles par les liens du bouton de pagination affichés sous la galerie d'images. Des pages supplémentaires seront mises à disposition si nécessaire afin que l'utilisateur puisse toujours accéder à toutes les images disponibles sur le serveur.

## Survoler l'image

L'application dispose également d'une fonction de zoom automatique lorsque la souris survole une image. Cela restaure également l'image à son rapport d'aspect d'origine. Cette fonctionnalité est implémentée en utilisant du CSS pur.

<p align="center">
  <img src="https://github.com/GonzoDMX/Langages_Web/blob/main/TP_2_Televerser_une_Image/assets/hover_demo.png">
</p>

