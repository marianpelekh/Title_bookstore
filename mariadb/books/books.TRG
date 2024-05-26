TYPE=TRIGGERS
triggers='CREATE DEFINER=`marianpelekh`@`%` TRIGGER `AutoInsert` AFTER INSERT ON `books` FOR EACH ROW BEGIN\n    DECLARE author_name VARCHAR(255);\n    DECLARE cur CURSOR FOR SELECT DISTINCT TRIM(author) FROM (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.Author, \',\', numbers.n), \',\', -1) author FROM (SELECT 1 n UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) numbers INNER JOIN books ON CHAR_LENGTH(NEW.Author) - CHAR_LENGTH(REPLACE(NEW.Author, \',\', \'\')) >= numbers.n-1) AS x;\n    DECLARE CONTINUE HANDLER FOR NOT FOUND SET @done = 1;\n\n    OPEN cur;\n\n    read_loop: LOOP\n        FETCH cur INTO author_name;\n\n        IF @done THEN\n            LEAVE read_loop;\n        END IF;\n\n        IF NOT EXISTS (SELECT 1 FROM authors WHERE AuthorName = author_name) THEN\n            INSERT INTO authors (AuthorName) VALUES (author_name);\n        END IF;\n    END LOOP;\n\n    CLOSE cur;\nEND' 'CREATE DEFINER=`marianpelekh`@`%` TRIGGER `AutoPublAdd` AFTER INSERT ON `books` FOR EACH ROW BEGIN\n    IF NOT EXISTS (SELECT * FROM publishings WHERE PublName = NEW.Publishing) THEN\n        INSERT INTO publishings (PublName) VALUES (NEW.Publishing);\n    END IF;\nEND'
sql_modes=524288 524288
definers='marianpelekh@%' 'marianpelekh@%'
client_cs_names='utf8mb4' 'utf8mb4'
connection_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
db_cl_names='utf8mb4_general_ci' 'utf8mb4_general_ci'
created=1716737663977853 1716737664004251
