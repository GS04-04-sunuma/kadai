/* データベースの作成 */
CREATE DATABASE IF NOT EXISTS cakephpdb CHARACTER SET utf8 COLLATE utf8_general_ci;


/* テーブルの作成 */
CREATE TABLE IF NOT EXISTS book_data (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(100),
    title VARCHAR(200),
    author VARCHAR(100),
    manufacturer VARCHAR(100),
    imgM VARCHAR(200),
    imgL VARCHAR(200),
    searchName VARCHAR(100)
)
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS book_evaluations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_id INT,
    story INT,
    drawing_skill INT,
    chara_appeal INT,
    world_view INT,
    total INT,
    body TEXT,
    created DATETIME DEFAULT NULL
)
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS search_names (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
    count INT
)
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS rank_data  (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_id INT,
    title VARCHAR(200),
    author VARCHAR(100),
    manufacturer VARCHAR(100),
    imgM VARCHAR(200),
    imgL VARCHAR(200),
    story INT,
    drawing_skill INT,
    chara_appeal INT,
    world_view INT,
    total INT,
    type VARCHAR(20),
    rank INT
)
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS tag_data (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_id INT,
    tag_name VARCHAR(100)
)
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;