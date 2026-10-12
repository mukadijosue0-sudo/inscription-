use inscription;

drop function if exists dateFormatLong;

create function dateFormatLong(_date DATE)
    returns varchar(255)
    deterministic
begin
    DECLARE formatted_date VARCHAR(255);
    SET formatted_date = CONCAT(
            ELT(WEEKDAY(_date) + 1, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'),
            ' ',
            if (DAY(_date)  = 1, '1er', DAY(_date)),
            ' ',
            ELT(MONTH(_date), 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'),
            ' ',
            YEAR(_date)
                         );
    RETURN formatted_date;
end;

select dateFormatLong('2025-09-01') as date_format_long;
