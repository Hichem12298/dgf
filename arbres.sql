CREATE DATABASE IF NOT EXISTS arbres;
USE arbres;

CREATE TABLE IF NOT EXISTS donnees_dendrometriques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    espece VARCHAR(100) NOT NULL,
    diametre FLOAT NOT NULL,
    hauteur FLOAT NOT NULL,
    localisation VARCHAR(100) NOT NULL
);
