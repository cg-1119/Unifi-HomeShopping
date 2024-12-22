CREATE TABLE users
(
    uid       INT AUTO_INCREMENT PRIMARY KEY,
    id        VARCHAR(30)  NOT NULL UNIQUE,
    pw        VARCHAR(255) NOT NULL,
    name      VARCHAR(10)  NOT NULL,
    email     VARCHAR(50)  NOT NULL UNIQUE,
    phone     VARCHAR(20)  NOT NULL UNIQUE,
    address   TEXT,
    is_active TINYINT(1) DEFAULT 1,
    is_admin  BOOLEAN DEFAULT 0
);
CREATE TABLE products
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    price       DECIMAL(10)  NOT NULL,
    category    VARCHAR(100) DEFAULT NULL,
    description TEXT         DEFAULT NULL
);

CREATE TABLE product_images
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    product_id   INT          NOT NULL,
    file_path    VARCHAR(255) NOT NULL,
    is_thumbnail TINYINT(1) DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products (id)
);

CREATE TABLE orders
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    user_id         INT NOT NULL,
    address         VARCHAR(255) DEFAULT NULL,
    phone           VARCHAR(20)  DEFAULT NULL,
    order_date      DATETIME     DEFAULT CURRENT_TIMESTAMP,
    status          ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',                      -- 주문 상태
    delivery_status ENUM('pending', 'shipped', 'delivered') DEFAULT 'pending',                        -- 배달 상태
    cancel_reason   ENUM('change_of_mind', 'wrong_purchase', 'add_more_items', 'other') DEFAULT NULL, -- 주문 취소 사유
    FOREIGN KEY (user_id) REFERENCES users (uid)
);
CREATE TABLE order_details
(
    id         INT AUTO_INCREMENT PRIMARY KEY, -- 주문 상세 ID
    order_id   INT NOT NULL,
    product_id INT NOT NULL,
    quantity   INT NOT NULL,
    price      INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
);
CREATE TABLE payments
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    order_id       INT,
    payment_method VARCHAR(50) NOT NULL,               -- 결제 방식
    payment_info   VARCHAR(255),                       -- > 결제 정보 구현x
    payment_price  INT         NOT NULL,               -- 결제 금액
    payment_date   DATETIME DEFAULT CURRENT_TIMESTAMP, -- 결제 날짜
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
);

CREATE TABLE product_reviews
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT  NOT NULL,
    user_id    INT  NOT NULL,
    rate       INT  NOT NULL,
    content    TEXT NOT NULL,
    image_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users (uid) ON DELETE CASCADE
);

CREATE TABLE wishlist
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    product_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (uid) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE,
    UNIQUE KEY (user_id, product_id) -- 동일한 상품을 중복으로 찜하지 않도록 설정
);

CREATE TABLE points
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT,
    order_id   INT,
    point      INT NOT NULL,
    type       ENUM('purchase', 'review', 'use', 'cancel', 'other'),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (uid) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE
);