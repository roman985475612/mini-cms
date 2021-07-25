CREATE DATABASE IF NOT EXISTS cms_mini;

use cms_mini;

CREATE TABLE IF NOT EXISTS categories (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS articles (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT,
    post TEXT NOT NULL,
    img VARCHAR(255) NOT NULL,
    category_id SMALLINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_articles_categories`
        FOREIGN KEY (category_id) REFERENCES categories (id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS menu (
    id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    href VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

INSERT INTO categories (title) 
VALUES 
    ('Web Development'), 
    ('Tech Gadgets'), 
    ('Business'), 
    ('Health & Wellness');

INSERT INTO menu (title, href) 
VALUES 
    ('home', 'home.html'),
    ('posts', 'posts.html'),
    ('categories', 'categories.html'),
    ('about us', 'about.html'),
    ('contacts', 'contacts.html');

INSERT INTO articles (title, img, category_id, excerpt, post)
VALUE
    ('post one', 'img1.webp', 1, 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis placerat ultricies blandit. Sed ornare enim ac iaculis ornare. Nunc ut ornare.', ' In auctor orci ut massa placerat, non ornare lectus rutrum. Curabitur ut cursus nisi, vel blandit enim. Ut congue diam vitae quam ultricies tristique. Nam vestibulum nibh vel risus ultricies pellentesque. Quisque nec condimentum lacus. Morbi at mi congue tortor congue mattis. Phasellus dictum lorem sit amet iaculis aliquam. Fusce sit amet sapien velit. Aliquam interdum, lorem quis accumsan cursus, mauris magna maximus lectus, et lacinia libero velit sed ante. Maecenas varius venenatis est, ac gravida enim luctus non. Duis blandit eget sem a convallis.'),
    ('post two', 'img2.webp', 2, 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis placerat ultricies blandit. Sed ornare enim ac iaculis ornare. Nunc ut ornare.', ' In auctor orci ut massa placerat, non ornare lectus rutrum. Curabitur ut cursus nisi, vel blandit enim. Ut congue diam vitae quam ultricies tristique. Nam vestibulum nibh vel risus ultricies pellentesque. Quisque nec condimentum lacus. Morbi at mi congue tortor congue mattis. Phasellus dictum lorem sit amet iaculis aliquam. Fusce sit amet sapien velit. Aliquam interdum, lorem quis accumsan cursus, mauris magna maximus lectus, et lacinia libero velit sed ante. Maecenas varius venenatis est, ac gravida enim luctus non. Duis blandit eget sem a convallis.'),
    ('post three', 'img3.webp', 3, 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis placerat ultricies blandit. Sed ornare enim ac iaculis ornare. Nunc ut ornare.', ' In auctor orci ut massa placerat, non ornare lectus rutrum. Curabitur ut cursus nisi, vel blandit enim. Ut congue diam vitae quam ultricies tristique. Nam vestibulum nibh vel risus ultricies pellentesque. Quisque nec condimentum lacus. Morbi at mi congue tortor congue mattis. Phasellus dictum lorem sit amet iaculis aliquam. Fusce sit amet sapien velit. Aliquam interdum, lorem quis accumsan cursus, mauris magna maximus lectus, et lacinia libero velit sed ante. Maecenas varius venenatis est, ac gravida enim luctus non. Duis blandit eget sem a convallis.'),
    ('post four', 'img4.webp', 4, 'Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis placerat ultricies blandit. Sed ornare enim ac iaculis ornare. Nunc ut ornare.', ' In auctor orci ut massa placerat, non ornare lectus rutrum. Curabitur ut cursus nisi, vel blandit enim. Ut congue diam vitae quam ultricies tristique. Nam vestibulum nibh vel risus ultricies pellentesque. Quisque nec condimentum lacus. Morbi at mi congue tortor congue mattis. Phasellus dictum lorem sit amet iaculis aliquam. Fusce sit amet sapien velit. Aliquam interdum, lorem quis accumsan cursus, mauris magna maximus lectus, et lacinia libero velit sed ante. Maecenas varius venenatis est, ac gravida enim luctus non. Duis blandit eget sem a convallis.');
