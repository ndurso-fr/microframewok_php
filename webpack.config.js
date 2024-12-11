const Encore = require('@symfony/webpack-encore');

Encore
    // Répertoire de sortie pour les fichiers compilés
    .setOutputPath('public/dist/')
    // Chemin public utilisé pour les assets dans le HTML
    .setPublicPath('/dist')
    // Ajouter les entrées principales
    .addEntry('app', './assets/js/app.js')
    //.addStyleEntry('styles', './assets/css/app.scss')
    // Permet d'utiliser SCSS
    .enableSassLoader()
    // Permet de traiter les fichiers CSS avec Autoprefixer
    .enablePostCssLoader()
    // Supprime les anciens fichiers dans "public/dist" avant chaque build
    .cleanupOutputBeforeBuild()
    // Permet les notifications pendant le build (optionnel)
    .enableBuildNotifications()
    // Ajoute le support pour ES6+ en JS
    .enableSingleRuntimeChunk()


;

module.exports = Encore.getWebpackConfig();

