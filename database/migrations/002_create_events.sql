CREATE TABLE events(
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    action VARCHAR(32) NOT NULL,
    target VARCHAR(32) DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_events_date (created_at),
    INDEX idx_events_user_date (user_id, created_at),
    INDEX idx_events_action_target_date (action, target, created_at)
);