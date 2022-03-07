CREATE DATABASE pagination_mock;

USE pagination_mock;

CREATE TABLE page_mock
(
    cote varchar(6) NOT NULL PRIMARY KEY,
    titre varchar(255),
    categorie varchar(255),
    auteur varchar(255)
);

insert into page_mock values ('BD001',  'Les naufrages d Ythaq', 'BD', 'FLOCH Adrien');
insert into page_mock values ('BD002',  'Death Note', 'BD', 'TSUGUMI Ohba');
insert into page_mock values ('BD003',  'Le Secret Du Courage', 'BD', 'STILTON Geronimo');
insert into page_mock values ('BD004',  'Molly Moon','BD','BYNG Georgia'); 
insert into page_mock values ('DIV001', 'Former par les contes', 'DIVERS', 'COSTE Philippe');
insert into page_mock values ('DIV002', 'La masse salariale', 'DIVERS', 'TAIEB Jean-Pierre');
insert into page_mock values ('INFOR1', 'Interactions homme-machine', 'INFORMATIQUE', 'KOLSKI Christophe');
insert into page_mock values ('INFOR2', 'Filtrage d informations', 'INFORMATIQUE','MINEL Jean-Luc');
insert into page_mock values ('INFOR3', 'L intelligence en essaim', 'INFORMATIQUE', 'MONMARCHÉ Nicolas');
insert into page_mock values ('MATH01', 'Eléments de mathématique', 'SCIENCE-MATHS', 'BOUR Baki');
insert into page_mock values ('MATH02', 'Morphologie mathématique',	'SCIENCE-MATHS', 'NAJMAN Laurent');
insert into page_mock values ('MATH03', 'Analyse mathématique', 'SCIENCE-MATHS', 'CHOIMET Denis');
insert into page_mock values ('MATH04', 'Programmation mathématique', 'SCIENCE-MATHS', 'MINOUX Michel');
insert into page_mock values ('POL001', 'Péché Originel','POLICIER','PHYLLIS Dorothy James');
insert into page_mock values ('POL002', 'Mort d Un Expert', 'POLICIER', 'PHYLLIS Dorothy James');
insert into page_mock values ('POL003', 'Ne ferme pas les yeux', 'POLICIER', 'THOMPSON Carlene');
insert into page_mock values ('POL004', 'Une patience d ange', 'POLICIER', 'GEORGE Elizabeth');
insert into page_mock values ('POL005', 'Traquées', 'POLICIER', 'GRENIER Christian');
insert into page_mock values ('POL006', 'The Moonstone', 'POLICIER', 'COLLINS Wilkie');
insert into page_mock values ('POL007', 'Coup de théatre', 'POLICIER', 'GRENIER Christian');

insert into page_mock values ('BD005',  'Les naufrages d Ythaq 2', 'BD', 'FLOCH Adrien');
insert into page_mock values ('BD006',  'Death Note 2', 'BD', 'TSUGUMI Ohba');
insert into page_mock values ('BD007',  'Le Secret Du Courage 2', 'BD', 'STILTON Geronimo');
insert into page_mock values ('BD008',  'Molly Moon 2','BD','BYNG Georgia'); 
insert into page_mock values ('DIV003', 'Former par les contes 2', 'DIVERS', 'COSTE Philippe');
insert into page_mock values ('DIV004', 'La masse salariale 2', 'DIVERS', 'TAIEB Jean-Pierre');
insert into page_mock values ('INFOR4', 'Interactions homme-machine 2', 'INFORMATIQUE', 'KOLSKI Christophe');
insert into page_mock values ('INFOR5', 'Filtrage d informations 2', 'INFORMATIQUE','MINEL Jean-Luc');
insert into page_mock values ('INFOR6', 'L intelligence en essaim 2', 'INFORMATIQUE', 'MONMARCHÉ Nicolas');
insert into page_mock values ('MATH05', 'Eléments de mathématique 2', 'SCIENCE-MATHS', 'BOUR Baki');
insert into page_mock values ('MATH06', 'Morphologie mathématique 2',	'SCIENCE-MATHS', 'NAJMAN Laurent');
insert into page_mock values ('MATH07', 'Analyse mathématique 2', 'SCIENCE-MATHS', 'CHOIMET Denis');
insert into page_mock values ('MATH08', 'Programmation mathématique 2', 'SCIENCE-MATHS', 'MINOUX Michel');
insert into page_mock values ('POL008', 'Péché Originel 2','POLICIER','PHYLLIS Dorothy James');
insert into page_mock values ('POL009', 'Mort d Un Expert 2', 'POLICIER', 'PHYLLIS Dorothy James');
insert into page_mock values ('POL010', 'Ne ferme pas les yeux 2', 'POLICIER', 'THOMPSON Carlene');
insert into page_mock values ('POL011', 'Une patience d ange 2', 'POLICIER', 'GEORGE Elizabeth');
insert into page_mock values ('POL012', 'Traquées 2', 'POLICIER', 'GRENIER Christian');
insert into page_mock values ('POL013', 'The Moonstone 2', 'POLICIER', 'COLLINS Wilkie');
insert into page_mock values ('POL014', 'Coup de théatre 2', 'POLICIER', 'GRENIER Christian');

