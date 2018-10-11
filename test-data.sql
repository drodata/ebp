INSERT INTO lookup (name, code, type, position) VALUES 
    ('冻结', 0, 'UserStatus', 1),
    ('正常', 1, 'UserStatus', 2),
    ('未审核', 2, 'UserStatus', 3),
    ('是', 1, 'Boolean', 1),
    ('否', 2, 'Boolean', 2);
INSERT INTO `user_group` VALUES 
    (1,'员工','staff',0)
    ;

/* default password: 123456 */
INSERT INTO `user` (username, password_hash, password_reset_token, access_token, group_id, status) VALUES (
    'admin',
    '$2y$13$qrJfT4ExDCuDclDCqDRRL.FypbYfl98ot.mgmyElho39AcPSZfQtG',
    '$2y$13$BnT.whUJcDH9q5vMnox2We3YtYJnv9wyUQb4vZyS6.HfA2NPIzIL.',
    '4l-Ezuu3pGZRco8Yq3zLHS5_r7FNWbU5XU2hUDseZJKG6a311JbIi57PDhbg',
    1,
    1
);
