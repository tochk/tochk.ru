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