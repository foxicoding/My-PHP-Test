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

$a->left = $b;
$a->right = $c;

$b->left = $d;
$b->parent = $a;

$c->left = $e;
$c->right = $f;
$c->parent = $a;

$d->parent = $b;

$e->parent = $c;

$f->parent = $c;


//            A
//         B     C
//      D       E    F


//递归前序遍历 根节点 ---> 左子树 ---> 右子树
function preOrderDiGui($root)
{
    echo $root->data . '    ';
    if ($root->left != NULL){
        preOrderDiGui($root->left);
    }
    if ($root->right != NULL){
        preOrderDiGui($root->right);
    }
}
preOrderDiGui($a);
echo '<br/>';

//非递归（迭代解法）前序遍历 根节点 ---> 左子树 ---> 右子树
function preOrder($root)
{
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
preOrder($a);
echo '<br/>';

//递归中序遍历  左子树 ---> 根节点 ---> 右子树
function midOrderDiGui($root)
{
    if ($root->left != NULL) {
        midOrderDiGui($root->left);
    }

    echo $root->data . '    ';

    if ($root->right != NULL) {
        midOrderDiGui($root->right);
    }
}

midOrderDiGui($a);
echo '<br/>';

//非递归中序遍历，左子树---> 根节点 ---> 右子树
function midOrder($root)
{
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
midOrder($a);
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