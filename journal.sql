-- https://dba.stackexchange.com/questions/76788/create-a-database-with-charset-utf-8
CREATE DATABASE IF NOT EXISTS Journal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
Use Journal;

CREATE TABLE IF NOT EXISTS Diary (
    inserted_at TIMESTAMP PRIMARY KEY,
    entry TEXT NOT NULL,
    user VARCHAR(10) NOT NULL,
    index (user),
    FULLTEXT (entry)
);

CREATE TABLE IF NOT EXISTS Mood (
    day DATE PRIMARY KEY,
    score TINYINT(1) NOT NULL,
    user VARCHAR(10) NOT NULL,
    index (user),
    index (score)
);

CREATE TABLE IF NOT EXISTS Users (
    user VARCHAR(10) PRIMARY KEY,
    hash VARCHAR(60) NOT NULL
);