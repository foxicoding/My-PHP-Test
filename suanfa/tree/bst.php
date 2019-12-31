<?php


/**
 * author: ljb
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

/**
 * 实现一棵二叉搜索树
 */

class Bst
{
    public $root;


    public function init($arr)
    {
        $count = count($arr);
        for ($i = 0;$i < $count;$i++){
            $this->insert($arr[$i]);
        }
    }

    /**
     * 查找树中是否存在$key对应的节点
     * @param $data
     * @return mixed
     */
    public function search($data)
    {
        $current = $this->root;
        while ($current != NULL){
            if ($current->data == $data){
                return $current->data;
            }
            if ($current->data > $data){
                $current = $current->left;
            }else{
                $current = $current->right;
            }
        }
        return $current;
    }

    /**
     * 插入节点
     * @param $data
     * @throws Exception
     */
    public function insert($data)
    {
        if (!is_null($this->search($data))) {
            throw new Exception('结点' . $data . '已存在，不可插入！');
        }
        $inode = new Node($data);
        $current = $this->root;
        $preNode = NULL;
        //为$inode找到合适的插入位置
        while ($current != NULL) {
            $preNode = $current;
            if ($current->data > $inode->data) {
                $current = $current->left;
            } else {
                $current = $current->right;
            }
        }
        $inode->parent = $preNode;
        //如果$preNode == null， 则证明树是空树
        if ($preNode == NULL) {
            $this->root = $inode;
        } else {
            if ($inode->data < $preNode->data) {
                $preNode->left = $inode;
            } else {
                $preNode->right = $inode;
            }
        }

    }

    /**
     * 删除节点
     * @param $data
     * @throws Exception
     */
    public function delete($data)
    {
        if (is_null($this->search($data))) {
            throw new Exception('结点' . $data . "不存在，删除失败！");
        }
        $dNode = $this->search($data);
        if ($dNode->left == NULL || $dNode->right == NULL) { #如果待删除结点无子节点或只有一个子节点，则c = dnode
            $c = $dNode;
        } else { #如果待删除结点有两个子节点，c置为dnode的直接后继，以待最后将待删除结点的值换为其后继的值
            $c = $this->successor($dNode);
        }

        //无论前面情况如何，到最后c只剩下一边子结点
        if ($c->left != NULL) {
            $s = $c->left;
        } else {
            $s = $c->right;
        }

        if ($s != NULL) { #将c的子节点的父母结点置为c的父母结点，此处c只可能有1个子节点，因为如果c有两个子节点，则c不可能是dnode的直接后继
            $s->parent = $c->parent;
        }

        if ($c->parent == NULL) { #如果c的父母为空，说明c=dnode是根节点，删除根节点后直接将根节点置为根节点的子节点，此处dnode是根节点，且拥有两个子节点，则c是dnode的后继结点，c的父母就不会为空，就不会进入这个if
            $this->root = $s;
        } else if ($c == $c->parent->left) { #如果c是其父节点的左右子节点，则将c父母的左右子节点置为c的左右子节点
            $c->parent->left = $s;
        } else {
            $c->parent->right = $s;
        }
        #如果c!=dnode，说明c是dnode的后继结点，交换c和dnode的key值
        if ($c != $dNode) {
            $dNode->key = $c->key;
        }
    }

    /**
     * 查找树中的最小关键字
     * @param $root
     * @return mixed
     */
    public function searchMin($root)
    {
        $current = $root;
        while($current != NULL){
            $current = $current->left;
        }
        return $current;
    }

    /**
     * 查找树中的最小关键字
     * @param $root
     * @return mixed
     */
    public function searchMax($root)
    {
        $current = $root;
        while($current != NULL){
            $current = $current->right;
        }
        return $current;
    }

    /**
     * 查找某个$key在中序遍历时的直接后继节点
     * @param $x
     * @return mixed
     */
    public function successor($x)
    {
        if ($x->right != NULL) {
            return $this->searchMin($x->right);
        }
        $p = $x->parent;
        while ($p != NULL && $x == $p->right) {
            $x = $p;
            $p = $p->parent;
        }
        return $p;
    }

    public  function getMaxDepth($root)
    {
        if ($root == NULL){
            return 0;
        }
        $maxLeft = $this->getMaxDepth($root->left);
        $maxRight = $this->getMaxDepth($root->right);
        return (($maxLeft > $maxRight) ? $maxLeft : $maxRight) + 1;
    }
}

$arr = [4,1,6,3];
$bst = new Bst();
$bst -> init($arr);

$bst->insert(2);
var_dump($bst->search(1));
var_dump($bst->getMaxDepth($bst->root));
