<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/16
 * Time:11:35 上午
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
    return getDeep($root) != -1;
}
function getDeep($root)
{
    if ($root == NULL){
        return 0;
    }
    $left = getDeep($root->left);
    if ($left == -1){
        return -1;
    }
    $right = getDeep($root->right);
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

/**
 * 两个二叉树是否完全相同
 * @param $tree1
 * @param $tree2
 * @return bool
 */
function isSameTreeNode($tree1,$tree2){
    if($tree1 == NULL && $tree2 == NULL){
        return true;
    }
    if($tree1 == NULL || $tree2 == NULL){
        return false;
    }
    if($tree1->value != $tree2->value){
        return false;
    }
    $left = isSameTreeNode($tree1->left, $tree2->left);
    $right = isSameTreeNode($tree1->right, $tree2->right);
    return $left && $right;
}

/**
 * 两个二叉树是否互为镜像
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

/**
 * 翻转二叉树
 * @param $root
 * @return null
 */
function rotateTree($root){
    if($root == NULL){
        return NULL;
    }
    //先翻转左子树
    $left = mirrorTreeNode($root -> left);
    //载翻转右子树
    $right = mirrorTreeNode($root -> right);

    //最后左右子树交换位置
    $root->left = $right;
    $root->right = $left;
    return $root;
}