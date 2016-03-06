<?php
function generateSalt()
{
    $salt = '';
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
    $counter = strlen($pattern) - 1;
    for ($i = 0; $i < 3; $i++) {
        $salt .= $pattern{rand(0, $counter)};
    }
    return $salt;
}

function getPostTags($mysql)
{
    $tags = '';
    $query = "SELECT `name` FROM `tags_name`";
    $result = $mysql->query($query);
    while ($row = $result->fetch_assoc()) {
        $tags .= "{$row['name']}, ";
    }
    $tags[strlen($tags) - 2] = ' ';
    return $tags;
}