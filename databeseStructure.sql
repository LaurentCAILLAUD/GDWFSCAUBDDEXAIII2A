-- Active: 1704225977462@@127.0.0.1@8889@GDWFSCAUBDDEXAIII2A

/* Création de la base de données (si celle-ci esiste déja, elle n'est pas créee) */

CREATE DATABASE IF NOT EXISTS GDWFSCAUBDDEXAIII2A;

/* En regardant mon diagramme de classes, je vois que les classes Customer et Booking sont associées avec une relation One to Many mais que les classes Movie et Booking ont également une relation One to Many. Je vais donc créée trois tables (Custumers, Bookings et Movies) correspondant à ses trois classes. Etant donné que la table Bookings aura une clé étrangére en rapport à la table Custumers mais également une clé étrangère en rapport à la table movies, je vais commencer par créer les tables custumers et Movies. Je choisi également de ne pas créer ces tables si celles-ci existent déjà.
 Comme vu dans ma description du projet, je choisi de typer les propriétés id de mes trois classes en UUID. Dans la base de donnée cet UUID correspond à un champ de type CHAR(36).  
 Pour la table custumers faisant donc référence à la classe Custumer, les propriétés firstName, lastName, address, town, phoneNumber et email qui sont typées en String seront typées en VARCHAR de 255 caractères. La propriété zipCode sera comme dans la classe typée en INT avec une longueur de 5 chiffres. En effet un code postal est toujours composé de 5 chiffres. Enfin la propriété password qui est de type String dans ma classe sera hashé par le code et sera ensuite stocké dans ma base de données sous forme d'une chaine de caractéres de longueur 60.*/

CREATE TABLE
    IF NOT EXISTS customers (
        id CHAR(36) NOT NULL PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        last_name VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        zip_code INT(5) NOT NULL,
        town VARCHAR(255) NOT NULL,
        phone_number VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(60) NOT NULL
    );

/*Concernant ma classe Movie (classe movies) toutes les propriétés de type String, sauf description, seront typées en VARCHAR avec 255 caractères. La propriété description stockera la description du film. De part sa fonction cette propriété pourra contenir un long text (plus de 255 caractères). Pour cette raison dans ma table movies, je choisi de typer le champ description en TEXT. Le champ castList sera typée en JSON car ma base de données ne possède pas de type ARRAY. */

CREATE TABLE
    IF NOT EXISTS movies (
        id CHAR(36) NOT NULL PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        type VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        poster VARCHAR(255) NOT NULL,
        trailer VARCHAR(255) NOT NULL,
        cast_list JSON NOT NULL,
        director_name VARCHAR(255) NOT NULL
    );

/*Je peux maintenant crée ma table bookings correspondant à ma classe Booking. Les propriétés fullPricePlace, reducedPricePlace et under14Place seront des champs de type Int(3). Je choisi de mettre 3 en longeur même si il est impossible qu'un client est réservé plus de 999 places. Pour ce qui est de la propriété totalMount celle-ci sera typée en DECIMAL dans la table avec en longueur avant la virgule 4 chiffres et après la virgule 2 chiffres. Enfin la propriété isPaid sera typée,elle, en BOOLEAN. Et pour finir la création de cette table, je crée les champs reserved_by et reserved qui seront respectivement  la clé étrangére faisant référence à la table customers et la clé étrangère faisant référence à la table movies.*/

CREATE TABLE
    IF NOT EXISTS bookings (
        id CHAR(36) NOT NULL PRIMARY KEY,
        full_price_place INT(3) NOT NULL,
        reduced_price_place INT(3) NOT NULL,
        under_14_place INT(3) NOT NULL,
        total_mount DECIMAL(4, 2) NOT NULL,
        is_paid BOOLEAN NOT NULL,
        reserved_by CHAR(36) NOT NULL,
        reserved CHAR(36) NOT NULL,
        FOREIGN KEY (reserved_by) REFERENCES customers(id),
        FOREIGN KEY (reserved) REFERENCES movies(id)
    );

