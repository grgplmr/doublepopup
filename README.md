# WP Double Popups

Ce plugin WordPress permet d'afficher deux popups distincts : un principal sur la page d'accueil et un popup de sortie (exit intent). Chaque popup est entièrement personnalisable depuis l'interface d'administration.

## Installation

1. Copiez le dossier `wp-double-popups` dans le répertoire `wp-content/plugins/` de votre site WordPress.
2. Activez le plugin depuis l'interface **Extensions** de WordPress.
3. Rendez‑vous ensuite dans **Réglages > Double Popups** pour configurer le contenu et le style des popups.

## Emplacement des fichiers

- `wp-double-popups.php` : fichier principal du plugin.
- `includes/` : contient les classes de gestion de l'administration et de l'affichage frontend.
- `assets/` : feuilles de style, scripts JS et capture d'écran.

## Configuration via l'admin

Dans **Réglages > Double Popups**, vous pouvez :

- Activer ou désactiver chaque popup.
- Modifier le texte affiché (éditeur WordPress intégré).
- Choisir la police, la taille et les couleurs de texte et de fond.
- Prévisualiser le rendu directement dans la page de réglages après enregistrement.

![Capture d'écran des réglages](assets/screenshot.svg)

## Fonctionnement des popups

- **Popup principal** : s'affiche automatiquement sur la page d'accueil après quelques secondes. Il n'apparaît qu'une seule fois par session grâce au `sessionStorage` du navigateur.
- **Popup de sortie** : détecte l'intention de quitter la page (mouvement de souris vers la barre d'adresse) et s'affiche alors. Là encore, un affichage unique par session est assuré.

## Prérequis

- WordPress 5.0 ou supérieur.
- PHP 7.0 ou supérieur.

