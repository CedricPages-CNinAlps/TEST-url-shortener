/*
 @licstart  The following is the entire license notice for the JavaScript code in this file.

 The MIT License (MIT)

 Copyright (C) 1997-2020 by Dimitri van Heesch

 Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 and associated documentation files (the "Software"), to deal in the Software without restriction,
 including without limitation the rights to use, copy, modify, merge, publish, distribute,
 sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in all copies or
 substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING
 BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

 @licend  The above is the entire license notice for the JavaScript code in this file
*/
var NAVTREE =
[
  [ "URL Shortener", "index.html", [
    [ "TEST-url-shortener", "index.html", null ],
    [ "Exercice technique Laravel", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html", [
      [ "1. Installation et Configuration", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md1", [
        [ "1.1 Création du projet", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md2", null ],
        [ "1.2 Configuration de SQLite", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md3", null ],
        [ "1.3 Mise en place de l'Authentification simple", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md4", null ]
      ] ],
      [ "2. Mise en place des Modèles et Migration", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md5", [
        [ "2.1 Migration", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md6", null ],
        [ "2.2 Modèle", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md7", null ],
        [ "2.3 Lancement de la migration", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md8", null ]
      ] ],
      [ "3. Mise en place du contrôleur, routes et views", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md9", [
        [ "3.1 Controller ShortUrlController", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md10", null ],
        [ "3.2 Création des routes", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md11", null ],
        [ "3.3 Mise en place des views", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md12", null ],
        [ "3.4 Controller de redirection", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md13", [
          [ "3.4.1 Controller", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md14", null ],
          [ "3.4.2 Mise en place d'une route publique", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md15", null ],
          [ "3.4.3 Création d'une view lien plus valable", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md16", null ],
          [ "3.4.4 Mise en place d'un champ 'deleted_at' dans ma table short_urls", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md17", null ]
        ] ]
      ] ],
      [ "4. Mise en place des tests unitaires / fonctionnels", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md18", [
        [ "4.1 Tests zone d'administration", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md19", null ],
        [ "4.2 Test pour la redirection", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md20", null ],
        [ "4.3 Factory pour ShortUrl", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md21", null ],
        [ "4.4 Lancement des tests", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md22", null ]
      ] ],
      [ "5. Réalisation des bonus", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md23", [
        [ "5.1. Compteur", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md24", null ],
        [ "5.2. Cron de suppression automatique", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md25", null ]
      ] ],
      [ "6. Génération des images pour utilisation sous Docker/Podman", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md26", [
        [ "6.1. Edition d'un Dockerfile", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md27", null ],
        [ "6.2. Edition d'un docker-compose", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md28", null ],
        [ "6.3. Fichier Nginx pour servir Laravel", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md29", null ],
        [ "6.4. Commandes de préparation de la BD sqlite", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md30", null ],
        [ "6.5. Commandes de lancement du Docker", "md__2home_2runner_2work_2_t_e_s_t-url-shortener_2_t_e_s_t-url-shortener_2_proc_x_c3_x_a9dure__d_x_c3_x_a9veloppement.html#autotoc_md31", null ]
      ] ]
    ] ],
    [ "Espaces de nommage", "namespaces.html", [
      [ "Liste des espaces de nommage", "namespaces.html", "namespaces_dup" ]
    ] ],
    [ "Classes", "annotated.html", [
      [ "Liste des classes", "annotated.html", "annotated_dup" ],
      [ "Index des classes", "classes.html", null ],
      [ "Hiérarchie des classes", "hierarchy.html", "hierarchy" ],
      [ "Membres de classe", "functions.html", [
        [ "Tout", "functions.html", null ],
        [ "Fonctions", "functions_func.html", null ],
        [ "Variables", "functions_vars.html", null ]
      ] ]
    ] ],
    [ "Fichiers", "files.html", [
      [ "Liste des fichiers", "files.html", "files_dup" ],
      [ "Membres de fichier", "globals.html", [
        [ "Tout", "globals.html", null ],
        [ "Variables", "globals_vars.html", null ]
      ] ]
    ] ]
  ] ]
];

var NAVTREEINDEX =
[
"0001__01__01__000000__create__users__table_8php.html",
"class_database_1_1_factories_1_1_short_url_factory.html#ae17859b1a7512135270aecc3079ac16d",
"namespace_app.html"
];

var SYNCONMSG = 'cliquez pour désactiver la synchronisation du panel';
var SYNCOFFMSG = 'cliquez pour activer la synchronisation du panel';