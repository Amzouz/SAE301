# WEB3 Starter

> Une base de travail pour lancer son prochain projet front.
> Réalisé pour les cours de WEB3.

## Tooling

Ce projet propose une implémentation des librairies vues en cours magistral.
Il utilise les packages suivantes:

- ViteJS
- SASS

## Prerequis

- Installer nodeJS sur sa machine
- Avoir **vscode**
- Ajouter le plugin [EditorConfig](https://marketplace.visualstudio.com/items?itemName=EditorConfig.EditorConfig) à **vscode**
- Ajouter le plugin [Prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode) à **vscode**

Ces plugins sont ensuite configurés par le fichier de config local `.vscode/settings.json` et le fichier de config `.editorconfig`.

## Installation

- Ouvrir le dossier dans **VSCode**
- Dans le terminal lancer la commande `git clone https://github.com/soleneggd/web3-starter.git NOM_DU_PROJET`
- Lancer la commande `npm install`
- **Optionnel :** Supprimer le dosier git: `rm -rf .git`
- **Optionnel :** Mettre à jour `name` dans le fichier `package.json`
- **Optionnel :** Initialiser git avec la commande `git init`

## Utilisation

### Lancer le serveur de dev

- Dans **vscode**, ouvrir la fenêtre de terminal (Terminal > Nouveau terminal)
- Lancer la commande `npm run dev`

### Comment stocker mes assets

Pour ajouter du css/scss :

- Ajouter les fichiers dans le dossier css
- Faire les imports nécessaires dans `src/app.scss`

Pour ajouter des images :

- Utiliser les dossiers `public/img` et `public/svg`
- Pour les appeler dans `index.html`, procéder comme suit: `<img src="/img/nom-du-fichier.jpg">`.

## Générer le site pour la production

- Dans **vscode**, si ce n'est pas déjà fait, ouvrir la fenêtre de terminal (Terminal > Nouveau terminal)
- Lancer la commande `npm run build`
- Lancer `npm run preview` pour prévisualiser le site en local
- Le dossier `/dist` comporte le site prêt à être mis en ligne 🎉
