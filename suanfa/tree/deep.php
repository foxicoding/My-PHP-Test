<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/15
 * Time:6:32 下午
 */


/**
 * 求二叉树的最大深度
 * @param $root
 * @return int
 */
function getMaxDeep($root)
{
    if ($root == NULL){
        return 0;
    }
    $maxLeft = getMaxDeep($root->left);
    $maxRight = getMaxDeep($root->right);
    echo $maxLeft > $maxRight ? $maxLeft + 1 : $maxRight + 1;
}

/**
 * 求二叉树的最小深度
 * @param $root
 * @return int
 */
function getMinDeep($root)
{
    if ($root == NULL){
        return 0;
    }
    return  min(getMinDeep($root->left),getMinDeep($root->right)) + 1;
}

