
drop trigger if exists avantAjoutDossier;

create trigger avantAjoutDossier before insert on dossier
for each row
begin
    set new.nom = concat(upper(left(new.nom, 1)), lower(substring(new.nom, 2)));
    set new.prenom = concat(upper(left(new.prenom, 1)), lower(substring(new.prenom, 2)));
end

