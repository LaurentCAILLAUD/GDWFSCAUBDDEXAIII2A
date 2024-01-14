 <?php
    /* Création du Data Source Name  pour MySQL. Etant donné que notre base de donnée n'est pas encore créée, celui ci ne contient pas le dbname. */
    $dsn = 'mysql:host=localhost';
    /* Comme il est de bonne pratique, j'inscirs mon code dans un bloc try...catch afin de gérer les erreurs de connexion */
    try {
        $pdo = new PDO($dsn, 'root', 'root');
        /** Dans un bloc if...else je lance la création de ma base de donnée. Si celle ci existe déjà je décide de la supprimer. Si une erreur arrive lors de ces deux opérations, j'affiche un message d'erreur */
        if ($pdo->exec('DROP DATABASE IF EXISTS GDWFSCAUBDDEXAIII2A') !== false) {
            if ($pdo->exec('CREATE DATABASE GDWFSCAUBDDEXAIII2A') != false) {
                /** A ce stade, notre base de données est créée, nous pouvons donc créér un nouveau dsn : */
                $finalDSN = 'mysql:host=localhost;dbname=GDWFSCAUBDDEXAIII2A';
                /* Créons maintenant un nouvel objet PDO avec le nouveau dsn: */
                $finalPDO = new PDO($finalDSN, 'root', 'root');
                /** Maintenant je vais créer toutes mes tables. Pour ces dernières je vais à chaque fois vérifier que la création s'est bien passée. Dans le cas contraire un message d'erreur se affiché : */
                /** Table customers: */
                if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS customers (id CHAR(36) NOT NULL PRIMARY KEY, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT(5) NOT NULL, town VARCHAR(255) NOT NULL,phone_number VARCHAR(255) NOT NULL,email VARCHAR(255) NOT NULL,password VARCHAR(60) NOT NULL)') !== false) {
                    /** Table movies:  */
                    if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS movies (id CHAR(36) NOT NULL PRIMARY KEY, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description TEXT NOT NULL, poster VARCHAR(255) NOT NULL, trailer VARCHAR(255) NOT NULL, cast_list JSON NOT NULL, director_name VARCHAR(255) NOT NULL)') !== false) {
                        /** Table bookings:  */
                        if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS bookings (id CHAR(36) NOT NULL PRIMARY KEY, full_price_place INT(3) NOT NULL, reduced_price_place INT(3) NOT NULL, under_14_place INT(3) NOT NULL, total_mount DECIMAL(4, 2) NOT NULL, is_paid BOOLEAN NOT NULL, reserved_by CHAR(36) NOT NULL, reserved CHAR(36) NOT NULL, FOREIGN KEY (reserved_by) REFERENCES customers(id), FOREIGN KEY (reserved) REFERENCES movies(id))') !== false) {
                            /** Table movies_room:  */
                            if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS movies_room (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(255) NOT NULL, number_of_place INT(4) NOT NULL, projected CHAR(36) NOT NULL, FOREIGN KEY (projected) REFERENCES movies(id))') !== false) {
                                /** Table cinemas:  */
                                if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS cinemas (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT(5) NOT NULL, town VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numberOfMoviesRoom INT(3) NOT NULL)') !== false) {
                                    /** Table on_display:  */
                                    if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS on_display (movie_id CHAR(36) NOT NULL, cinema_id CHAR(36) NOT NULL, PRIMARY KEY (movie_id, cinema_id), FOREIGN KEY (movie_id) REFERENCES movies (id), FOREIGN KEY (cinema_id) REFERENCES cinemas(id))') !== false) {
                                        /** Table sessions_schedule:  */
                                        if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS sessions_schedule (id CHAR(36) NOT NULL PRIMARY KEY, session DATETIME NOT NULL)') !== false) {
                                            /* Table projected_film: */
                                            if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS projected_film (movie_id CHAR(36) NOT NULL, session_schedule_id CHAR(36) NOT NULL, PRIMARY KEY (movie_id, session_schedule_id), FOREIGN KEY (movie_id) REFERENCES movies (id), FOREIGN KEY (session_schedule_id) REFERENCES sessions_schedule(id))') !== false) {
                                                /** Table prices:  */
                                                if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS prices (id CHAR(36) NOT NULL PRIMARY KEY, price_category VARCHAR(255) NOT NULL, price DECIMAL(4, 2) NOT NULL)') !== false) {
                                                    /** Table roles:  */
                                                    if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS roles (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(255) NOT NULL)') !== false) {
                                                        /** Table users:  */
                                                        if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS users (id CHAR(36) NOT NULL PRIMARY KEY, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(60) NOT NULL, has_role CHAR(36) NOT NULL, FOREIGN KEY (has_role) REFERENCES roles (id))') !== false) {
                                                            /** Table management:  */
                                                            if ($finalPDO->exec('CREATE TABLE IF NOT EXISTS management (user_id CHAR(36) NOT NULL, cinema_id CHAR(36) NOT NULL, PRIMARY KEY (user_id, cinema_id), FOREIGN KEY (user_id) REFERENCES users(id), FOREIGN KEY (cinema_id) REFERENCES cinemas(id))') !== false) {
                                                                echo '<p>La création de vos tables s\'est bien déroulée.</p>';
                                                                /**  A ce stade toutes nos tables sont créées. Nous allons maintenant passer à l'insertion des données factices. Comme pour le fichier avec des instructions SQL, pour les id qui seront réutlisés dans différentes tables, je choisi d'écrire ces derniers en dur sans donc utiliser la fonction UUID(). Pour les id qui seront pas réutilisés là j'utilise la fonction UUID(). Comme pour la création des tables j'utilise le bloc if...else afin de gérer les erreurs :*/
                                                                /** Insertion des données dans la table customers:  */
                                                                if ($finalPDO->exec('INSERT INTO customers (id, first_name, last_name, address, zip_code, town, phone_number, email, password) VALUES (
                                                                "cb2ebef4-ad9b-11ee-b481-4c766cb95eaa",
                                                                "Laurent",
                                                                "CAILLAUD",
                                                                "8 chemin des manses",
                                                                87110,
                                                                "SOLIGNAC",
                                                                "06.46.73.35.30",
                                                                "laurent.caillaud@icloud.com",
                                                                "$2a$12$dpvgRO0e1Yttws9Q3hYD7euwYI1qTJsMEyx8NXat7/90WrjXGrGtq"
                                                                ), (
                                                                "cb2ec1d8-ad9b-11ee-b481-4c766cb95eaa",
                                                                "Fabien",
                                                                "MARTENOT",
                                                                "15 rue Sainte Claire",
                                                                87410,
                                                                "LE PALAIS SUR VIENNE",
                                                                "06.40.63.88.54",
                                                                "fabien.martenot@yahoo.fr",
                                                                "$2a$12$44/QOB00hnlWL0AoSsj0Zex/khNt7WWL.4Rh604Wlbx.53GeMYeFG"
                                                                ), (
                                                                "cb2ec28c-ad9b-11ee-b481-4c766cb95eaa",
                                                                "Claude",
                                                                "VOISIN",
                                                                "14 rue Marcel PAGNOL",
                                                                87700,
                                                                "AIXE SUR VIENNE",
                                                                "07.54.88.02.24",
                                                                "cl.voisin@orange.fr",
                                                                "$2a$12$bz/f6imKZM1hk0mIYti8Xed8AliGhO7CyhDK2cuVPfo1WnmI4qpdC"
                                                                ), (
                                                                "cb2ec2dc-ad9b-11ee-b481-4c766cb95eaa",
                                                                "Coralie",
                                                                "DARD",
                                                                "37 rue Albert THOMAS",
                                                                87220,
                                                                "FEYTIAT",
                                                                "06.38.01.24.16",
                                                                "dardcoralie@free.fr",
                                                                "$2a$12$Do3qdvdCsbd2K9d7xhxIbuwJ35fNKrlfGvZQWxp/Yq9nw0KEGrqL2"
                                                                ), (
                                                                "cb2ec318-ad9b-11ee-b481-4c766cb95eaa",
                                                                "Caroline",
                                                                "CEDRE",
                                                                "3 avenue Martin LUTHER KING",
                                                                87000,
                                                                "LIMOGES",
                                                                "07.24.16.87.37",
                                                                "cedre.caroline@hotmail.com",
                                                                "$2a$12$X/GtCgdlnVYhs0f098rgVun0GvWTam1ixJdiBxsTgJzKepR6lYBd2")') !== false) {
                                                                    /** Afin de pouvoir insérer notre tableau, comprenant le casting du film,  au format JSON dans notre bdd à l'aide de notre objet PDO, il nous faut d'abord construire nos tableaux. Ensuite je vais utiliser la fonction json_encode au moment de l'insertion dans la BDD: */
                                                                    $movieNumber1CastListArray = [['firstname' => 'Kev', 'lastname' => 'ADAMS'], ['firstname' => 'Jean', 'lastname' => 'RENO'], ['firstname' => 'Daniel', 'lastname' => 'PREVOST']];
                                                                    $movieNumber2CastListArray = [['firstname' => 'Laure', 'lastname' => 'CALAMY'], ['firstname' => 'Vincent', 'lastname' => 'ELBAZ'], ['firstname' => 'Suzanne', 'lastname' => 'DE BAECQUE']];
                                                                    $movieNumber3CastListArray = [['firstname' => 'Eero', 'lastname' => 'MILANOFF'], ['firstname' => 'Alma', 'lastname' => 'PÖYSTI'], ['firstname' => 'Oona', 'lastname' => 'AIROLA']];
                                                                    $movieNumber4CastListArray = [['firstname' => 'Lambert', 'lastname' => 'Wilson'], ['firstname' => 'Marina', 'lastname' => 'HANDS'], ['firstname' => 'Laurent', 'lastname' => 'POITRENAUX']];
                                                                    $movieNumber5CastListArray = [['firstname' => 'Seydou', 'lastname' => 'SARR'], ['firstname' => 'Moustapha', 'lastname' => 'FALL'], ['firstname' => 'Issaka', 'lastname' => 'SAWADOGO']];
                                                                    /** Insertion des données dans la table movies */
                                                                    if ($finalPDO->exec("INSERT INTO movies (id, title, type, description, poster, trailer, cast_list, director_name) VALUES (
                                                                    '257cdc3e-ad9b-11ee-b481-4c766cb95eaa',
                                                                    'MAISON DE RETRAITE 2',
                                                                    'Comédie',
                                                                    'Quand le foyer Lino Vartan, qui accueille jeunes orphelins et seniors, doit fermer pour raisons sanitaires, Milann n’a pas d’autre choix que de répondre à l’invitation d’une maison de retraite dans le Sud qui les accueille pour l’été. Tous embarquent dans le bus d’Alban. Enfants et anciens découvrent alors le Bel Azur Club, une villa idyllique au bord de la mer : le rêve ! Une aubaine pour ces gamins orphelins qui n’ont jamais eu de vacances... Mais le paradis tourne à l’enfer car anciens et nouveaux pensionnaires du 3e âge se détestent ! La guerre des seniors est déclarée !',
                                                                    'https://all.web.img.acsta.net/pictures/23/11/28/14/21/0273666.jpg',
                                                                    'https://www.grandecran.fr/films/313914-maison-de-retraite-2/?playTrailer',
                                                                    ' " . json_encode($movieNumber1CastListArray) . " ',
                                                                    'Claude ZIDI'
                                                                    ), (
                                                                    '257ce1ac-ad9b-11ee-b481-4c766cb95eaa',
                                                                    'IRIS ET LES HOMMES',
                                                                    'Drame',
                                                                    'Un mari formidable, deux filles parfaites, un cabinet dentaire florissant : tout va bien pour Iris. Mais depuis quand n’a-t-elle pas fait l’amour ? Peut-être est-il temps de prendre un amant. S\'inscrivant sur une banale appli de rencontre, Iris ouvre la boite de Pandore. Les hommes vont tomber… Comme s’il en pleuvait !',
                                                                    'https://all.web.img.acsta.net/pictures/23/11/20/10/50/5902027.jpg',
                                                                    'https://www.grandecran.fr/films/307775-iris-et-les-hommes/?playTrailer',
                                                                    ' " . json_encode($movieNumber2CastListArray) . " ',
                                                                    'Caroline VIGNAL'
                                                                    ), (
                                                                    '257ce3d2-ad9b-11ee-b481-4c766cb95eaa',
                                                                    'AMOUR A LA FINLANDAISE',
                                                                    'Romance',
                                                                    'Julia découvre que son mari a une liaison. Pour sauver leur mariage, elle lui propose d’expérimenter le polyamour et d\'inventer les nouvelles règles de leur vie conjugale. Un champ des possibles amoureux s’ouvre alors à eux…',
                                                                    'https://all.web.img.acsta.net/pictures/23/11/29/10/32/1466059.jpg',
                                                                    'https://www.grandecran.fr/films/302245-amours-a-la-finlandaise/?playTrailer',
                                                                    ' " . json_encode($movieNumber3CastListArray) . " ',
                                                                    'Selma VILHUNEN'
                                                                    ), (
                                                                    '257ce508-ad9b-11ee-b481-4c766cb95eaa',
                                                                    '5 HECTARES',
                                                                    'Comédie',
                                                                    'Qu’est-ce qui conduit un homme établi à mettre en péril son confort, sa carrière et son couple ? La passion, d’autant plus brûlante qu’elle est tardive, pour cinq hectares de terre limousine. Mais la terre se mérite, surtout quand on vient de la ville. Voilà Franck précipité dans la quête du Graal. Il lui faut un tracteur.',
                                                                    'https://all.web.img.acsta.net/pictures/23/11/22/09/32/4239619.jpg',
                                                                    'https://www.grandecran.fr/films/286638-5-hectares/?playTrailer',
                                                                    ' " . json_encode($movieNumber4CastListArray) . " ',
                                                                    'Emile DELEUZE'
                                                                    ), (
                                                                    '257ce62a-ad9b-11ee-b481-4c766cb95eaa',
                                                                    'MOI CAPITAINE',
                                                                    'Drame',
                                                                    'Seydou et Moussa, deux jeunes sénégalais de 16 ans, décident de quitter leur terre natale pour rejoindre l’Europe. Mais sur leur chemin les rêves et les espoirs d’une vie meilleure sont très vite anéantis par les dangers de ce périple. Leur seule arme dans cette odyssée restera leur humanité.',
                                                                    'https://all.web.img.acsta.net/pictures/23/10/11/09/12/4467686.jpg',
                                                                    'https://www.grandecran.fr/films/300927-moi-capitaine/?playTrailer',
                                                                    ' " . json_encode($movieNumber5CastListArray) . " ',
                                                                    'Mattéo GARRONE')") !== false) {
                                                                        /** Insertion des données dans la table bookings:  */
                                                                        if ($finalPDO->exec("INSERT INTO bookings (id, full_price_place, reduced_price_place, under_14_place, total_mount, is_paid,reserved_by, reserved) VALUES (
                                                                        UUID(),
                                                                        2,
                                                                        0,
                                                                        0,
                                                                        18.40,
                                                                        true,
                                                                        /* id du customer CAILLAUD Laurent */
                                                                        'cb2ebef4-ad9b-11ee-b481-4c766cb95eaa',
                                                                        /* id du flim IRIS ET LES HOMMES */
                                                                        '257ce1ac-ad9b-11ee-b481-4c766cb95eaa'
                                                                        ), (
                                                                        UUID(),
                                                                        1,
                                                                        1,
                                                                        1,
                                                                        22.70,
                                                                        false,
                                                                        /* id du customer VOISON Claude */
                                                                        'cb2ec28c-ad9b-11ee-b481-4c766cb95eaa',
                                                                        /* id de MAISON DE RETRAITE 2 */
                                                                        '257cdc3e-ad9b-11ee-b481-4c766cb95eaa'
                                                                        ), (
                                                                        UUID(),
                                                                        1,
                                                                        0,
                                                                        1,
                                                                        15.10,
                                                                        true,
                                                                        /* id du customer Coralie DARD*/
                                                                        'cb2ec2dc-ad9b-11ee-b481-4c766cb95eaa',
                                                                        /* id de IRIS ET LES HOMMES */
                                                                        '257ce1ac-ad9b-11ee-b481-4c766cb95eaa'
                                                                        ), (
                                                                        UUID(),
                                                                        2,
                                                                        1,
                                                                        0,
                                                                        26.00,
                                                                        true,
                                                                        /* id du customer Fabien MARTENOT */
                                                                        'cb2ec1d8-ad9b-11ee-b481-4c766cb95eaa',
                                                                        /* Id de MOI CAPITAINE */
                                                                        '257ce62a-ad9b-11ee-b481-4c766cb95eaa'
                                                                        ), (
                                                                        UUID(),
                                                                        3,
                                                                        0,
                                                                        0,
                                                                        27.60,
                                                                        true,
                                                                        /* id du customer Caroline CEDRE */
                                                                        'cb2ec318-ad9b-11ee-b481-4c766cb95eaa',
                                                                        /* id de 5 HECTARES */
                                                                        '257ce508-ad9b-11ee-b481-4c766cb95eaa')") !== false) {
                                                                            /** Insertion des données dans la table  movies_room */
                                                                            if ($finalPDO->exec("INSERT INTO movies_room (id, name, number_of_place, projected) VALUES (
                                                                            UUID(),
                                                                            'Michel AUDIARD',
                                                                            300,
                                                                            /* id du film IRIS ET LES HOMMES */
                                                                            '257ce1ac-ad9b-11ee-b481-4c766cb95eaa'
                                                                            ), (
                                                                            UUID(),
                                                                            'Michel GALABRU',
                                                                            300,
                                                                            /* id du film MOI CAPITAINE */
                                                                            '257ce62a-ad9b-11ee-b481-4c766cb95eaa'
                                                                            ), (
                                                                            UUID(),
                                                                            'Marcel PAGNOL',
                                                                            250,
                                                                            /* id du film 5 HECTARES*/
                                                                            '257ce508-ad9b-11ee-b481-4c766cb95eaa'
                                                                            ), (
                                                                            UUID(),
                                                                            'Jean GABIN',
                                                                            250,
                                                                            /* id du film AMOUR A LA FINLANDAISE */
                                                                            '257ce3d2-ad9b-11ee-b481-4c766cb95eaa'
                                                                            ), (
                                                                            UUID(),
                                                                            'Claude CHABROL',
                                                                            400,
                                                                            /* id du film MAISON DE RETRAITE 2*/
                                                                            '257cdc3e-ad9b-11ee-b481-4c766cb95eaa')") !== false) {
                                                                                /** Insertion des données dans la table cinemas: */
                                                                                if ($finalPDO->exec("INSERT INTO cinemas (id, name, address, zip_code, town, phone_number, email, numberOfMoviesRoom)VALUES (
                                                                                '8e28a252-ae42-11ee-a6ad-8a634f6408fc',
                                                                                'LES GRANDS ECRANS',
                                                                                '11 place Denis DUSSOUBS',
                                                                                87000,
                                                                                'LIMOGES',
                                                                                '05.55.70.24.09',
                                                                                'cinemalimogesdussoubs@lesgrandsecrans.fr',
                                                                                5
                                                                                ), (
                                                                                '8e28a50e-ae42-11ee-a6ad-8a634f6408fc',
                                                                                'LES GRANDS ECRANS',
                                                                                '3 avenue du Général DE GAULLE',
                                                                                87000,
                                                                                'LIMOGES',
                                                                                '05.55.70.48.04',
                                                                                'cinemalimogesdegaulle@lesgrandsecrans.fr',
                                                                                3
                                                                                ), (
                                                                                '8e28a5d6-ae42-11ee-a6ad-8a634f6408fc',
                                                                                'LES GRANDS ECRANS',
                                                                                '260 avenue Aristide BRIAND',
                                                                                87000,
                                                                                'LIMOGES',
                                                                                '05.55.38.82.45',
                                                                                'cinemalimogesbriand@lesgrandsecrans.fr',
                                                                                10
                                                                                ), (
                                                                                '8e28a61c-ae42-11ee-a6ad-8a634f6408fc',
                                                                                'LES GRANDS ECRANS',
                                                                                '9B avenue GAMBETTA',
                                                                                33120,
                                                                                'ARCACHON',
                                                                                '05.56.28.33.12',
                                                                                'cinemaarcachon@lesgrandsecrans.fr',
                                                                                5
                                                                                ), (
                                                                                '8e28a658-ae42-11ee-a6ad-8a634f6408fc',
                                                                                'LES GRANDS ECRANS',
                                                                                '6 rue LAGRUA',
                                                                                33260,
                                                                                'LA TESTE-DE-BUCH',
                                                                                '05.56.27.44.11',
                                                                                'cinemalateste@lesgrandsecrans.fr', 4)") !== false) {
                                                                                    /** Insertion des données dans la table on_display: */
                                                                                    if ($finalPDO->exec("INSERT INTO on_display (movie_id, cinema_id) VALUES (
                                                                                    /* id du film MAISON DE RETRAITE 2*/
                                                                                    '257cdc3e-ad9b-11ee-b481-4c766cb95eaa',
                                                                                    /* id du cinema 'LES GRANDS ECRANS* à LIMOGES avenue Aristide BRIAND */
                                                                                    '8e28a5d6-ae42-11ee-a6ad-8a634f6408fc'
                                                                                    ), (
                                                                                    /* id du film AMOUR A LA FINLANDAISE */
                                                                                    '257ce3d2-ad9b-11ee-b481-4c766cb95eaa',
                                                                                    /* id du cinema LES GRANDS ECRANS à LIMOGES avenue Général DE GAULLE*/
                                                                                    '8e28a50e-ae42-11ee-a6ad-8a634f6408fc'
                                                                                    ), (
                                                                                    /* id du film MOI CAPITAINE */
                                                                                    '257ce62a-ad9b-11ee-b481-4c766cb95eaa',
                                                                                    /* id du cinema LES GRNADS ECRANS à LIMOGES place DUSSOUBS */
                                                                                    '8e28a252-ae42-11ee-a6ad-8a634f6408fc'
                                                                                    ), (
                                                                                    /*id du film IRIS ET LES HOMMES */
                                                                                    '257ce1ac-ad9b-11ee-b481-4c766cb95eaa',
                                                                                    /* id du cinema LES GRANDS ECRANS à LIMOGES avenue Aristide BRIAND */
                                                                                    '8e28a5d6-ae42-11ee-a6ad-8a634f6408fc'
                                                                                    ), (
                                                                                    /* id du film MAISON DE RETRAITE 2 */
                                                                                    '257cdc3e-ad9b-11ee-b481-4c766cb95eaa',
                                                                                    /* id du cinema LES GRANDS ECRANS à LIMOGES place DUSSOUBS*/
                                                                                    '8e28a252-ae42-11ee-a6ad-8a634f6408fc')") !== false) {
                                                                                        /** Insertion des données dans la table sessions_schedule: */
                                                                                        if ($finalPDO->exec("INSERT INTO sessions_schedule (id, session) VALUES (
                                                                                        '1f77a8fc-afd8-11ee-a6ad-8a634f6408fc',
                                                                                        '2024-01-06 16:10:00'
                                                                                        ), (
                                                                                        '1f77abe0-afd8-11ee-a6ad-8a634f6408fc',
                                                                                        '2024-01-06 19:20:00'
                                                                                        ), (
                                                                                        '1f77ac94-afd8-11ee-a6ad-8a634f6408fc',
                                                                                        '2024-01-06 20:00:00'
                                                                                        ), (
                                                                                        '1f77acd0-afd8-11ee-a6ad-8a634f6408fc',
                                                                                        '2024-01-06 13:50:00'
                                                                                        ), (
                                                                                        '1f77acf8-afd8-11ee-a6ad-8a634f6408fc',
                                                                                        '2024-01-06 22:10:00')") !== false) {
                                                                                            /** Insertion des données dans la table projected_film: */
                                                                                            if ($finalPDO->exec("INSERT INTO projected_film (movie_id, session_schedule_id) VALUES (
                                                                                            /* id du film MAISON DE RETRAITE 2*/
                                                                                            '257cdc3e-ad9b-11ee-b481-4c766cb95eaa',
                                                                                            /* id de la session_schedule du 2024-01-06 à 16:10:00*/
                                                                                            '1f77a8fc-afd8-11ee-a6ad-8a634f6408fc'
                                                                                            ), (
                                                                                            /* id du film 5 HECTARES */
                                                                                            '257ce508-ad9b-11ee-b481-4c766cb95eaa',
                                                                                            /* id de la session_schedule du 2024-01-06 à 13:50:00*/
                                                                                            '1f77acd0-afd8-11ee-a6ad-8a634f6408fc'
                                                                                            ), (
                                                                                            /* id du film MAISON DE RETRAITE 2*/
                                                                                            '257cdc3e-ad9b-11ee-b481-4c766cb95eaa',
                                                                                            /* id de la session_schedule du 2024-01-06 à 20:00:00*/
                                                                                            '1f77ac94-afd8-11ee-a6ad-8a634f6408fc'
                                                                                            ), (
                                                                                            /* id du film AMOUR A LA FINLANDAISE */
                                                                                            '257ce3d2-ad9b-11ee-b481-4c766cb95eaa',
                                                                                            /* id de la session_schedule du 2024-01-06 à 19:20:00 */
                                                                                            '1f77abe0-afd8-11ee-a6ad-8a634f6408fc'
                                                                                            ), (
                                                                                            /* id du film MOI CAPITAINE */
                                                                                            '257ce62a-ad9b-11ee-b481-4c766cb95eaa',
                                                                                            /* id de la session_schedule du 2024-01-06 à 22:10:00 */
                                                                                            '1f77acf8-afd8-11ee-a6ad-8a634f6408fc')") !== false) {
                                                                                                /** Insertion des données dans la table prices: */
                                                                                                if ($finalPDO->exec("INSERT INTO prices (id, price_category, price) VALUES (UUID(), 'Plein tarif', 9.20), (UUID(), 'Tarif étudiant', 7.60), (UUID(), 'Moins de 14 ans', 5.90);") !== false) {
                                                                                                    /** Insertion des données dans la table  roles: */
                                                                                                    if ($finalPDO->exec("INSERT INTO roles (id, name) VALUES ('9ba9adae-afdc-11ee-a6ad-8a634f6408fc','Administrateur'), ('9baa027c-afdc-11ee-a6ad-8a634f6408fc', 'Manager')") !== false) {
                                                                                                        /** Insertion des données dans la table users: */
                                                                                                        if ($finalPDO->exec("INSERT INTO users (id, first_name, email, password, has_role) VALUES (
                                                                                                        'a5b5ad94-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                        'Romain',
                                                                                                        'romain@lesgrandsecrans.fr',
                                                                                                        '$2a$12$6bQyJFx6aCvGidym1k.T1u/WWbKue1yT0NALuAP3oi9xe/GPiYoLK',
                                                                                                        /* id du rôle manager */
                                                                                                        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
                                                                                                        ), (
                                                                                                        'a5b5b028-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                        'Laly',
                                                                                                        'laly@lesgrandslimoges.fr',
                                                                                                        '$2a$12$6bQyJFx6aCvGidym1k.T1u/WWbKue1yT0NALuAP3oi9xe/GPiYoLK',
                                                                                                        /* id du rôle manager */
                                                                                                        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
                                                                                                        ), (
                                                                                                        'a5b5b0f0-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                        'Pierre',
                                                                                                        'laly@lesgrandsecrans.fr',
                                                                                                        '$2a$12$6bQyJFx6aCvGidym1k.T1u/WWbKue1yT0NALuAP3oi9xe/GPiYoLK',
                                                                                                        /* id du rôle manager */
                                                                                                        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
                                                                                                        ), (
                                                                                                        'a5b5b154-afe0-11ee-a6ad-8a634408fcf6',
                                                                                                        'Jérémy',
                                                                                                        'jeremy@lesgrandsecrans.fr',
                                                                                                        '$2a$12$6bQyJFx6aCvGidym1k.T1u/WWbKue1yT0NALuAP3oi9xe/GPiYoLK',
                                                                                                        /* id du rôle administrateur */
                                                                                                        '9ba9adae-afdc-11ee-a6ad-8a634f6408fc'
                                                                                                        ), (
                                                                                                        'a5b5b1ae-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                        'Fabrice',
                                                                                                        'fabrice@lesgrandsecrans.fr',
                                                                                                        '$2a$12$6bQyJFx6aCvGidym1k.T1u/WWbKue1yT0NALuAP3oi9xe/GPiYoLK',
                                                                                                        /* id du rôle manager */
                                                                                                        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
                                                                                                        ), (
                                                                                                        'a5b5b212-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                        'Alexandre',
                                                                                                        'alexandre@lesgrandsecrans.fr',
                                                                                                        '$2a$12$6bQyJFx6aCvGidym1k.T1u/WWbKue1yT0NALuAP3oi9xe/GPiYoLK',
                                                                                                        /* id du rôle manager */
                                                                                                        '9baa027c-afdc-11ee-a6ad-8a634f6408fc')") !== false) {
                                                                                                            /** Insertion des données dans  la table management: */
                                                                                                            if ($finalPDO->exec(" INSERT INTO management (user_id, cinema_id) VALUES (
                                                                                                            /* id de Fabrice*/
                                                                                                            'a5b5b1ae-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                            /* id du cinéma LIMOGES DUSSOUBS */
                                                                                                            '8e28a252-ae42-11ee-a6ad-8a634f6408fc'
                                                                                                            ), (
                                                                                                            /* id de Laly */
                                                                                                            'a5b5b028-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                            /* id du cinéma LIMOGES BRIAND */
                                                                                                            '8e28a5d6-ae42-11ee-a6ad-8a634f6408fc'
                                                                                                            ), (
                                                                                                            /* id de Romain */
                                                                                                            'a5b5ad94-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                            /* id du cinéma LIMOGES DE GAULLE */
                                                                                                            '8e28a50e-ae42-11ee-a6ad-8a634f6408fc'
                                                                                                            ), (
                                                                                                            /* id de Pierre */
                                                                                                            'a5b5b0f0-afe0-11ee-a6ad-8a634f6408fc',
                                                                                                            /* id du cinéma ARCACHON */
                                                                                                            '8e28a61c-ae42-11ee-a6ad-8a634f6408fc'
                                                                                                            ), (
                                                                                                            /* id de Jérémy */
                                                                                                            'a5b5b154-afe0-11ee-a6ad-8a634408fcf6',
                                                                                                            /* id du cinema LA_TESTE_DE_BUCH */
                                                                                                            '8e28a658-ae42-11ee-a6ad-8a634f6408fc')") !== false) {
                                                                                                                echo '<p>L\'insertion des données dans votre base de donnée s\'est bien déroulée.</p>';
                                                                                                            } else {
                                                                                                                /** Comme pour la création des tables, je ne donne pas trop d'infiormation pour des raisons de sécurité */
                                                                                                                echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                                        }
                                                                                                    } else {
                                                                                                        echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                                    }
                                                                                                } else {
                                                                                                    echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                                }
                                                                                            } else {
                                                                                                echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                            }
                                                                                        } else {
                                                                                            echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                        }
                                                                                    } else {
                                                                                        echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                    }
                                                                                } else {
                                                                                    echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                                }
                                                                            } else {
                                                                                echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                            }
                                                                        } else {
                                                                            echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                        }
                                                                    } else {
                                                                        echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                    }
                                                                } else {

                                                                    echo '<p>Une erreur est survenue dans l\'ajout de vos données.</p>';
                                                                }
                                                            } else {
                                                                /** Je décide de ne pas nommer dans quelle table il y a une erreur pour des raisons de sécurité. */
                                                                echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                                            }
                                                        } else {
                                                            echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                                        }
                                                    } else {
                                                        echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                                    }
                                                } else {
                                                    echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                                }
                                            } else {
                                                echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                            }
                                        } else {
                                            echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                        }
                                    } else {
                                        echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                    }
                                } else {
                                    echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                                }
                            } else {
                                echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                            }
                        } else {
                            echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                        }
                    } else {
                        echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                    }
                } else {

                    echo '<p>Une erreur est survenue dans la création de votre table.</p>';
                }
            } else {
                echo '<p>Une erreur est survenue dans la création de votre base de données.</p>';
            }
        } else {
            echo '<p>Une erreur est survenue dans la suppression de la base de données</p>';
        }
    } catch (PDOException $error) {
        echo $error;
    }
    ?>
