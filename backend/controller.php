<?php

// Session for logged in users
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

function isLoggedIn(): bool
{
    return isset($_SESSION['auth_login']);
}

function setupSession($res): bool
{
    $_SESSION['auth_id'] = $res[0]['id'];
    $_SESSION['auth_login'] = $res[0]['name'];
    $_SESSION['auth_email'] = $res[0]['email'];
    $_SESSION['auth_birthday'] = $res[0]['birthday'];
    $_SESSION['auth_nickname'] = $res[0]['nickname'];
    $_SESSION['auth_avatar'] = stream_get_contents($res[0]['avatar']);
    return true;
}

// PDO - DB Layer
function getDb(): PDO
{
    $config = json_decode(file_get_contents(dirname(__DIR__).'/config/db.json'),true);
    $host   = $config['host'];
    $port   = $config['port'];
    $dbname = $config['dbname'];
    $user   = $config['user'];
    $pass   = $config['password'];

    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
        return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function query($sql, $params = []): array
{
    $bd = getDb();
    $res = $bd->prepare($sql);
    foreach ($params AS $key => $value)
    {
        $type = $value[1]?:PDO::PARAM_STR;
        $res->bindParam($key, $value[0], $type);
    }
    $res->execute();
    return $res->fetchAll(PDO::FETCH_ASSOC);
}

/* QUERIES */

// SELECTS //

function gameCount()
{
    $sql = 'SELECT count(*) total FROM game;';
    return query($sql)[0]['total'];
}

function dlcCount()
{
    $sql = 'SELECT count(*) total FROM dlc;';
    return query($sql)[0]['total'];
}

function achievementCount()
{
    $sql = 'SELECT count(*) total FROM achievement;';
    return query($sql)[0]['total'];
}

function playerCount()
{
    $sql = 'SELECT count(*) total FROM "user";';
    return query($sql)[0]['total'];
}

function landingGames(): array
{
    $sql = 'SELECT *, count(*) OVER() AS full_count FROM landing_games LIMIT 5;';
    return query($sql);
}

function landingPlayers(): array
{
    $sql = 'SELECT *, count(*) OVER() AS full_count FROM landing_players LIMIT 5;';
    return query($sql);
}

function genreList(): array
{
    $sql = 'SELECT * FROM genre;';
    return query($sql);
}

function gameGenreList($id): array
{
    $sql = 'SELECT * FROM game_genre gg 
            LEFT JOIN genre g ON gg.genre_id = g.id 
            WHERE gg.game_id = :game_id;';
    return query($sql, [":game_id" => [$id, PDO::PARAM_INT]]);
}

function inverseGameGenreList($id): array
{
    $sql = 'SELECT * FROM genre 
            WHERE id NOT IN (SELECT genre_id FROM game_genre WHERE game_id = :game_id);';
    return query($sql, [":game_id" => [$id, PDO::PARAM_INT]]);
}


function gameList($search = '*'): array
{
    $sql = 'SELECT ga.id, ga.name, ga.price, ga.banner, game_genre, coalesce(dlc_total,0) dlcs, coalesce(achievement_total,0) achievements
            FROM game ga
                     LEFT JOIN (SELECT game_id, count(*) dlc_total
                                FROM dlc
                                GROUP BY game_id) dlcs
                               ON dlcs.game_id = ga.id
                     LEFT JOIN (SELECT game_id, count(*) achievement_total
                                FROM achievement
                                GROUP BY game_id) achievements
                               ON achievements.game_id = ga.id
                     LEFT JOIN (SELECT ga.id, string_agg(ge.name::text, \', \') game_genre FROM game_genre gg
                                 LEFT JOIN game ga ON gg.game_id = ga.id
                                 LEFT JOIN genre ge ON gg.genre_id = ge.id
                                 GROUP BY ga.id) genres
                               ON genres.id = ga.id
            WHERE ga.name ilike :search
            ORDER BY ga.name;';
    return query($sql, [":search" => ['%'.$search.'%']]);
}

function playerList($search = '*'): array
{
    $sql = 'SELECT u.id, u.nickname, u.birthday, u.avatar, coalesce(achievement_total,0) achievements, coalesce(game_total,0) games
            FROM "user" u
                LEFT JOIN (SELECT user_id, count(*) achievement_total
                            FROM achieved
                            GROUP BY user_id) achievements
                    ON u.id = achievements.user_id
                LEFT JOIN (SELECT user_id, count(*) game_total
                           FROM library l
                           GROUP BY user_id) games
                    ON u.id = games.user_id
            WHERE u.nickname ilike :search
            ORDER BY u.created DESC;';
    return query($sql, [":search" => ['%'.$search.'%']]);
}

function friends(): array
{
    $sql = 'SELECT f.friend_id, nickname, avatar FROM friends f LEFT JOIN "user" u ON f.friend_id = u.id WHERE f.user_id = :id;';
    return query($sql, [":id" => [$_SESSION['auth_id'], PDO::PARAM_INT]]);
}

function loginUser($name, $password): bool
{
    $sql = 'SELECT id, name, nickname, birthday, email, avatar FROM "user" WHERE name = :name AND password_hash = crypt(:password, password_hash);';
    $res = query($sql, [":name" => [$name], ":password" => [$password]]);
    if($res)
        return setupSession($res);
    else
        return false;
}

function isFriend($friend_id): bool
{
    $sql = 'SELECT friend_id FROM friends WHERE user_id = :user_id AND friend_id = :friend_id;';
    $res = query($sql, [":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT], ":friend_id" => [$friend_id, PDO::PARAM_INT]])[0]['friend_id'];
    return isset($res);
}

function getPlayerInfo($id): array
{
    $sql = 'SELECT * FROM "user" WHERE id = :id;';
    return query($sql, [":id" => [$id, PDO::PARAM_INT]])[0];
}

function getFeed($id): array
{
    $sql = 'SELECT f.*, u.nickname, u.avatar 
            FROM feed f
            LEFT JOIN "user" u
                ON f.poster_id = u.id
            WHERE f.player_id = :id;';
    return query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

function getGameInfo($id): array
{
    $sql = 'SELECT * FROM game WHERE id = :id;';
    return query($sql, [":id" => [$id, PDO::PARAM_INT]])[0];
}

function getGameDlc($id): array
{
    $sql = 'SELECT id, name, price FROM dlc WHERE game_id = :id;';
    return query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

function getGameAchievement($id): array
{
    $sql = 'SELECT id, name, score FROM achievement WHERE game_id = :id;';
    return query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

function ownsGame($id): bool
{
    $sql = 'SELECT game_id FROM library WHERE game_id = :game_id AND user_id = :user_id;';
    $res = query($sql, [":game_id" => [$id, PDO::PARAM_INT],":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT]])[0]['game_id'];
    return isset($res);
}

function ownsDlc($id): bool
{
    $sql = 'SELECT dlc_id FROM addon WHERE dlc_id = :dlc_id AND user_id = :user_id;';
    $res = query($sql, [":dlc_id" => [$id, PDO::PARAM_INT],":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT]])[0]['dlc_id'];
    return isset($res);
}

function ownsAchievement($id): bool
{
    $sql = 'SELECT achievement_id FROM achieved WHERE achievement_id = :achievement_id AND user_id = :user_id;';
    $res = query($sql, [":achievement_id" => [$id, PDO::PARAM_INT],":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT]])[0]['achievement_id'];
    return isset($res);
}

function getPlayerLibrary($id): array
{
    $sql = 'SELECT ga.* FROM library l LEFT JOIN game ga ON l.game_id = ga.id WHERE l.user_id = :user_id;';
    return query($sql, [":user_id" => [$id, PDO::PARAM_INT]]);
}

function getPlayerDlcs($id): array
{
    $sql = 'SELECT d.* FROM addon a LEFT JOIN dlc d ON a.dlc_id = d.id WHERE a.user_id = :user_id;';
    return query($sql, [":user_id" => [$id, PDO::PARAM_INT]]);
}

function getPlayerAchievements($id): array
{
    $sql = 'SELECT a2.* FROM achieved a1 LEFT JOIN achievement a2 ON a1.achievement_id = a2.id WHERE a1.user_id = :user_id;';
    return query($sql, [":user_id" => [$id, PDO::PARAM_INT]]);
}

// INSERTS //

function addGenre($name)
{
    $sql = 'INSERT INTO genre (name) VALUES (:name);';
    query($sql, [":name" => [$name]]);
}

function registerUser($name, $nickname, $password, $email)
{
    $sql = 'INSERT INTO "user" (name, password_hash, nickname, email) VALUES (:name, crypt(:password_hash, gen_salt(\'bf\', 8)), :nickname, :email);';
    query($sql, [":name" => [$name],":password_hash" => [$password],":nickname" => [$nickname],":email" => [$email]]);
}

function registerGame($name, $description, $price, $banner)
{
    $sql = 'INSERT INTO game (name, description, price, banner) VALUES (:name, :description, :price, :banner);';
    query($sql, [":name" => [$name],":description" => [$description],":price" => [$price],":banner" => [$banner, PDO::PARAM_LOB]]);
}

function post($player, $content, $screenshot = null)
{
    $param_type = $screenshot?PDO::PARAM_LOB:PDO::PARAM_STR;
    $sql = 'INSERT INTO feed (player_id, poster_id, content, screenshot) VALUES (:player_id, :poster_id, :content, :screenshot);';
    query($sql, [":player_id" => [$player, PDO::PARAM_INT], ":poster_id" => [$_SESSION['auth_id'], PDO::PARAM_INT], ":content" => [$content], ":screenshot" => [$screenshot, $param_type]]);
}

function buyGame($id)
{
    $sql = 'INSERT INTO library (user_id, game_id) VALUES (:user_id, :game_id);';
    query($sql, [":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT],":game_id" => [$id, PDO::PARAM_INT]]);
}

function buyDlc($id)
{
    $sql = 'INSERT INTO addon (user_id, dlc_id) VALUES (:user_id, :dlc_id);';
    query($sql, [":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT],":dlc_id" => [$id, PDO::PARAM_INT]]);
}

function getAchievement($id)
{
    $sql = 'INSERT INTO achieved (user_id, achievement_id) VALUES (:user_id, :achievement_id);';
    query($sql, [":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT],":achievement_id" => [$id, PDO::PARAM_INT]]);
}

function includeGenre($game_id, $genre_id)
{
    $sql = 'INSERT INTO game_genre (game_id, genre_id) VALUES (:game_id, :genre_id);';
    query($sql, [":game_id" => [$game_id, PDO::PARAM_INT], ":genre_id" => [$genre_id, PDO::PARAM_INT]]);
}

function includeDlc($id, $name, $price)
{
    $sql = 'INSERT INTO dlc (game_id, name, price) VALUES (:game_id, :name, :price);';
    query($sql, [":game_id" => [$id, PDO::PARAM_INT], ":name" => [$name], ":price" => [$price]]);
}

function includeAchievement($id, $name, $score)
{
    $sql = 'INSERT INTO achievement (game_id, name, score) VALUES (:game_id, :name, :score);';
    query($sql, [":game_id" => [$id, PDO::PARAM_INT], ":name" => [$name], ":score" => [$score]]);
}

// UPDATES //

function editGenre($id, $name)
{
    $sql = 'UPDATE genre SET name = :name WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT], ":name" => [$name]]);
}

function updateGame($id, $name, $description, $price, $banner)
{
    $sql = 'UPDATE game SET name = :name, description = :description, price = :price, banner = :banner WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT], ":name" => [$name],":description" => [$description],":price" => [$price],":banner" => [$banner, PDO::PARAM_LOB]]);
}

function updateUser($nickname, $email, $birthday)
{
    $sql = 'UPDATE "user" SET nickname = :nickname, email = :email, birthday = :birthday WHERE id = :id;';
    query($sql, [":nickname" => [$nickname], ":email" => [$email], ":birthday" => [$birthday], ":id" => [$_SESSION['auth_id'], PDO::PARAM_INT]]);
}

function updateAvatar($avatar)
{
    $sql = 'UPDATE "user" SET avatar = :avatar WHERE id = :id;';
    query($sql, [":avatar" => [$avatar, PDO::PARAM_LOB], ":id" => [$_SESSION['auth_id'], PDO::PARAM_INT]]);
}

function deleteAvatar()
{
    $sql = 'UPDATE "user" SET avatar = null WHERE id = :id;';
    query($sql, [":id" => [$_SESSION['auth_id'], PDO::PARAM_INT]]);
}

function editDlc($id, $name, $price)
{
    $sql = 'UPDATE dlc SET name = :name, price = :price WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT], ":name" => [$name], ":price" => [$price]]);
}

function editAchievement($id, $name, $score)
{
    $sql = 'UPDATE achievement SET name = :name, score = :score WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT], ":name" => [$name], ":score" => [$score]]);
}

// DELETES //

function deleteGenre($id)
{
    $sql = 'DELETE FROM genre WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

function deleteGame($id)
{
    $sql = 'DELETE FROM game WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

function deleteUser()
{
    $sql = 'DELETE FROM "user" WHERE id = :id;';
    query($sql, [":id" => [$_SESSION['auth_id'], PDO::PARAM_INT]]);
}

function deletePost($post)
{
    $sql = 'DELETE FROM feed WHERE id = :id;';
    query($sql, [":id" => [$post, PDO::PARAM_INT]]);
}

function removeGenre($game_id, $genre_id)
{
    $sql = 'DELETE FROM game_genre WHERE game_id = :game_id AND genre_id = :genre_id;';
    query($sql, [":game_id" => [$game_id, PDO::PARAM_INT], ":genre_id" => [$genre_id, PDO::PARAM_INT]]);
}

function removeDlc($id)
{
    $sql = 'DELETE FROM dlc WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

function removeAchievement($id)
{
    $sql = 'DELETE FROM achievement WHERE id = :id;';
    query($sql, [":id" => [$id, PDO::PARAM_INT]]);
}

// PROCEDURE CALLS //

function toggleFriend($friend_id)
{
    $sql = 'CALL toggle_friends(:user_id,:friend_id);';
    query($sql, [":user_id" => [$_SESSION['auth_id'], PDO::PARAM_INT], ":friend_id" => [$friend_id, PDO::PARAM_INT]]);
}
