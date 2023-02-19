-- Active: 1649088972771@@127.0.0.1@3306@GDWFSCAUBDDEXAIII2A

/* Création de la base de données (si celle-ci esiste déja, elle n'est pas créee) */

CREATE DATABASE IF NOT EXISTS GDWFSCAUBDDEXAIII2A;

/* En regardant mon diagramme de classes, je vois que les classes Customer et Booking sont associées avec une relation One to Many mais que les classes Movie et Booking ont également une relation One to Many. Je vais donc créée trois tables (Custumers, Bookings et Movies) correspondant à ses trois classes. Etant donné que la table Bookings aura une clé étrangére en rapport à la table Custumers mais également une clé étrangère en rapport à la table movies, je vais commencer par créer les tables custumers et Movies. Je choisi également de ne pas créer ces tables si celles-ci existent déjà.
 Comme vu dans ma description du projet, je choisi de typer les propriétés id de mes trois classes en UUID. Dans la base de donnée cet UUID correspond à un champ de type CHAR(36).  
 Pour la table custumers faisant donc référence à la classe Custumer, les propriétés firstName, lastName, address, town, phoneNumber et email qui sont typées en String seront typées en VARCHAR de 255 caractères. La propriété zipCode sera comme dans la classe typée en INT avec une longueur de 5 chiffres. En effet un code postal est toujours composé de 5 chiffres. Enfin la propriété password qui est de type String dans ma classe sera hashé par le code et sera ensuite stocké dans ma base de données sous forme d'une chaine de caractéres de longueur 60.*/

CREATE TABLE
    IF NOT EXISTS custumers (
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

/*Concernant ma classe Movie (table movies) toutes les propriétés de type String, sauf description, seront typées en VARCHAR avec 255 caractères. La propriété description stockera la description du film. De part sa fonction cette propriété pourra contenir un long text (plus de 255 caractères). Pour cette raison dans ma table movies, je choisi de typer le champ description en TEXT. Le champ castList sera typée en JSON car ma base de donnée ne possède pas de type ARRAY. */

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

/*Je peux maintenant crée ma table bookings correspondant à ma table Booking. Les propriétés fullPricePlace, reducedPricePlace et under14Place seront des champs de type Int(3). Je choisi de mettre 3 en longeur même si il est impossible qu'un client est réservé plus de 999 places. Pour ce qui est de la propriété totalMount celle-ci sera typée en DECIMAL dans la table avec en longueur avant la virgule 4 chiffres et après la virgule 2 chiffres. Enfin la propriété isPaid sera typée,elle, en BOOLEAN. Et pour finir la création de cette table, je crée les champs reserved_by et reserved qui seront respectivement  la clé étrangére faisant référence à la table customers et la clé étrangère faisant référence à la table movies.*/

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
        FOREIGN KEY (reserved_by) REFERENCES custumers(id),
        FOREIGN KEY (reserved) REFERENCES movies(id)
    );