CREATE TABLE post(
     id INT UNSIGNED NOT NULL AUTO_INCREMENT,
     nom VARCHAR(255) NOT NULL,
     slug VARCHAR(255) NOT NULL,
     contenu TEXT(6000) NOT NULL,
     creation_date DATETIME,
     PRIMARY KEY (id)
)ENGINE = innoDB,
CREATE TABLE categorie(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)

CREATE TABLE post_categorie(
    id_post INT UNSIGNED NOT NULL ,
    id_categorie INT UNSIGNED NOT NULL,
    PRIMARY KEY (id_post,id_categorie),

    CONSTRAINT fk_post
       FOREIGN KEY (id_post)
           REFERENCES post (id)
           ON DELETE CASCADE
           ON UPDATE RESTRICT ,

    CONSTRAINT fk_categorie
       FOREIGN KEY (id_categorie)
           REFERENCES categorie (id)
           ON DELETE CASCADE
           ON UPDATE RESTRICT

)ENGINE = innoDB

CREATE TABLE users(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)ENGINE = innoDB