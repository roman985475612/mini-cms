-- Add column user_id to articles
ALTER TABLE articles 
    ADD user_id SMALLINT UNSIGNED NOT NULL DEFAULT 1;

ALTER TABLE articles 
    ADD CONSTRAINT `fk_articles_users` 
        FOREIGN KEY (user_id)
        REFERENCES users (id)
            ON DELETE CASCADE
            ON UPDATE RESTRICT;