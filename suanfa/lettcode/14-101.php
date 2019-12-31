<?php


/**
 * ljb
 */

/**
 * 给定一个二叉树，检查它是否是镜像对称的。
 * 来自 ：力扣 101 题
 * https://leetcode-cn.com/problems/symmetric-tree/
 */

/**
 *
 *二叉树 [1,2,2,3,4,4,3] 是对称的。

     1
    / \
   2   2
  / \ / \
 3  4 4  3
但是下面这个 [1,2,2,null,3,null,3] 则不是镜像对称的:

    1
   / \
  2   2
  \    \
   3    3
    说明:
如果你可以运用递归和迭代两种方法解决这个问题，会很加分。
 */


/**
 * @param $root
 * @return bool
 */
function isSymmetric($root)
{
    if (!$root){
        return true;
    }
    return  dfs($root->left,$root->right);
}

function dfs($left,$right)
{
    if (!$left && !$right){
        return true;
    }
    if (
        (!$left && $right) ||
        ($left && !$right) ||
        ($left->val != $right->val)
    ){
        return false;
    }
    return dfs($left->left,$right->right) && dfs($right->right,$right->left);
}