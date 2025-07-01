IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = N'gamedle')
BEGIN
    CREATE DATABASE gamedle;
END
GO
USE gamedle;

-- user: sql  password: 123

CREATE TABLE personagens (
  id INT IDENTITY(1,1) PRIMARY KEY,
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
('Athulyth', 'Relíquias Sagradas', 'Jogador', 'Meio Elfo', 'Aventureiro', 87),
('Seanru', 'Relíquias Sagradas', 'Auxiliar', 'Draconato', 'Aventureiro', 87);
