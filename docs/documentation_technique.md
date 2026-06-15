# Documentation Technique - Projet CesiZen

## 1. Modélisation de la Base de Données

### 1.1 Modèle Logique de Données (MLD)

Basé sur les entités du projet, voici le Modèle Logique de Données (MLD) :

- **User** (`user`)
    - `id` (INT, PK, Auto-increment)
    - `email` (VARCHAR 180, Unique)
    - `roles` (JSON)
    - `password` (VARCHAR 255)
    - `nom` (VARCHAR 255)
    - `prenom` (VARCHAR 255)
    - `actif` (BOOLEAN)
    - `reponse_question_secrete` (VARCHAR 255, Nullable)

- **Contenu** (`contenu`)
    - `id` (INT, PK, Auto-increment)
    - `titre` (VARCHAR 255)
    - `corps` (TEXT)
    - `publier` (BOOLEAN)

- **ExerciceRespiration** (`exercice_respiration`)
    - `id` (INT, PK, Auto-increment)
    - `nom` (VARCHAR 255)
    - `duree_inspiration` (INT)
    - `duree_apnee` (INT)
    - `duree_expiration` (INT)
    - `publier` (BOOLEAN)

- **SessionExercice** (`session_exercice`)
    - `id` (INT, PK, Auto-increment)
    - `date_debut` (DATETIME)
    - `date_fin` (DATETIME)
    - `utilisateur_id` (INT, FK -> user.id)
    - `exercice_respiration_id` (INT, FK -> exercice_respiration.id)
    - `statut` (VARCHAR 20) : 'terminee' ou 'interrompue'

---

## 2. Comparatif des solutions techniques

Le projet CesiZen utilise **Symfony 6.4** avec le moteur de template **Twig**. Voici un comparatif avec d'autres approches d'architecture courantes.

| Critères | Monolithe Symfony + Twig (CHOISI) | SPA + API REST          | Microservices |
| :--- |:----------------------------------|:------------------------| :--- |
| **Complexité** | 4/10 (Moyenne)                    | 6/10 (Élevée)           | 8/10 (Très élevée) |
| **Temps de développement** | 10/10 (Rapide : 2-3 mois)         | 6/10 (Moyen : 4-6 mois) | 2/10 (Lent : 6+ mois) |
| **Maintenabilité** | 8/10 (Excellente)                 | 6/10 (Bonne)            | 4/10 (Moyenne) |
| **Performance** | 8/10 (Très bonne)                 | 8/10 (Très bonne)       | 10/10 (Excellente) |
| **Scalabilité** | 6/10 (Bonne)                      | 8/10 (Très bonne)       | 10/10 (Excellente) |
| **Expérience développeur** | 10/10 (Excellente)                | 6/10 (Bonne)            | 4/10 (Complexe) |
| **Note Finale** | **15/20**                         | 13/20                   | 12/20 |

**Pourquoi Symfony a été choisi :**
- **Efficacité et Rapidité** : Le modèle monolithique permet un développement beaucoup plus rapide et une gestion simplifiée des données.
- **EasyAdmin** : Permet de générer un back-office complet en quelques minutes, ce qui était crucial pour le projet.
- **Pérennité** : Support à long terme (LTS) et respect des standards industriels.

---

## 3. Guide d'installation

Ce guide permet de lancer le projet CesiZen en local à partir d'un environnement vierge.

### 3.1 Prérequis et Installation des outils

Avant de commencer, vous devez installer les outils suivants selon votre système d'exploitation.

#### 1. PHP (version >= 8.1)
- **Windows** : Téléchargez l'installeur sur [php.net](https://windows.php.net/download/). Ajoutez le dossier PHP à votre variable d'environnement `PATH`.
- **Linux (Ubuntu/Debian)** : 
  ```bash
  sudo apt update && sudo apt install php8.1 php8.1-cli php8.1-common php8.1-pgsql php8.1-xml php8.1-curl php8.1-mbstring php8.1-zip php8.1-intl
  ```
- **macOS** (via Homebrew) : `brew install php@8.1`

#### 2. Composer (Gestionnaire de dépendances)
- **Toutes plateformes** : Téléchargez et lancez l'installeur depuis [getcomposer.org](https://getcomposer.org/download/).
- Vérifiez l'installation avec : `composer --version`

#### 3. Symfony CLI (Recommandé)
- **Windows** : Téléchargez l'exécutable sur [symfony.com/download](https://symfony.com/download).
- **Linux/macOS** : 
  ```bash
  curl -sS https://get.symfony.com/cli/installer | bash
  ```
- Vérifiez l'installation avec : `symfony check:requirements`

#### 4. Base de données
- Installez **PostgreSQL**. Vous pouvez utiliser **Docker** ou un service local comme **pgAdmin**.

### 3.2 Installation du projet

#### Étape 1 : Récupération du projet
Clonez le dépôt ou téléchargez les sources dans votre dossier de travail :
```bash
git clone <url-du-depot>
cd CesiZen
```

#### Étape 2 : Installation des dépendances
Utilisez Composer pour installer les bibliothèques PHP nécessaires :
```bash
composer install
```

#### Étape 3 : Configuration de l'environnement
1. Copiez le fichier `.env` vers `.env.local` :
   ```bash
   cp .env .env.local
   ```
2. Modifiez la variable `DATABASE_URL` dans `.env.local` avec vos identifiants PostgreSQL :
   ```text
   DATABASE_URL="postgresql://user:password@127.0.0.1:5432/cesizen?serverVersion=15&charset=utf8"
   ```

#### Étape 4 : Création de la base de données
Exécutez les commandes suivantes pour créer la base et jouer les migrations :
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

#### Étape 5 : Lancement du serveur
Utilisez Symfony CLI pour un lancement rapide :
```bash
symfony server:start
```
Le projet sera alors accessible à l'adresse `http://127.0.0.1:8000`.

### 3.3 Accès Administration
Pour accéder à l'interface d'administration `/admin`, assurez-vous de créer un utilisateur avec le rôle `ROLE_ADMIN` via une fixture ou directement en base de données.
