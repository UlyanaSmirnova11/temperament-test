CREATE TABLE IF NOT EXISTS questions (
    id SERIAL PRIMARY KEY,
    question_text TEXT NOT NULL,
    option_a TEXT,
    option_b TEXT,
    option_c TEXT,
    option_d TEXT,
    correct_answer CHAR(1),
    temperament_type VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS test_results (
    id SERIAL PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    choleric_score INTEGER DEFAULT 0,
    sanguine_score INTEGER DEFAULT 0,
    phlegmatic_score INTEGER DEFAULT 0,
    melancholic_score INTEGER DEFAULT 0,
    dominant_temperament VARCHAR(20),
    test_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
