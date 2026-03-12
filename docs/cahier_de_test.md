# Cahier de Test - Projet CesiZen

---

## Inscription

| ID               | Titre                                                              | Pré-conditions | Procédure                                                                                                                                                                                               | Résultat Attendu                                                                       |
|------------------|--------------------------------------------------------------------|----------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------|
| **TEST-INSC-01** | **Inscription**                                                    | Aucune | 1. Aller sur `/register`<br>2. Remplir email, mot de passe (8+ car, maj, min, chiffre, spécial), confirmation mot de passe, nom, prénom, réponse à la question secrète (couleur préférée)<br>3. Valider | Compte créé, redirection vers `/login`                                                 |
| **TEST-INSC-02** | **Inscription - Email déjà utilisé**                               | Un compte existe déjà avec l'email `test@exemple.com` | 1. Aller sur `/register`<br>2. Saisir l'email `test@exemple.com`<br>3. Valider                          | Erreur affichée : "Cet email est déjà utilisé par un autre compte."                    |
| **TEST-INSC-03** | **Inscription - Champs obligatoires vides (général)**              | Aucune | 1. Aller sur `/register`<br>2. Laisser tous les champs vides<br>3. Valider                                                                                                                              | Formulaire non soumis, messages d’erreur sur chaque champ obligatoire                  |
| **TEST-INSC-04** | **Inscription - Mot de passe vide**                                | Aucune | 1. Aller sur `/register`<br>2. Remplir tout sauf mot de passe<br>3. Valider                                                                                                                             | Message d’erreur : mot de passe obligatoire                                            |
| **TEST-INSC-05** | **Inscription - Mot de passe non conforme**                        | Aucune | 1. Aller sur `/register`<br>2. Saisir `janette`<br>3. Compléter le reste correctement<br>4. Valider                                                                                                     | Message d’erreur : règle non respectée                                                 |
| **TEST-INSC-06** | **Inscription - Confirmation mot de passe vide**                   | Aucune | 1. Aller sur `/register`<br>2. Saisir un mot de passe valide<br>3. Laisser la confirmation vide<br>4. Valider                                                                                           | Message d’erreur : confirmation obligatoire                                            |
| **TEST-INSC-07** | **Inscription - Mot de passe et confirmation différents**          | Aucune | 1. Aller sur `/register`<br>2. Saisir mot de passe valide<br>3. Saisir une confirmation différente<br>4. Valider                                                                                        | Message d’erreur : confirmation ne correspond pas                                      |
| **TEST-INSC-08** | **Inscription - Réponse question secrète vide (couleur préférée)** | Aucune | 1. Aller sur `/register`<br>2. Compléter tout sauf la réponse à la question secrète<br>3. Valider                                                                                                       | Message d’erreur : réponse obligatoire                                                 |
| **TEST-INSC-09** | **Inscription - Injection HTML/JS dans un champ texte**            | Aucune | 1. Aller sur `/register`<br>2. Dans nom/prénom/réponse couleur, saisir `<script>alert(1)</script>`<br>3. Valider                                                                                        | Les caractères sont échappés/refusés; aucun script ne s’exécute                        |
| **TEST-INSC-10** | **Inscription - Double clic sur “Valider”**                        | Aucune | 1. Aller sur `/register`<br>2. Remplir correctement<br>3. Double cliquer rapidement sur valider                                                                                                         | Un seul compte créé, pas de doublon, pas d’erreur incohérente                          |
| **TEST-INSC-11** | **Inscription - Rafraîchir / retour arrière après succès**         | Aucune | 1. S’inscrire correctement<br>2. Après redirection `/login`, revenir en arrière ou refresh                                                                                                              | Pas de re-soumission créant un doublon; comportement cohérent                          |

---

## Connexion

