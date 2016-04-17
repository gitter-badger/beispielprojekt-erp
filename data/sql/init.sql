CREATE TABLE data.material
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    bezeichnung VARCHAR(255),
    preis DOUBLE
);

CREATE TABLE data.bestellung
(
    id INT PRIMARY KEY AUTO_INCREMENT,
    bezeichnung VARCHAR(255),
    material INT,
    anzahl INT,
    status INT,
    zeitErstellt DATETIME,
    zeitGenehmigt DATETIME,
    CONSTRAINT bestellung_material_id_fk FOREIGN KEY (material) REFERENCES data.material (id)
);

INSERT INTO data.material (id, bezeichnung, preis) VALUES (1, 'Gold', 1088.41);
INSERT INTO data.material (id, bezeichnung, preis) VALUES (2, 'Silber', 14.33);
INSERT INTO data.material (id, bezeichnung, preis) VALUES (3, 'Kupfer', 4304.29);

