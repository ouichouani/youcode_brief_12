-- Database schema for EvolveAI Questionnaire and Roadmap

-- Questions table
CREATE TABLE IF NOT EXISTS questions (
    id SERIAL PRIMARY KEY,
    question_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- User responses table
CREATE TABLE IF NOT EXISTS user_responses (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    question_id INTEGER REFERENCES questions(id),
    response_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Roadmaps table
CREATE TABLE IF NOT EXISTS roadmaps (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Initial questions
INSERT INTO questions (question_text) VALUES 
('Quel est votre objectif principal ?'),
('Quel est votre niveau actuel dans ce domaine ?'),
('Combien d''heures par semaine pouvez-vous consacrer à l''apprentissage ?'),
('Quelles sont les technologies ou sujets qui vous intéressent le plus ?');