| ID               | Titre | Pré-conditions | Procédure | Résultat Attendu                                                       |
|------------------|-------|----------------|-----------|------------------------------------------------------------------------|
| **TEST-CONN-01** | **Connexion** | Compte `test@exemple.com` créé | 1. Aller sur `/login`<br>2. Saisir email et mot de passe corrects<br>3. Valider | Utilisateur connecté, accès aux fonctionnalités réservées              |
| **TEST-CONN-02** | **Connexion - Email vide** | Aucune | 1. Aller sur `/login`<br>2. Laisser email vide<br>3. Saisir un mot de passe quelconque<br>4. Valider | Message d’erreur : email obligatoire (ou erreur de connexion)          |
| **TEST-CONN-03** | **Connexion - Mot de passe vide** | Aucune | 1. Aller sur `/login`<br>2. Saisir un email valide<br>3. Laisser mot de passe vide<br>4. Valider | Message d’erreur : mot de passe obligatoire (ou erreur de connexion)   |
| **TEST-CONN-04** | **Connexion - Mauvais mot de passe** | Compte `test@exemple.com` existe | 1. Aller sur `/login`<br>2. Saisir `test@exemple.com`<br>3. Saisir un mauvais mot de passe<br>4. Valider | Connexion refusée, message d’erreur (sans révéler si le compte existe) |
| **TEST-CONN-05** | **Connexion - Email inexistant** | Aucun compte avec `inconnu@exemple.com` | 1. Aller sur `/login`<br>2. Saisir `inconnu@exemple.com` + un mot de passe<br>3. Valider | Connexion refusée, message d’erreur générique                          |
| **TEST-CONN-06** | **Connexion - Déjà connecté, accès à /login** | Utilisateur déjà connecté | 1. Se connecter<br>2. Aller manuellement sur `/login` | Redirection vers page d'accueil                                        |

---

## Mot de passe oublié

| ID              | Titre                                                       | Pré-conditions | Procédure                                                                                                           | Résultat Attendu                                                                              |
|-----------------|-------------------------------------------------------------|----------------|---------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------|
| **TEST-MDP-01** | **Mot de passe oublié - Étape 1 (succès)**                  | Compte `test@exemple.com` existe avec réponse “couleur préférée” connue | 1. Aller sur `/mot-de-passe-oublie`<br>2. Saisir l'email + la bonne réponse à la question secrète<br>3. Valider     | Redirection vers le formulaire de nouveau mot de passe                                        |
| **TEST-MDP-02** | **Mot de passe oublié - Étape 1 (champs obligatoire vide)** | Aucune | 1. Aller sur `/mot-de-passe-oublie`<br>2. Laisser les champs vide<br>4. Valider                                     | Erreur : champs obligatoire                                                                   |
| **TEST-MDP-03** | **Mot de passe oublié - Étape 1 (mauvaise réponse)**        | Compte `test@exemple.com` existe | 1. Aller sur `/mot-de-passe-oublie`<br>2. Saisir email + mauvaise réponse<br>3. Valider                             | Refus + message d’erreur (idéalement sans info sensible)                                      |
| **TEST-MDP-04** | **Mot de passe oublié - Étape 1 (email inexistant)**        | Aucun compte avec `inconnu@exemple.com` | 1. Aller sur `/mot-de-passe-oublie`<br>2. Saisir email inexistant + réponse<br>3. Valider                           | Message générique (ne pas confirmer l’existence du compte) ou refus clair selon choix produit |
| **TEST-MDP-05** | **Mot de passe oublié - Étape 2 (succès)**                  | Avoir réussi l'étape 1 | 1. Saisir un nouveau mot de passe valide<br>2. Confirmer et valider                                                 | Mot de passe mis à jour, redirection vers `/login`                                            |
| **TEST-MDP-06** | **Mot de passe oublié - Étape 2 (mot de passe trop court)** | Avoir réussi l'étape 1 | 1. Saisir un nouveau mot de passe < 8 caractères<br>2. Confirmer et valider                                         | Erreur de validation (mot de passe invalide)                                                  |
| **TEST-MDP-07** | **Mot de passe oublié - Étape 2 (confirmation différente)** | Avoir réussi l'étape 1 | 1. Saisir un mot de passe valide<br>2. Mettre une confirmation différente<br>3. Valider                             | Erreur : confirmation ne correspond pas                                                       |
| **TEST-MDP-08** | **Mot de passe oublié - Accès direct à l’étape 2**          | Ne pas avoir fait l’étape 1 | 1. Aller directement sur l’URL de l’étape 2 `/mot-de-passe-oublie/nouveau` | Redirection vers étape 1                                                                      |

