<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/14
 * Time:12:29 下午
 */

require  './node.php';


//模拟一棵二叉树
$a = new Node('A');
$b = new Node('B');
$c = new Node('C');
$d = new Node('D');
$e = new Node('E');
$f = new Node('F');
$g = new Node('G');

$a->left = $b;
$a->right = $c;

$b->left = $d;
$b->parent = $a;
$b->right = $g;

$c->left = $e;
$c->right = $f;
$c->parent = $a;

$d->parent = $b;

$e->parent = $c;

$f->parent = $c;


//            A
//         B      C
//      D    G  E    F


//递归前序遍历 根节点 ---> 左子树 ---> 右子树
function preOrderDiGui($root)
{
    if (!$root){
        return;
    }
    echo $root->data . '    ';
    if ($root->left != NULL){
        preOrderDiGui($root->left);
    }
    if ($root->right != NULL){
        preOrderDiGui($root->right);
    }
}
preOrderDiGui($a);  // A B D C E F
echo '<br/>';

//非递归（迭代解法）前序遍历 根节点 ---> 左子树 ---> 右子树
function preOrder($root)
{
    if (!$root){
        return;
    }
    $stack = [];
    array_push($stack,$root);
    while(!empty($stack)){
        $currentNode = array_pop($stack);
        echo $currentNode->data . '     '; //先输出根节点
        if ($currentNode->right != NULL){
            array_push($stack,$currentNode->right);  //先压入右子树
        }
        if ($currentNode->left != NULL){
            array_push($stack,$currentNode->left);   //再压入左子树
        }
    }
}
preOrder($a); //A B D C E F
echo '<br/>';

//递归中序遍历  左子树 ---> 根节点 ---> 右子树
function midOrderDiGui($root)
{
    if (!$root){
        return;
    }
    if ($root->left != NULL) {
        midOrderDiGui($root->left);
    }

    echo $root->data . '    ';

    if ($root->right != NULL) {
        midOrderDiGui($root->right);
    }
}

midOrderDiGui($a); // D B A E C F
echo '<br/>';

//非递归中序遍历，左子树---> 根节点 ---> 右子树
function midOrder($root)
{
    if (!$root){
        return;
    }
    $stack = [];
    $centerNode = $root;
    while(!empty($stack) || $centerNode != NULL){
        while($centerNode != NULL){
            array_push($stack, $centerNode);
            $centerNode = $centerNode->left; //将左侧所有的左子树压入数组
        }
        $centerNode = array_pop($stack);
        echo $centerNode->data . ' ';
        $centerNode = $centerNode->right;
    }
}
midOrder($a); // D B A E C F
echo '<br/>';

//递归后序遍历  左子树 ---> 右子树 ---> 根节点
function tailDiGui($root)
{
    if ($root->left != NULL){
        tailDiGui($root->left);
    }
    if ($root->right != NULL){
        tailDiGui($root->right);
    }
    echo $root->data . '    ';
}
tailDiGui($a);
echo '<br/>';

//非递归后序遍历，左子树 ---> 右子树 ---> 根节点
function tailOrder($root){
    $stack = [];
    $outStack = [];
    array_push($stack, $root);
    while(!empty($stack)){
        $centerNode = array_pop($stack);
        array_push($outStack, $centerNode);
        if($centerNode->left != NULL){
            array_push($stack, $centerNode->left);
        }
        if($centerNode->right != NULL){
            array_push($stack, $centerNode->right);
        }
    }
    while(!empty($outStack)){
        $centerNode = array_pop($outStack);
        echo $centerNode -> data . ' ';
    }
}
tailOrder($a);
echo '<br/>';


function cengOrder($root){
    if (!$root){
        return;
    }
    $queue = [];
    array_unshift($queue,$root);
    while (!empty($queue)){
        $currentNode = array_pop($queue);
        echo $currentNode->data .' ';
        if ($currentNode->left != NULL){
            array_unshift($queue,$currentNode->left);
        }
        if ($currentNode->right != NULL){
            array_unshift($queue,$currentNode->right);
        }
    }
}
cengOrder($a);

//求二叉树最大宽度
function getBreathNodeWidth($root){
    if (!$root){
        return 0;
    }
    if ($root->left == NULL && $root->right == NULL){
        return 1;
    }

    $queue = [];
    $lastWidth = 1;//用于记录上一层的宽度。
    $maxWidth = 0;//用户记录二叉树的最大宽度。
    array_unshift($queue,$root);

    while(!empty($queue)){
        while($lastWidth != 0){
            $currentNode = array_pop($queue);
            echo $currentNode->data . ' ';
            if($currentNode->left != NULL){
                array_unshift($queue,$currentNode->left);
            }
            if($currentNode->right != NULL){
                array_unshift($queue,$currentNode->right);
            }
            $lastWidth--;
        }
        $curWidth = count($queue);
        $maxWidth = $curWidth > $maxWidth ? $curWidth : $maxWidth;
        $lastWidth = $curWidth;
    }
    return $maxWidth;
}
var_dump(getBreathNodeWidth($a));
echo '<br/>';