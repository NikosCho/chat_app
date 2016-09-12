CREATE TABLE IF NOT EXISTS USERS(
   UID INTEGER PRIMARY KEY     NOT NULL,
   username           TEXT    NOT NULL
);

CREATE TABLE IF NOT EXISTS MESSAGES(
   MID INTEGER PRIMARY KEY 	NOT NULL,
   s_UID INT 			NOT NULL,
   r_UID INT 			NOT NULL,
   mtext TEXT 			NOT NULL,
   mdatetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);