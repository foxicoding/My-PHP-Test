<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/16
 * Time:11:35 上午
 */


/**
 * /求二叉树的节点个数
 * @param $root
 * @return int
 */
function getNodeNum($root){
    if ($root == NULL){
        return 0;
    }
    $leftNum = getNodeNum($root->left);
    $rightNum = getNodeNum($root->right);
    return $leftNum + $rightNum + 1;
}

/**
 * @param $root
 * @return int
 */
function getLeafNum($root){
    if($root == NULL){
        return 0;
    }
    if($root -> left == NULL && $root -> right == NULL){
        return 1;
    }
    return getLeafNum($root -> left) + getLeafNum($root -> right);
}

/**
 * 求二叉树中第k层节点的个数
 * @param $root
 * @param $k
 * @return int
 */
function getKNodeNum($root,$k){
    if($root == NULL || $k < 1){
        return 0;
    }
    if($k == 1){
        return 1;
    }
    $left = getKNodeNum($root -> left, $k-1);
    $right = getKNodeNum($root -> right, $k-1);
    return $left + $right;
}

/**
 * 判断二叉树是否是平衡二叉树
 * @param $root
 * @return bool
 */
function isBalanced($root)
{
    return getMaxDeep($root) != -1;
}
function getMaxDeep($root)
{
    if ($root == NULL){
        return 0;
    }
    $left = getMaxDeep($root->left);
    if ($left == -1){
        return -1;
    }
    $right = getMaxDeep($root->right);
    if ($right == -1){
        return -1;
    }
    if(abs($left - $right) > 1){
        return -1;
    }
    return $left > $right ? $left + 1 : $right + 1;
}

/**
 * 判断一棵树是否是完全二叉树
 * @param $root
 * @return bool
 */
function isComplete($root){
    if($root == NULL){
        return false;
    }
    $queue = new SplQueue();
    $queue -> push($root);
    $result = true;
    $hasNoChild = false;
    while(!$queue ->isEmpty()){
        $current = $queue->pop();
        if($hasNoChild){
            if($current->left != NULL && $current->right != NULL){
                return false;
                break;
            }
        }  else {
            if($current->left != NULL && $current->right != NULL){
                $queue->push($current->left);
                $queue->push($current->right);
            }elseif ($current->left != NULL && $current->right == NULL) {
                $queue->push($current->left);
                $hasNoChild = true;
            }elseif ($current -> left == NULL && $current -> right != NULL) {
                $result = false;
                break;
            }  else {
                $hasNoChild = true;
            }
        }
    }
    return $result;
}