---

## Profil

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu                                                 |
|----|-------|----------------|-----------|------------------------------------------------------------------|
| **TEST-PROF-01** | **Profil - Consultation** | Utilisateur connecté | 1. Aller sur `/compte` | Affichage des informations de l'utilisateur (nom, prénom, email) |
| **TEST-PROF-02** | **Profil - Consultation anonyme** | Non connecté | 1. Aller sur `/compte` | Redirection vers `/login`                                        |
| **TEST-PROF-03** | **Profil - Modification** | Utilisateur connecté | 1. Aller sur `/compte/modifier`<br>2. Modifier le nom ou prénom<br>3. Valider | Informations mises à jour                                        |
| **TEST-PROF-04** | **Profil - Modification (champs vides)** | Utilisateur connecté | 1. Aller sur `/compte/modifier`<br>2. Vider nom et/ou prénom<br>3. Valider | Refus + message d’erreur                                         |
| **TEST-PROF-05** | **Profil - Modification avec caractères spéciaux** | Utilisateur connecté | 1. Aller sur `/compte/modifier`<br>2. Mettre un nom/prénom avec caractères inattendus (ex: `<b>Test</b>`)<br>3. Valider | Informations mises à jour                                                           |

---

## Contenus

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|------------------|
| **TEST-CONT-01** | **Contenus - Liste** | Des contenus sont publiés en base | 1. Aller sur `/contenu` | Liste des articles/contenus publiés affichée |
| **TEST-CONT-02** | **Contenus - Liste vide** | Aucun contenu publié en base | 1. Aller sur `/contenu` | Message “Aucun contenu” (ou équivalent), pas d’erreur |
| **TEST-CONT-03** | **Contenus - Détails** | Un contenu avec ID 1 existe | 1. Aller sur `/contenu/informations/1` | Affichage complet du contenu sélectionné |
| **TEST-CONT-04** | **Contenus - Détails (ID inexistant)** | Aucun contenu avec ID 9999 | 1. Aller sur `/contenu/informations/9999` | Redirection vers `/contenu` |
| **TEST-CONT-05** | **Contenus - Détails (ID non numérique)** | Aucune | 1. Aller sur `/contenu/informations/abc` | Redirection vers `/contenu` |

---

## Exercices / Respiration

| ID              | Titre                                                             | Pré-conditions | Procédure                                                                                      | Résultat Attendu                                                            |
|-----------------|-------------------------------------------------------------------|----------------|------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------|
| **TEST-EXR-01** | **Exercice de Respiration - Accès page “Jouer”**                  | Utilisateur connecté + exercices publiés en base | 1. Aller sur `/exercice/respiration/jouer`                                                     | La page de lancement s’affiche (liste/choix des exercices visible)          |
| **TEST-EXR-02** | **Exercice de Respiration - Lancer un exercice **                 | Utilisateur connecté + exercices publiés en base | 1. Aller sur `/exercice/respiration/jouer`<br>2. Choisir un exercice<br>3. Lancer              | L'exercice se lance (interface interactive), pas d’erreur                   |
| **TEST-EXR-03** | **Exercice de Respiration - Lancer sans sélectionner d’exercice** | Utilisateur connecté + exercices publiés | 1. Aller sur `/exercice/respiration/jouer`<br>2. Cliquer “Lancer” sans sélection (si possible) | Un message indique qu’il faut sélectionner un exercice, aucun lancement     |
| **TEST-EXR-04** | **Exercice de Respiration - Fin d’exercice (enregistrement)**     | Utilisateur connecté + exercice lançable | 1. Lancer un exercice<br>2. Aller jusqu’à la fin                                               | Une session est enregistrée (statut “terminé”) et visible dans l’historique |
| **TEST-EXR-05** | **Exercice de Respiration - Abandon**                            | Utilisateur connecté + exercice lançable | 1. Lancer un exercice<br>2. Stopper l'exercice                                                 | Dans l'historique des sessions, l'exercice apparaît comme interrompue       |
| **TEST-EXR-06** | **Historique des Exercices (connecté)**                           | Utilisateur connecté | 1. Aller sur `/mes-exercices`                                                                  | Tableau affichant la liste des sessions (date, exercice, statut)            |
| **TEST-EXR-07** | **Historique des Exercices - Liste vide**                         | Utilisateur connecté, n’a jamais terminé d’exercice | 1. Aller sur `/mes-exercices`                                                                  | Tableau vide + message “Aucune session”                                     |
| **TEST-EXR-08** | **Historique des Exercices - Utilisateur anonyme**                | Aucune | 1. Aller sur `/mes-exercices`                                                                  | Redirection sur `/login`                                                    |
| **TEST-EXR-09** | **Historique des Exercices - Ordre d’affichage**                  | Utilisateur connecté + plusieurs sessions existantes | 1. Aller sur `/mes-exercices`                                                                  | Les sessions sont triées de façon cohérente                                 |

