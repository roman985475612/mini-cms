-- Remove column user_id to articles
ALTER TABLE articles DROP FOREIGN KEY `fk_articles_users`; 
ALTER TABLE articles DROP `user_id`;
