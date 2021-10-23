create database mist;
-- \c mist;
create extension pgcrypto;

create table "user"
(
    id serial,
    name varchar not null,
    email varchar not null,
    password_hash varchar not null,
    nickname varchar not null,
    birthday date,
    avatar bytea,
    created timestamp default now()
);

create unique index user_id_uindex
    on "user" (id);

alter table "user"
    add constraint user_pk
        primary key (id);

create table game
(
    id serial,
    name varchar not null,
    description varchar not null,
    banner bytea,
    price money not null
);

create unique index game_id_uindex
    on game (id);

alter table game
    add constraint game_pk
        primary key (id);

create table genre
(
    id serial,
    name varchar not null
);

create unique index genre_id_uindex
    on genre (id);

alter table genre
    add constraint genre_pk
        primary key (id);

create table dlc
(
    id serial,
    name varchar not null,
    price money not null,
    game_id int not null
        constraint dlc_game_id_fk
            references game (id)
            on delete cascade
);

create unique index dlc_id_uindex
    on dlc (id);

alter table dlc
    add constraint dlc_pk
        primary key (id);

create table achievement
(
    id serial,
    name varchar not null,
    score int not null,
    game_id int
        constraint achievement_game_id_fk
            references game (id)
            on delete cascade
);

create unique index achievement_id_uindex
    on achievement (id);

alter table achievement
    add constraint achievement_pk
        primary key (id);

create table feed
(
    id serial,
    player_id int not null
        constraint feed_player_id_fk
            references "user" (id)
            on delete cascade,
    poster_id int not null
        constraint feed_poster_id_fk
            references "user" (id)
            on delete cascade,
    content text not null,
    screenshot bytea,
    datetime timestamp default now() not null
);

create unique index feed_id_uindex
    on feed (id);

alter table feed
    add constraint feed_pk
        primary key (id);

create table library
(
    user_id int not null
        constraint library_user_id_fk
            references "user" (id)
            on delete cascade,
    game_id int not null
        constraint library_game_id_fk
            references game (id)
            on delete cascade
);

create table addon
(
    user_id int
        constraint addon_user_id_fk
            references "user"
            on delete cascade,
    dlc_id int
        constraint addon_dlc_id_fk
            references dlc
            on delete cascade
);

create table achieved
(
    user_id int not null
        constraint achieved_user_id_fk
            references "user" (id)
            on delete cascade,
    achievement_id int
        constraint achieved_achievement_id_fk
            references achievement (id)
            on delete cascade,
    datetime timestamp default now() not null
);

create table friends
(
    user_id int not null
        constraint friends_user_id_fk
            references "user"
            on delete cascade,
    friend_id int not null
        constraint friends_user_id_fk_2
            references "user"
            on delete cascade
);

create table game_genre
(
    game_id int not null
        constraint game_genre_game_id_fk
            references game
            on delete cascade,
    genre_id int not null
        constraint game_genre_genre_id_fk
            references genre
            on delete cascade
);

create table log
(
    id serial,
    datetime timestamp default now() not null,
    event varchar not null,
    description jsonb not null
);

create unique index log_id_uindex
    on log (id);

alter table log
    add constraint log_pk
        primary key (id);

CREATE VIEW landing_games AS
SELECT ga.id, ga.name, ga.price, ga.banner, count(*) players, game_genre, coalesce(dlc_total,0) dlcs, coalesce(achievement_total,0) achievements
FROM library l
         LEFT JOIN game ga
                   ON l.game_id = ga.id
         LEFT JOIN (SELECT game_id, count(*) dlc_total
                    FROM dlc
                    GROUP BY game_id) dlcs
                   ON dlcs.game_id = ga.id
         LEFT JOIN (SELECT game_id, count(*) achievement_total
                    FROM achievement
                    GROUP BY game_id) achievements
                   ON achievements.game_id = ga.id
         LEFT JOIN (SELECT ga.id, string_agg(ge.name::text, ', ') game_genre FROM game_genre gg
                                                                                      LEFT JOIN game ga ON gg.game_id = ga.id
                                                                                      LEFT JOIN genre ge ON gg.genre_id = ge.id
                    GROUP BY ga.id) genres
                   ON genres.id = ga.id
GROUP BY ga.id, ga.name, ga.price, ga.banner, game_genre, dlc_total, achievements
ORDER BY players DESC;

CREATE VIEW landing_players AS
SELECT u.id, u.nickname, u.birthday, u.avatar, coalesce(achievement_total,0) achievements, coalesce(game_total,0) games
FROM "user" u
         LEFT JOIN (SELECT user_id, count(*) achievement_total
                    FROM achieved
                    GROUP BY user_id) achievements
                   ON u.id = achievements.user_id
         LEFT JOIN (SELECT user_id, count(*) game_total
                    FROM library l
                    GROUP BY user_id) games
                   ON u.id = games.user_id
ORDER BY u.created DESC;

CREATE PROCEDURE toggle_friends(player_id INT, new_friend_id INT)
AS $$
DECLARE
    already_friend INT;
BEGIN
    SELECT 1
    INTO already_friend
    FROM friends
    WHERE user_id = player_id AND friend_id = new_friend_id;

    IF (already_friend > 0) THEN
        DELETE FROM friends WHERE user_id = player_id AND friend_id = new_friend_id;
    ELSE
        INSERT INTO friends(user_id, friend_id) VALUES(player_id, new_friend_id);
    END IF;
END;
$$
    LANGUAGE plpgsql;

CREATE FUNCTION check_player_has_dlc_game()
    RETURNS "pg_catalog"."trigger"
AS $$
DECLARE
    old_game_id INT;
    player_has_game INT;
BEGIN
    SELECT game_id
    INTO old_game_id
    FROM dlc d
    WHERE d.id = NEW.dlc_id;

    SELECT 1
    INTO player_has_game
    FROM library l
    WHERE l.user_id = NEW.user_id AND l.game_id = old_game_id;

    IF (player_has_game IS NULL) THEN
        RAISE EXCEPTION 'Player does not own that game.';
    END IF;
    RETURN NEW;
END;
$$
    LANGUAGE plpgsql;

CREATE TRIGGER check_player_has_game_on_purchase
    BEFORE INSERT ON addon
    FOR EACH ROW EXECUTE PROCEDURE check_player_has_dlc_game();

CREATE FUNCTION check_player_has_achievement_game()
    RETURNS "pg_catalog"."trigger"
AS $$
DECLARE
    old_game_id INT;
    player_has_game INT;
BEGIN
    SELECT game_id
    INTO old_game_id
    FROM achievement a
    WHERE a.id = NEW.achievement_id;

    SELECT 1
    INTO player_has_game
    FROM library l
    WHERE l.user_id = NEW.user_id AND l.game_id = old_game_id;

    IF (player_has_game IS NULL) THEN
        RAISE EXCEPTION 'Player does not own that game.';
    END IF;
    RETURN NEW;
END;
$$
    LANGUAGE plpgsql;

CREATE TRIGGER check_player_has_game_on_purchase
    BEFORE INSERT ON achieved
    FOR EACH ROW EXECUTE PROCEDURE check_player_has_achievement_game();
