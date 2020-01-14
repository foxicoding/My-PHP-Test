<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/14
 * Time:12:37 下午
 */

/**
 * 定义一棵二叉树节点
 */
class Node
{
    public $data;
    public $parent;
    public $left;
    public $right;

    public function __construct($data)
    {
        $this->data = $data;
        $this->parent = NULL;
        $this->left = NULL;
        $this->right = NULL;
    }
}
