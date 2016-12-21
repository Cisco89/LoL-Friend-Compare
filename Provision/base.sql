CREATE DATABASE IF NOT EXISTS lol_friend_compare;

USE lol_friend_compare;

CREATE TABLE IF NOT EXISTS player_icon
(
  id INT NOT NULL AUTO_INCREMENT,
  image VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS users
(
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(45) NOT NULL,
  email VARCHAR(45) NOT NULL,
  password VARCHAR(255) NOT NULL,
  last_login DATETIME,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  updated_at DATETIME DEFAULT NOW() NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS division_ranks
(
  id INT NOT NULL AUTO_INCREMENT,
  tier VARCHAR(45) NOT NULL,
  division ENUM('I', 'II', 'III', 'IV', 'V') NOT NULL,
  image VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  updated_at DATETIME DEFAULT NOW() NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS champions
(
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  image VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  updated_at DATETIME DEFAULT NOW() NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS summoners
(
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL,
    summoner_id INT NOT NULL,
    level INT NOT NULL,
    total_champion_mastery INT NOT NULL,
    main_role_played VARCHAR(45) NOT NULL,
    champions_with_points INT NOT NULL,
    player_icon_id INT NOT NULL,
    users_id INT NOT NULL,
    division_ranks_id INT NOT NULL,
    created_at DATETIME DEFAULT NOW() NOT NULL,
    updated_at DATETIME DEFAULT NOW() NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (player_icon_id) REFERENCES player_icon(id),
    FOREIGN KEY (users_id) REFERENCES users(id),
    FOREIGN KEY (division_ranks_id) REFERENCES division_ranks(id)
);

CREATE TABLE IF NOT EXISTS matches
(
    id INT NOT NULL AUTO_INCREMENT,
    role ENUM('Top', 'Jungle', 'Middle', 'Bottom', 'Support') not null,
    victory BOOLEAN NULL,
    summoners_id INT NOT NULL,
    created_at DATETIME DEFAULT NOW() NOT NULL,
    updated_at DATETIME DEFAULT NOW() NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (summoners_id) REFERENCES summoners(id)
);

CREATE TABLE IF NOT EXISTS summoner_champions
(
    id INT NOT NULL AUTO_INCREMENT,
    level INT,
    summoners_id INT NOT NULL,
    champions_id INT NOT NULL,
    created_at DATETIME DEFAULT NOW() NOT NULL,
    updated_at DATETIME DEFAULT NOW() NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (summoners_id) REFERENCES summoners(id),
    FOREIGN KEY (champions_id) REFERENCES champions(id)
);

CREATE TABLE IF NOT EXISTS persistences
(
  id INT NOT NULL AUTO_INCREMENT,
  code VARCHAR(255) NOT NULL,
  user_id INT NOT NULL,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  updated_at DATETIME DEFAULT NOW() NOT NULL,
  PRIMARY KEY (id)
);
