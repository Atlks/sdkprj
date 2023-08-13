<?php



  function createTrendImage($records)
{
    // 数据
    $data = ["turn" => '回合', "result" => "结果", "sum" => "特码", "zuhe" => "双面", "limit" => "极值", "kind" => "形态"];
    $row_x = ["turn" => '1234567', "result" => "a+b+c=", "sum" => "bb", "zuhe" => "组 合", "limit" => "极值", "kind" => "形态"];
    // TODO::字体路径
    $font = app()->getRootPath() . "public/msyhbd.ttc";
    $font_number = app()->getRootPath() . "public/simfang.ttf";
    //echo $font;
    $font_title_size = 22;
    $font_size = 20;
    $font_nubmer_size = 16;
    // 标题长度
    //$this_title_box = imagettfbbox($font_size, 0, $font, $title);
    //$title_x_len = $this_title_box[2] - $this_title_box[0];
    $title_height = 44;

    // 每行高度
    $row_hight = $title_height - 10;
    $pre_title_w = [];
    foreach ($data as $key => $value) {
        if (count($pre_title_w) == 0)
            $this_box = imagettfbbox($font_nubmer_size, 0, $font_number, $value);
        else
            $this_box = imagettfbbox($font_size, 0, $font, $value);
        $pre_title_w[$key] = $this_box[2] - $this_box[0];
    }


    $text_x_len = 0;
    $pre_col_w = [];
    $pre_col_x = [];
    foreach ($row_x as $key => $value) {
        if (count($pre_col_w) == 0)
            $this_box = imagettfbbox($font_nubmer_size, 0, $font_number, $value);
        else
            $this_box = imagettfbbox($font_size, 0, $font, $value);
        $pre_col_w[$key] = $this_box[2] - $this_box[0];
        $text_x_len += $pre_col_w[$key];
    }

    // 列数
    $column = 6;

    // 文本左右内边距
    $x_padding = 10;
    $y_padding = 10;
    // 图片宽度（每列宽度 + 每列左右内边距）
    $img_width = ($text_x_len) + $column * $x_padding * 2;
    // 图片高度（标题高度 + 每行高度 + 每行内边距）
    $img_height = $title_height + count($records) * ($row_hight + $y_padding);

    # 开始画图
    // 创建画布
    $img = imagecreatetruecolor($img_width, $img_height);

    # 创建画笔
    // 背景颜色（蓝色）
    $bg_color = imagecolorallocate($img, 255, 255, 255);
    // 表面颜色（浅灰）
    $surface_color = imagecolorallocate($img, 235, 242, 255);
    // 标题字体颜色 MidnightBlue
    $title_color = imagecolorallocate($img, 25, 25, 112);
    // 标题字体颜色 (白色)
    $title_font = imagecolorallocate($img, 255, 255, 255);
    // 内容字体颜色（灰色）
    $text_color = imagecolorallocate($img, 0, 0, 0);

    // 大双为红色
    $big_2_color = imagecolorallocate($img, 165, 42, 42);
    // 小单为青色
    $small_1_color = imagecolorallocate($img, 100, 149, 237);
    // 无的颜色
    $null_color = imagecolorallocate($img, 125, 125, 125);
    // 杂六颜色
    $six_color = imagecolorallocate($img, 34, 139, 34);
    // 对子
    $pair_color = imagecolorallocate($img, 238, 173, 14);
    // 顺子
    $_color = imagecolorallocate($img, 148, 0, 211);
    // 豹子
    $all_color = imagecolorallocate($img, 165, 42, 42);
    $box = imagettfbbox($font_size, 0, $font, "小");
    $big_small_with = $box[2] - $box[0];

    $cell_color = imagecolorallocate($img, 245, 245, 245);
    $col_color = imagecolorallocate($img, 238, 233, 233);

    $ell_color = imagecolorallocate($img, 135, 206, 255);


    // 画矩形 （先填充一个大背景，小一点的矩形形成外边框）
    imagefill($img, 0, 0, $bg_color);
    imagefilledrectangle($img, 0, 0, $img_width, $title_height, $title_color);
    //imagefilledrectangle($img, 2, $title_height, $img_width - 3, $img_height - 3, $surface_color);

    $x = 0;
    $title_x = 0;
    foreach ($pre_col_w as $k => $col_x) {
        $x += $x_padding * 2;
        $x += $col_x;
        imageline($img, $x, $title_height, $x, $img_height, $bg_color);
        $pre_col_x[$k] = $x;
        //写入首行 
        imagettftext($img, $font_title_size, 0, $title_x + intval(($col_x + $x_padding * 2 - $pre_title_w[$k]) / 2), intval($title_height - $font_title_size / 2), $title_font, $font, $data[$k]);
        $title_x += $col_x + $x_padding * 2;
    }



    // 写入表格
    $temp_height = $title_height;
    $filed = true;
    foreach ($records as $key => $record) {
        # code...
        $next_x = 0;
        $temp_height += $row_hight + $y_padding;
        // 画线
        imageline($img, 0, $temp_height, $img_width, $temp_height, $bg_color);
        if ($filed) {
            imagefilledrectangle($img, 0, $temp_height, $img_width, $temp_height + $row_hight + $y_padding, $cell_color);
        }

        $filed = !$filed;

        $x = 0;
        $title_x = 0;
        foreach ($record as $k => $value) {
            echo $value . "<br>";
            $col_x = $pre_col_w[$k];
            $x += $x_padding * 2;
            $x += $col_x;
            if ($k == 'zuhe' || $k == 'kind') {
                imagefilledrectangle($img, $x - $col_x - $x_padding * 2, $temp_height - $row_hight - $y_padding + 1, $x, $temp_height, $col_color);
            }
            $title_x += $col_x + $x_padding * 2;
            if ($k == 'zuhe') {
                $strarr =  preg_split('/(?<!^)(?!$)/u', $value);
                $color1 = $color2 = 0;
                if ($strarr[0] == "小") {
                    $color1 = $small_1_color;
                } else {
                    $color1 = $big_2_color;
                }

                if ($strarr[2] == "单") {
                    $color2 = $small_1_color;
                } else {
                    $color2 = $big_2_color;
                }
                imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color1, $font, $strarr[0]);
                $box = imagettfbbox($font_size, 0, $font, $strarr[1]);
                $_with = $box[2] - $box[0];
                imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $big_small_with + $_with, $temp_height - $font_size / 2, $color2, $font, $strarr[2]);
            } elseif ($k == 'limit') {
                if ($value == "极小") {
                    $color = $big_2_color;
                } elseif ($value == "极大") {
                    $color = $big_2_color;
                } else
                    $color = $null_color;

                imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color, $font, $value);
            } elseif ($k == "kind") {
                if ($value == "对子") {
                    $color = $pair_color;
                } elseif ($value == "顺子") {
                    $color = $_color;
                } elseif ($value == "豹子") {
                    $color = $all_color;
                } else
                    $color = $six_color;

                imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $color, $font, $value);
            } else {
                if ($k == 'turn')
                    imagettftext($img, $font_nubmer_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $text_color, $font_number, $value);
                elseif ($k == 'result') {
                    $strarr =  preg_split('/(?<!^)(?!$)/u', $value);

                    $temp_x = 13;
                    $thick = 3;
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 1 - $font_size / 2 - $temp_x - 2, $temp_height - $font_size / 2, $text_color, $font, $strarr[0]); //a
                    imagettftext($img, $font_nubmer_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 2 - $font_size / 2 - $temp_x + 2, $temp_height - $font_size / 2, $text_color, $font, $strarr[1]); //+
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 3 - $font_size / 2 - $temp_x + 4, $temp_height - $font_size / 2, $text_color, $font, $strarr[2]); //b
                    imagettftext($img, $font_nubmer_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 4 - $font_size / 2 - $temp_x + 8, $temp_height - $font_size / 2, $text_color, $font, $strarr[3]); //+
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 5 - $font_size / 2 - $temp_x + 10, $temp_height - $font_size / 2, $text_color, $font, $strarr[4]); //c
                    imagettftext($img, $font_nubmer_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 6 - $font_size / 2 - $temp_x + 14, $temp_height - $font_size / 2, $text_color, $font, $strarr[5]); //=
                    $this->draw_oval($img, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size - $temp_x - 4, $temp_height - $font_size, $font_size + $temp_x, $font_size + $temp_x, $ell_color, $thick);
                    $this->draw_oval($img, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 3 - $temp_x + 2, $temp_height - $font_size, $font_size + $temp_x, $font_size + $temp_x, $ell_color, $thick);
                    $this->draw_oval($img, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding) + $font_size * 5 - $temp_x + 8, $temp_height - $font_size, $font_size + $temp_x, $font_size + $temp_x, $ell_color, $thick);
                } else
                    imagettftext($img, $font_size, 0, intval($pre_col_x[$k] - $pre_col_w[$k] - $x_padding), $temp_height - $font_size / 2, $text_color, $font, $value);
            }
        }
    }
    imagepng($img, app()->getRootPath() . "public/trend.jpg");
}

function draw_oval($image, $pos_x, $pos_y, $elipse_width, $elipse_height, $color, $px_thick)
{

    imagefilledellipse($image, $pos_x, $pos_y, $elipse_width, $elipse_height, $color);
    return;

    $line = 0;

    $thickness = $px_thick;

    $elipse_w = $elipse_width;

    $elipse_h = $elipse_height;

    while ($line < $thickness) {

        imageellipse($image, $pos_x, $pos_y, $elipse_w, $elipse_h, $color);

        $line++;

        $elipse_w--;

        $elipse_h--;
    }
}