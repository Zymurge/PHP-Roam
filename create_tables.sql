

CREATE TABLE IF NOT EXISTS locations (
	id        INT NOT NULL PRIMARY KEY,
	name      VARCHAR(30) NOT NULL,
	description TEXT NULL
);

CREATE TABLE IF NOT EXISTS paths (
	id        INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	node1     INT NOT NULL,
	node2     INT NOT NULL,
	distance  INT NOT NULL
);

CREATE TABLE IF NOT EXISTS people (
	id        INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	name      VARCHAR(30) NOT NULL UNIQUE,
	description TEXT NULL
);

CREATE TABLE IF NOT EXISTS people_map (
	location_id  INT NOT NULL,
	person_id    INT NOT NULL 
);

CREATE TABLE IF NOT EXISTS visits (
	location  INT NOT NULL KEY,
	time      TIMESTAMP 
);


INSERT INTO locations ( id, name, description ) VALUES 
	( 1, "Sweden", "A very Swedish place." ),
	( 2, "Denmark", "A happy country." ),
	( 3, "Russia", "You can feel the comraderie here." ),
	( 4, "Belgium", "Ummmm, beer!" ),
	( 5, "Germany", "We make good sausage and bad comedians." ),
	( 6, "France", "Lighten up, we surrender already." ),
	( 7, "Italy", "Relax, you're in italia." ),
	( 8, "Czechoslavakia", "If you can spell it, it's all downhill from here." ),
	( 9, "Malta", "So this is where the falcon came from." )
;

INSERT INTO paths ( node1, node2, distance ) VALUES
	( 1, 2, 1 ),
	( 1, 3, 4 ),
	( 1, 4, 3 ),
	( 2, 4, 2 ),
	( 3, 8, 5 ),
	( 4, 5, 2 ),
	( 4, 6, 3 ),
	( 5, 6, 3 ),
	( 5, 7, 5 ),
	( 5, 8, 4 ),
	( 6, 7, 4 ),
	( 7, 8, 4 )
	( 7, 9, 3 )
;
	