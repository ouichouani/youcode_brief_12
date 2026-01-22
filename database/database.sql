-- Active: 1768299577181@@127.0.0.1@5432@EvolveAI
/*
offfff

 - users (id, name, email, password_hash, email_verified_at, reset_token, reset_token_expires_at, level, created_at)
 - roadmap (id, #FK user_id, step, content, skills[], duration, passed)
 - plan (id, #FK user_id, #FK roadmap_id, completion_percentage, ai_notes, last_updated)
 - tasks (id, #FK plan_id, title, description, due_date, difficulty, status, created_at)
 - task_submissions (id, #FK task_id, #FK user_id, submission_type, content, ai_feedback, score, submitted_at)
 - question (id, content, created_at)
 - answers (id, #FK user_id, #FK question_id, content, created_at)
 - opportunities (id, title, description, estimated_income, external_link, market_source, created_at, #FK user_id)
 - skills (id, name, description, category, #FK user_id)
 - posts (id, #FK user_id, title, content, type, created_at)
 - comments (id, #FK user_id, #FK post_id, content, created_at)
 - likes (id, #FK user_id, #FK post_id, created_at)

*/


-- DATABASE CREATION 
CREATE DATABASE youcode_brief_12 ;
 youcode_brief_12 ;


-- ENUM CREATION
CREATE TYPE task_status_enum AS ENUM ('pending', 'completed', 'blocked');

CREATE TYPE submission_type_enum AS ENUM ('text', 'file', 'link');

CREATE TYPE post_type_enum AS ENUM ('question', 'experience', 'advice');

CREATE TYPE skill_category_enum AS ENUM ('AI', 'business', 'dev', 'marketing', 'other');

CREATE TYPE market_source_enum AS ENUM ('fiverr', 'upwork', 'saas', 'other');

-- TABLE CREATION

CREATE TABLE "users" (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    email_verified_at TIMESTAMP NULL,
    reset_token TEXT,
    reset_token_expires_at TIMESTAMP,
    level INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE roadmap (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    step INT NOT NULL,
    content TEXT NOT NULL,
    skills TEXT [], -- array of skill names or tags
    duration VARCHAR(50),
    passed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE plan (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    roadmap_id BIGINT REFERENCES roadmap (id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    completion_percentage INT DEFAULT 0 CHECK (
        completion_percentage BETWEEN 0 AND 100
    ),
    ai_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE tasks (
    id SERIAL PRIMARY KEY,
    plan_id BIGINT REFERENCES plan (id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    difficulty INT CHECK (difficulty BETWEEN 1 AND 5),
    status task_status_enum DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE task_submissions (
    id SERIAL PRIMARY KEY,
    task_id BIGINT REFERENCES tasks (id) ON DELETE CASCADE,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    submission_type submission_type_enum NOT NULL,
    content TEXT,
    ai_feedback TEXT,
    score INT CHECK (score BETWEEN 0 AND 100),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE question (
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE answers (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    question_id BIGINT REFERENCES questions (id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE opportunities (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE SET NULL ,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    estimated_income NUMERIC(10, 2),
    external_link TEXT,
    market_source market_source_enum,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE skills (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE SET NULL ,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    category skill_category_enum DEFAULT 'other'
);

CREATE TABLE posts (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    type post_type_enum NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    post_id BIGINT REFERENCES posts (id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE likes (
    id SERIAL PRIMARY KEY,
    user_id BIGINT REFERENCES users (id) ON DELETE CASCADE,
    post_id BIGINT REFERENCES posts (id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--ali's sql 


-- User responses table
-- drop table user_responses;
CREATE TABLE IF NOT EXISTS user_responses (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    question_id INTEGER REFERENCES question (id),
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
INSERT INTO question (CONTENT) VALUES
('What''s your age?'),
('What''s your main goal?'),
('Which best describes you?'),
('Which income stream are you most familiar with?'),
('What''s your current work schedule?'),
('What issues are you facing at work?'),
('How many hours do you usually work each day?'),
('How many hours would you like to work each day?'),
('How do you feel about your money right now?'),
('Have you ever tried making money outside your main job?'),
('How confident are you with AI tools?'),
('Have you used any of these AI tools before?'),
('What areas would you love to explore?'),
('Are you open to picking up new skills?'),
('How ready are you to dive into AI?'),
('Do you have a dream goal you''re working toward?'),
('How much time can you invest in your goals daily?'),
('How well can you stay focused?'),
('Which device will you use for learning?'),
('What type of lesson format do you prefer?');

select * from users;
select * from questions;