---

## Administration

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|------------------|
| **TEST-ADMIN-01** | **Accès Administration (admin)** | Utilisateur connecté avec le rôle `ROLE_ADMIN` | 1. Aller sur `/admin` | Accès au tableau de bord EasyAdmin |
| **TEST-ADMIN-02** | **Accès Administration (non admin)** | Utilisateur connecté sans `ROLE_ADMIN` | 1. Aller sur `/admin` | Accès refusé (403) ou redirection |
| **TEST-ADMIN-03** | **Accès Administration (anonyme)** | Non connecté | 1. Aller sur `/admin` | Redirection vers login |

---

## Déconnexion

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|------------------|
| **TEST-LOGOUT-01** | **Déconnexion** | Utilisateur connecté | 1. Cliquer sur le lien de déconnexion ou aller sur `/logout` | Utilisateur déconnecté, redirection vers la page d'accueil |
| **TEST-LOGOUT-02** | **Déconnexion - Accès /logout anonyme** | Non connecté | 1. Aller sur `/logout` | Comportement propre (redirection accueil), pas d’erreur |

---

## Navigation / Pages générales

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|-----------------|
| **TEST-NAV-01** | **Accueil - Affichage** | Aucune | 1. Aller sur `/` | La page d’accueil s’affiche correctement (pas d’erreur, contenu visible) |
| **TEST-NAV-02** | **Accueil - Navigation vers Contenu** | Aucune | 1. Aller sur `/`<br>2. Cliquer sur un lien/menu vers `/contenu` | Redirection vers `/contenu`, page liste visible |
| **TEST-NAV-03** | **Accueil - Navigation vers Exercice respiration** | Aucune | 1. Aller sur `/`<br>2. Cliquer sur un lien/menu vers `/exercice/respiration/jouer` | Redirection vers `/exercice/respiration/jouer`, page accessible (ou redirection `/login` si protégé) |
| **TEST-NAV-04** | **Accueil - Navigation vers Compte** | Aucune | 1. Aller sur `/`<br>2. Cliquer sur un lien/menu vers `/compte` | Si connecté : accès au profil. Si non connecté : redirection `/login` |
| **TEST-NAV-05** | **Page inexistante - 404** | Aucune | 1. Aller sur `/page-qui-nexiste-pas` | Page 404 |
| **TEST-NAV-06** | **Accès interdit - /admin sans droits (403)** | Utilisateur connecté avec rôle `ROLE_USER` (non admin) | 1. Se connecter avec un compte non admin<br>2. Aller sur `/admin` | Accès refusé : 403, pas d’accès au dashboard |

---

## Administration - Gestion (EasyAdmin CRUD)

> Remarque: les intitulés exacts des boutons peuvent varier (Créer / Ajouter / Nouveau / Éditer / Supprimer). L’objectif est de valider les opérations CRUD + permissions.

| ID               | Titre | Pré-conditions | Procédure | Résultat Attendu |
|------------------|-------|----------------|-----------|------------------|
| **TEST-CRUD-01** | **Admin - Accès dashboard (admin)** | Utilisateur connecté avec rôle `ROLE_ADMIN` | 1. Aller sur `/admin` | Dashboard EasyAdmin accessible |

