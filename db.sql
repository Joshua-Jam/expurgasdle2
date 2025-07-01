CREATE DATABASE IF NOT EXISTS gamedle;
USE gamedle;

-- user: sql  password: 123

CREATE TABLE personagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  campanha VARCHAR(100),
  tipo VARCHAR(50),
  especie VARCHAR(50),
  funcao VARCHAR(50),
  idade INT
);

-- Inserção de exemplo
INSERT INTO personagens (nome, campanha, tipo, especie, funcao, idade) VALUES
('Misu Tsune', 'Despertar', 'Jogador', 'Humano', 'Feiticeiro Estudante', 15),
('Brahka Daeos', 'Expurgação', 'Jogador', 'Draconato', 'Aventureiro', 44),
('Athulyth', 'Relíquias Sagradas', 'Jogador', 'Meio Elfo', 'Aventureiro', 87);

-- Tabela para armazenar o personagem do enigma diário
CREATE TABLE IF NOT EXISTS enigma_do_dia (
  data DATE PRIMARY KEY,
  personagem_id INT,
  FOREIGN KEY (personagem_id) REFERENCES personagens(id)
);
