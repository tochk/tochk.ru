<?php

class Data
{
    public function printProject($row)
    {
        if ($row['img_url'] == '') $row['img_url'] = "/design/images/logo.png";
        return "<div id='block_new_sait' onclick=\"window.open('{$row['url']}', '_blank');\">" .
            "<div id='block_in_block_sait'>" .
            "<div id='block_in_block_sait_2'>" .
            "<div id='block_sait_head'>{$row['name']}</div>" .
            "<div id='block_sait_scrin_info'>" .
            "<div class='block_sait_scrin_1'>" .
            "<div class='block_sait_scrin_2' style='background-image: url(\"{$row['img_url']}\")'></div>" .
            "<div class='block_sait_scrin_3'>{$row['comment']}</div>" .
            "</div></div></div></div><div id='block_sait_info'>" .
            "<div id='block_sait_info_2'>" .
            "<div id='sait_date' style='width: 100px'>{$row['time']}</div>" .
            "<div id='sait_data_about_block' style='width: 180px'>" .
            "<div style='width: 80px' id='sait_author'>Author<br><text_green>{$row['author']}</text_green></div>" .
            "<div style='width: 80px' id='sait_cat'>Category<br><text_green>{$row['category']}</text_green></div>" .
            "</div><div id='sait_right_footer'>read more</div>" .
            "</div></div></div>";
    }

    public function printPortfolio($row)
    {
        if ($row['img_url'] == '') $row['img_url'] = "/design/images/logo.png";
        return "<div id='block_new_sait' onclick=\"window.open('{$row['url']}', '_blank');\">" .
            "<div id='block_in_block_sait'>" .
            "<div id='block_in_block_sait_2'>" .
            "<div id='block_sait_head'>{$row['name']}</div>" .
            "<div id='block_sait_scrin_info'>" .
            "<div class='block_sait_scrin_1'>" .
            "<div class='block_sait_scrin_2' style='background-image: url(\"{$row['img_url']}\")'></div>" .
            "<div class='block_sait_scrin_3'>{$row['comment']}</div>" .
            "</div></div></div></div><div id='block_sait_info'>" .
            "<div id='block_sait_info_2'>" .
            "<div id='sait_date' style='width: 100px'>{$row['time']}</div>" .
            "<div id='sait_data_about_block' style='width: 180px'>" .
            "<div style='width: 80px' id='sait_author'>Author<br><text_green>{$row['author']}</text_green></div>" .
            "<div style='width: 80px' id='sait_cat'>Category<br><text_green>{$row['category']}</text_green></div>" .
            "</div><div id='sait_right_footer'>read more</div>" .
            "</div></div></div>";
    }

    public function printPost($connection, $row)
    {
        $postTags = $this->getPostTags($connection, $row['id']);
        $text = "<div id='block_news'>" .
            "<div id='block_in_block_news'>" .
            "<div id='block_in_block_news_2'>" .
            "<div id='block_news_head' style='font-size:20px;'><a href='/blog/show.php?id={$row['id']}'>{$row['theme']}</a></div>" .
            "<div id='block_news_content' style='font-size:16px;'>{$row['short_text']}</div>" .
            "</div></div>" .
            "<div id='block_news_info'>" .
            "<div id='block_news_info_2'>" .
            "<div id='block_date' style='font-size: 20px;'>{$row['time']}</div>" .
            "<div id='block_data'>" .
            "<div id='data_author'> Author<br><text_green>{$row['author']}</text_green></div>" .
            "<div id='data_category'> Tags<br><text_green>$postTags</text_green></div>" .
            "<div id='data_com'> Comments<br><text_green>{$row['comments']}</text_green></div>" .
            "</div>" .
            "<div id='block_info_footer' style='font-size: 20px;'> read more</div>" .
            "</div></div>";
        global $user;
        if ($user->isAdmin == 1)
            $text .= "<div id='block_save' style='font-size: 20px;cursor: pointer' onclick=\"window.location.href = '/blog/edit.php?id={$row['id']}'\"> Edit </div></div>";
        else
            $text .= "</div>";
        return $text;
    }

    public function getPostTags($connection, $postId)
    {
        $postTags = '';
        $query = "SELECT `name` FROM `tags_name` WHERE `id` IN (SELECT `id` FROM `tags` WHERE `post` = '{$postId}')";
        $result = $connection->query($query);
        while ($row = $result->fetch_assoc()) {
            $postTags .= "{$row['name']}<br>";
        }
        return $postTags;
    }
}