/* Afin de continuer dans la relation One To Many, j'observe que la classe MovieRoom posséde cette relation avec la classe Movie. Je décide donc de créer une table movies_room correspondant à la classe MovieRoom. Rien de compliqué dans le typage des champs de ma table et il faut que je crée un champ projected faisant référence à la table movies. */

CREATE TABLE
    IF NOT EXISTS movies_room (
        id CHAR(36) NOT NULL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        number_of_place INT(4) NOT NULL,
        projected CHAR(36) NOT NULL,
        FOREIGN KEY (projected) REFERENCES movies(id)
    );

/*Je passe maintenant à la classe Cinema. Je crée donc une table cinemas. Cette table posséde une relation de type Many To Many. Afin de gérer cette relation je vais créer une table associative que je nomme on_display et qui géréra l'association en les tables movies et cinemas avec une clé étranére par tables. Le typage des champ de ma table cinemas ne pose pas de souci et comporte que des types vus déjà précédemment. */

CREATE TABLE
    IF NOT EXISTS cinemas (
        id CHAR(36) NOT NULL PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        address VARCHAR(255) NOT NULL,
        zip_code INT(5) NOT NULL,
        town VARCHAR(255) NOT NULL,
        phone_number VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        numberOfMoviesRoom INT(3) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS on_display (
        movie_id CHAR(36) NOT NULL,
        cinema_id CHAR(36) NOT NULL,
        PRIMARY KEY (movie_id, cinema_id),
        FOREIGN KEY (movie_id) REFERENCES movies (id),
        FOREIGN KEY (cinema_id) REFERENCES cinemas(id)
    );

/* Je m'attaque maintenant à la classe SessionSchedule en créant une table sessions_schedule. Cette dernière possède également une relation de type Many To Many avec la table movies. Je crée donc une table associative que je nomme projected_film. */

CREATE TABLE
    IF NOT EXISTS sessions_schedule (
        id CHAR(36) NOT NULL PRIMARY KEY,
        session DATETIME NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS projected_film (
        movie_id CHAR(36) NOT NULL,
        session_schedule_id CHAR(36) NOT NULL,
        PRIMARY KEY (movie_id, session_schedule_id),
        FOREIGN KEY (movie_id) REFERENCES movies (id),
        FOREIGN KEY (session_schedule_id) REFERENCES sessions_schedule(id)
    );

/* Pour finir la partie front-end, il me reste à créer la table prices qui correspond à la classe Price. Cette classe n'a aucune relation avec une autre table.*/

CREATE TABLE
    IF NOT EXISTS prices (
        id CHAR(36) NOT NULL PRIMARY KEY,
        price_category VARCHAR(255) NOT NULL,
        price DECIMAL(4, 2) NOT NULL
    );

/* Je passe maintenant à la partie back-end. Je décide de m'occuper en premier des classes Role et User. Je crée donc deux tables qui porteront le nom roles et users. Ces deux tables ont une relation One To Many. La table users aura une référence vers la table roles. Il faut donc que je crée en premier la table roles. */

CREATE TABLE
    IF NOT EXISTS roles (
        id CHAR(36) NOT NULL PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    );

CREATE TABLE
    IF NOT EXISTS users (
        id CHAR(36) NOT NULL PRIMARY KEY,
        first_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(60) NOT NULL,
        has_role CHAR(36) NOT NULL,
        FOREIGN KEY (has_role) REFERENCES roles (id)
    );

/* Pour finir la création de ma base de données, je m'intéresse aux classes User et Cinema. Les deux tables correspondant à ces classes sont crées mais la relation entre elles n'est pas encore gérée. Ces tables ont une relation Many To Many. Il faut donc que je crée une table associative afin de gérer cette relation. Je décide pour cela de créer une table qui portera le nom management. */

CREATE TABLE
    IF NOT EXISTS management (
        user_id CHAR(36) NOT NULL,
        cinema_id CHAR(36) NOT NULL,
        PRIMARY KEY (user_id, cinema_id),
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (cinema_id) REFERENCES cinemas(id)
    );

/* Notre base de données étant construite, la suite de l'exercice consiste maintenant à inserer des données factices dans nos différentes tables: */
/* Afin que les id qui seront utlisés dans plusieurs tables ne changent pas à chaque éxecution des commandes SQL, je choisi en lieu et place de la fonction UUID()  d'inscrire "en dur" la chaine de caractères. Il est a noté que les id qui ne seront pas repris dans plusieurs tables seront eux créés avec la fonction UUID */

/* Nous commencons à insérer des données dans la table customers. Pour le mot de passe, je me suis servi d'un crypteur en ligne: */
INSERT INTO
    customers (
        id,
        first_name,
        last_name,
        address,
        zip_code,
        town,
        phone_number,
        email,
        password
    )
VALUES (
        'cb2ebef4-ad9b-11ee-b481-4c766cb95eaa',
        'Laurent',
        'CAILLAUD',
        '8 chemin des manses',
        87110,
        'SOLIGNAC',
        '06.46.73.35.30',
        'laurent.caillaud@icloud.com',
        '$2a$12$dpvgRO0e1Yttws9Q3hYD7euwYI1qTJsMEyx8NXat7/90WrjXGrGtq'
    ), (
        'cb2ec1d8-ad9b-11ee-b481-4c766cb95eaa',
        'Fabien',
        'MARTENOT',
        '15 rue Sainte Claire',
        87410,
        'LE PALAIS SUR VIENNE',
        '06.40.63.88.54',
        'fabien.martenot@yahoo.fr',
        '$2a$12$44/QOB00hnlWL0AoSsj0Zex/khNt7WWL.4Rh604Wlbx.53GeMYeFG'
    ), (
        'cb2ec28c-ad9b-11ee-b481-4c766cb95eaa',
        'Claude',
        'VOISIN',
        '14 rue Marcel PAGNOL',
        87700,
        'AIXE SUR VIENNE',
        '07.54.88.02.24',
        'cl.voisin@orange.fr',
        '$2a$12$bz/f6imKZM1hk0mIYti8Xed8AliGhO7CyhDK2cuVPfo1WnmI4qpdC'
    ), (
        'cb2ec2dc-ad9b-11ee-b481-4c766cb95eaa',
        'Coralie',
        'DARD',
        '37 rue Albert THOMAS',
        87220,
        'FEYTIAT',
        '06.38.01.24.16',
        'dardcoralie@free.fr',
        '$2a$12$Do3qdvdCsbd2K9d7xhxIbuwJ35fNKrlfGvZQWxp/Yq9nw0KEGrqL2'
    ), (
        'cb2ec318-ad9b-11ee-b481-4c766cb95eaa',
        'Caroline',
        'CEDRE',
        '3 avenue Martin LUTHER KING',
        87000,
        'LIMOGES',
        '07.24.16.87.37',
        'cedre.caroline@hotmail.com',
        '$2a$12$X/GtCgdlnVYhs0f098rgVun0GvWTam1ixJdiBxsTgJzKepR6lYBd2'
    );

/*Insertions des données dans la table movies: */
INSERT INTO
    movies (
        id,
        title,
        type,
        description,
        poster,
        trailer,
        cast_list,
        director_name
    )
VALUES (
        '257cdc3e-ad9b-11ee-b481-4c766cb95eaa',
        'MAISON DE RETRAITE 2',
        'Comédie',
        'Quand le foyer Lino Vartan, qui accueille jeunes orphelins et seniors, doit fermer pour raisons sanitaires, Milann n’a pas d’autre choix que de répondre à l’invitation d’une maison de retraite dans le Sud qui les accueille pour l’été. Tous embarquent dans le bus d’Alban. Enfants et anciens découvrent alors le Bel Azur Club, une villa idyllique au bord de la mer : le rêve ! Une aubaine pour ces gamins orphelins qui n’ont jamais eu de vacances... Mais le paradis tourne à l’enfer car anciens et nouveaux pensionnaires du 3e âge se détestent ! La guerre des seniors est déclarée !',
        'https://all.web.img.acsta.net/pictures/23/11/28/14/21/0273666.jpg',
        'https://www.grandecran.fr/films/313914-maison-de-retraite-2/?playTrailer',
        '[{"firstname" : "Kev", "lastname" : "ADAMS"},{"firstname" : "Jean", "lastname" : "RENO"}, {"firstname" : "Daniel", "lastname" : "PREVOST"}]',
        'Claude ZIDI'
    ), (
        '257ce1ac-ad9b-11ee-b481-4c766cb95eaa',
        'IRIS ET LES HOMMES',
        'Drame',
        'Un mari formidable, deux filles parfaites, un cabinet dentaire florissant : tout va bien pour Iris. Mais depuis quand n’a-t-elle pas fait l’amour ? Peut-être est-il temps de prendre un amant. S\'inscrivant sur une banale appli de rencontre, Iris ouvre la boite de Pandore. Les hommes vont tomber… Comme s’il en pleuvait !',
        'https://all.web.img.acsta.net/pictures/23/11/20/10/50/5902027.jpg',
        'https://www.grandecran.fr/films/307775-iris-et-les-hommes/?playTrailer',
        '[{"firstname" : "Laure", "lastname" : "CALAMY"},{"firstname" : "Vincent", "lastname" : "ELBAZ"}, {"firstname" : "Suzanne", "lastname" : "DE BAECQUE"}]',
        'Caroline VIGNAL'
    ), (
        '257ce3d2-ad9b-11ee-b481-4c766cb95eaa',
        'AMOUR A LA FINLANDAISE',
        'Romance',
        'Julia découvre que son mari a une liaison. Pour sauver leur mariage, elle lui propose d’expérimenter le polyamour et d\'inventer les nouvelles règles de leur vie conjugale. Un champ des possibles amoureux s’ouvre alors à eux…',
        'https://all.web.img.acsta.net/pictures/23/11/29/10/32/1466059.jpg',
        'https://www.grandecran.fr/films/302245-amours-a-la-finlandaise/?playTrailer',
        '[{"firstname" : "Eero", "lastname" : "MILANOFF"},{"firstname" : "Alma", "lastname" : "PÖYSTI"}, {"firstname" : "Oona", "lastname" : "AIROLA"}]',
        'Selma VILHUNEN'
    ), (
        '257ce508-ad9b-11ee-b481-4c766cb95eaa',
        '5 HECTARES',
        'Comédie',
        'Qu’est-ce qui conduit un homme établi à mettre en péril son confort, sa carrière et son couple ? La passion, d’autant plus brûlante qu’elle est tardive, pour cinq hectares de terre limousine. Mais la terre se mérite, surtout quand on vient de la ville. Voilà Franck précipité dans la quête du Graal. Il lui faut un tracteur.',
        'https://all.web.img.acsta.net/pictures/23/11/22/09/32/4239619.jpg',
        'https://www.grandecran.fr/films/286638-5-hectares/?playTrailer',
        '[{"firstname" : "Lambert", "lastname" : "WILSON"},{"firstname" : "Marina", "lastname" : "HANDS"}, {"firstname" : "Laurent", "lastname" : "POITRENAUX"}]',
        'Emile DELEUZE'
    ), (
        '257ce62a-ad9b-11ee-b481-4c766cb95eaa',
        'MOI CAPITAINE',
        'Drame',
        'Seydou et Moussa, deux jeunes sénégalais de 16 ans, décident de quitter leur terre natale pour rejoindre l’Europe. Mais sur leur chemin les rêves et les espoirs d’une vie meilleure sont très vite anéantis par les dangers de ce périple. Leur seule arme dans cette odyssée restera leur humanité.',
        'https://all.web.img.acsta.net/pictures/23/10/11/09/12/4467686.jpg',
        'https://www.grandecran.fr/films/300927-moi-capitaine/?playTrailer',
        '[{"firstname" : "Seydou", "lastname" : "SARR"},{"firstname" : "Moustapha", "lastname" : "FALL"}, {"firstname" : "Issaka", "lastname" : "SAWADOGO"}]',
        'Mattéo GARRONE'
    );
/* Insertion des données dans la table Bookings: */
INSERT INTO
    bookings (
        id,
        full_price_place,
        reduced_price_place,
        under_14_place,
        total_mount,
        is_paid,
        reserved_by,
        reserved
    )
VALUES (
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
        '257ce508-ad9b-11ee-b481-4c766cb95eaa'
    );

/* Insertion des données dans la table movies_room: */
INSERT INTO
    movies_room (
        id,
        name,
        number_of_place,
        projected
    )
VALUES (
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
        '257cdc3e-ad9b-11ee-b481-4c766cb95eaa'
    );

/* Insertion des données dans la table cinema: */
INSERT INTO
    cinemas (
        id,
        name,
        address,
        zip_code,
        town,
        phone_number,
        email,
        numberOfMoviesRoom
    )
VALUES (
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
        'cinemalateste@lesgrandsecrans.fr',
        4
    );

/* Insertion des données dans la table on_display: */
INSERT INTO
    on_display (movie_id, cinema_id)
VALUES (
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
        '8e28a252-ae42-11ee-a6ad-8a634f6408fc'
    );

/* Insertion des données dans la table sessions_schedule */
INSERT INTO
    sessions_schedule (id, session)
VALUES (
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
        '2024-01-06 22:10:00'
    );

/* Insertion des donnérs dans la table projected_film */
INSERT INTO
    projected_film (movie_id, session_schedule_id)
VALUES (
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
        '1f77acf8-afd8-11ee-a6ad-8a634f6408fc'
    );

/* Insertion des données dans la table prices */
INSERT INTO
    prices (id, price_category, price)
VALUES (UUID(), 'Plein tarif', 9.20), (UUID(), 'Tarif étudiant', 7.60), (
        UUID(),
        'Moins de 14 ans',
        5.90
    );

/* Insertion des données dans la table roles */
INSERT INTO roles (id, name)
VALUES (
        '9ba9adae-afdc-11ee-a6ad-8a634f6408fc',
        'Administrateur'
    ), (
        '9baa027c-afdc-11ee-a6ad-8a634f6408fc',
        'Manager'
    );

/* Insertion des données dans la table users */
INSERT INTO
    users (
        id,
        first_name,
        email,
        password,
        has_role
    )
VALUES (
        'a5b5ad94-afe0-11ee-a6ad-8a634f6408fc',
        'Romain',
        'romain@lesgrandsecrans.fr',
        '$2a$12$l57jQ8abMMYO24IXphFJTOZAInQvFloE.Y2GeJhy7SyAaFgUX.qfy',
        /* id du rôle manager */
        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
    ), (
        'a5b5b028-afe0-11ee-a6ad-8a634f6408fc',
        'Laly',
        'laly@lesgrandslimoges.fr',
        '$2a$12$uqoxKIiSGjGWQGtEJ0EbE.PfcXWljGJZPnWaWfBYqDhJY3lZJDeCG',
        /* id du rôle manager */
        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
    ), (
        'a5b5b0f0-afe0-11ee-a6ad-8a634f6408fc',
        'Pierre',
        'laly@lesgrandsecrans.fr',
        '$2a$12$rsM7UXDeCCJ21yGrlOChdOD6iqqzQ4nh3FUR7MV36JNpgG5mZGzxW',
        /* id du rôle manager */
        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
    ), (
        'a5b5b154-afe0-11ee-a6ad-8a634408fcf6',
        'Jérémy',
        'jeremy@lesgrandsecrans.fr',
        '$2a$12$XKnwC03DyXeTVDKzbwYhJOp2DoSnLlvWrZNxd9TjfBl2zL53PxrDO',
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
        '$2a$12$wO0QJQXjBWJb.92DHDoXw.B/114yIpx.dCyst0rGGC6/4iBoMwQ32',
        /* id du rôle manager */
        '9baa027c-afdc-11ee-a6ad-8a634f6408fc'
    );

/* Insertion des données dans la table management */
INSERT INTO
    management (user_id, cinema_id)
VALUES (
        /* id de Fabrice*/
        'a5b5b1ae-afe0-11ee-a6ad-8a634f6408fc',
        /* id  du cinéma LIMOGES DUSSOUBS */
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
        '8e28a658-ae42-11ee-a6ad-8a634f6408fc'
    );