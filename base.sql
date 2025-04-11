-- Encodage & mode de transaction
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
BEGIN;

-- Table: cache
DROP TABLE IF EXISTS cache;
CREATE TABLE cache (
    key TEXT PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Table: cache_locks
DROP TABLE IF EXISTS cache_locks;
CREATE TABLE cache_locks (
    key TEXT PRIMARY KEY,
    owner TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Table: cart_items
DROP TABLE IF EXISTS cart_items;
CREATE TABLE cart_items (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO cart_items (id, user_id, product_id, quantity, created_at) VALUES
(1, 4, 5, 1, '2025-04-10 14:06:53'),
(2, 2, 13, 1, '2025-04-10 14:30:06');

-- Table: categories
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (id, name, created_at) VALUES
(1, 'Vêtements', '2025-04-10 13:20:24'),
(2, 'Chaussures', '2025-04-10 13:20:24'),
(3, 'Accessoires', '2025-04-10 13:20:24');

-- Table: commandes
DROP TABLE IF EXISTS commandes;
CREATE TABLE commandes (
    id SERIAL PRIMARY KEY,
    nom TEXT NOT NULL,
    adresse TEXT NOT NULL,
    email TEXT NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO commandes (id, nom, adresse, email, date_commande) VALUES
(1, 'bnbn', 'bn,bn', 'ghchgc@hjgj.hjk', '2025-01-10 10:31:53'),
(2, 'dqs', 'nancy', 'Serilizer@Serilizer.com', '2025-01-28 09:26:57');

-- Table: details_commande
DROP TABLE IF EXISTS details_commande;
CREATE TABLE details_commande (
    id SERIAL PRIMARY KEY,
    commande_id INTEGER NOT NULL,
    produit_id INTEGER NOT NULL,
    quantite INTEGER NOT NULL,
    prix NUMERIC(10, 2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
);

-- Table: products
DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id BIGSERIAL PRIMARY KEY,
    category_id INTEGER NOT NULL,
    name TEXT NOT NULL,
    price NUMERIC(8,2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    stock INTEGER DEFAULT 0,
    description TEXT,
    image TEXT DEFAULT 'default.jpg'
);

INSERT INTO products (id, category_id, name, price, stock, description, image) VALUES
(1, 2, 'Sout', 12.00, 5, '', 'default.jpg'),
(2, 1, 'Caravate', 8.00, 15, '', 'caravate.jpg'),
(3, 3, 'Dila3', 8.00, 10, '', 'default.jpg');
