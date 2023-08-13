<?php

namespace app\common;

abstract class Lottery
{
    // 获取最后彩期
    abstract public function get_last_no();

    // 获取当前彩期
    abstract public function get_current_no();

    // 开奖
    abstract public function draw();

    // 新开奖版本
    abstract public function drawV2();

    abstract public function setData($data);
}