### CRUD Contenus

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|------------------|
| **TEST-CRUD-CONT-01** | **Admin Contenu - Créer un contenu** | Admin connecté + accès CRUD Contenu | 1. Aller sur `/admin`<br>2. Aller dans la section Contenus<br>3. Créer un nouveau contenu (champs requis)<br>4. Enregistrer | Contenu créé, visible dans la liste admin |
| **TEST-CRUD-CONT-02** | **Admin Contenu - Validation champs obligatoires** | Admin connecté | 1. Créer un contenu<br>2. Laisser un champ obligatoire vide<br>3. Enregistrer | Erreurs de validation, pas de création |
| **TEST-CRUD-CONT-03** | **Admin Contenu - Modifier un contenu** | Admin connecté + au moins 1 contenu existant | 1. Ouvrir un contenu existant<br>2. Modifier un champ<br>3. Enregistrer | Modifications sauvegardées, affichées dans la liste |
| **TEST-CRUD-CONT-04** | **Admin Contenu - Supprimer un contenu** | Admin connecté + au moins 1 contenu existant | 1. Supprimer un contenu via l’admin | Contenu supprimé, n’apparaît plus dans la liste admin |
| **TEST-CRUD-CONT-05** | **Admin Contenu - Accès depuis la partie publique** | Contenu créé et publié  | 1. Aller sur `/contenu`<br>2. Ouvrir le contenu | Le contenu est visible côté public |

### CRUD Exercices de respiration

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|------------------|
| **TEST-CRUD-EXR-01** | **Admin Exercice - Créer un exercice respiration** | Admin connecté + accès CRUD Exercices | 1. Aller sur `/admin`<br>2. Section Exercices respiration<br>3. Créer un exercice (champs requis)<br>4. Enregistrer | Exercice créé, visible dans la liste admin |
| **TEST-CRUD-EXR-02** | **Admin Exercice - Validation champs obligatoires** | Admin connecté | 1. Créer un exercice<br>2. Laisser un champ obligatoire vide<br>3. Enregistrer | Erreurs de validation, pas de création |
| **TEST-CRUD-EXR-03** | **Admin Exercice - Modifier un exercice** | Admin connecté + exercice existant | 1. Modifier un exercice<br>2. Enregistrer | Exercice mis à jour |
| **TEST-CRUD-EXR-04** | **Admin Exercice - Supprimer un exercice** | Admin connecté + exercice existant | 1. Supprimer un exercice | Exercice supprimé |
| **TEST-CRUD-EXR-05** | **Exercice - Visible dans la page Jouer** | Au moins 1 exercice existe | 1. Aller sur `/exercice/respiration/jouer` | L’exercice apparaît dans la liste |

### CRUD Utilisateurs

| ID | Titre | Pré-conditions | Procédure | Résultat Attendu |
|----|-------|----------------|-----------|------------------|
| **TEST-CRUD-USER-01** | **Admin Utilisateur - Voir liste utilisateurs** | Admin connecté + utilisateurs existants | 1. Aller sur `/admin`<br>2. Section Utilisateurs | Liste affichée |
| **TEST-CRUD-USER-02** | **Admin Utilisateur - Modifier un utilisateur** | Admin connecté + utilisateur existant | 1. Ouvrir un utilisateur<br>2. Modifier un champ autorisé (ex: nom/prénom/role)<br>3. Sauvegarder | Données mises à jour |
| **TEST-CRUD-USER-03** | **Admin Utilisateur - Promouvoir un utilisateur en admin** | Admin connecté + utilisateur `ROLE_USER` existant | 1. Modifier l’utilisateur<br>2. Ajouter `ROLE_ADMIN`<br>3. Sauvegarder | L’utilisateur a le rôle admin (vérifiable en se connectant avec ce compte et en accédant à `/admin`) |

---

## UI / Responsive

| ID | Titre | Pré-conditions | Procédure                                                          | Résultat Attendu |
|----|-------|----------------|--------------------------------------------------------------------|------------------|
| **TEST-UI-01** | **Responsive - Mobile ** | Aucune | 1. Ouvrir l'application sur un viewport mobile<br>2. Vérifier menu | Mise en page lisible, pas de chevauchement, navigation possible |
