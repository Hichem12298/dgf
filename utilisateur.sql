CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL,
    accepte BOOLEAN DEFAULT FALSE
);

-- Compte administrateur par défaut
INSERT INTO utilisateurs (email, password, role, accepte)
VALUES (
    'administrateur@gmail.com',
    '$2y$10$qw2mRO7s7A0uJDNzZImtxeb5KbWZCJ6/U7UmIGOPFLUC0xKkIXTQG', -- hash du mot de passe "123"
    'admin',
    TRUE
);
