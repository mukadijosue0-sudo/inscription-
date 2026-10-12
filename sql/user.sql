drop user if exists inscription@localhost;

create user inscription@localhost identified by 'Nkb&"7.$js]kjCk]NTRD';

-- Lecture des dossiers, de leur état et des pièces disponibles/manquantes
grant select on inscription.dossier to inscription@localhost;
grant select on inscription.etat to inscription@localhost;
grant select on inscription.piece to inscription@localhost;
grant select on inscription.piece_manquante to inscription@localhost;

-- Mise à jour des états et de la date de relance
grant update (id_etat, date_relance) on inscription.dossier to inscription@localhost;

-- Gestion des pièces manquantes
grant insert, delete on inscription.piece_manquante to inscription@localhost;

-- Fonction utilisée pour afficher les dates en français
grant execute on function inscription.dateFormatLong to inscription@localhost;

flush privileges;