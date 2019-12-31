<?php
// 节点类
class Node {
    public $data;              // 节点数据
    public $previous = NULL;   // 前驱
    public $next = NULL;       // 后继

    public function __construct($data) {
        $this->data = $data;
        $this->previous = NULL;
        $this->next = NULL;
    }
}
// 双链表类
class DoubleLinkedList {
    private $header;    // 头节点

    function __construct($data) {
        $this->header = new Node($data);
    }
    // 查找节点
    public function find($item) {
        $current = $this->header;
        while ($current->data != $item) {
            $current = $current->next;
        }
        return $current;
    }
    // 查找链表最后一个节点
    public function findLast() {
        $current = $this->header;
        while ($current->next != null) {
            $current = $current->next;
        }
        return $current;
    }
    //（在节点后）插入新节点
    public function insert($item, $new) {
        $newNode = new Node($new);
        $current = $this->find($item);
        $newNode->next = $current->next;
        $newNode->previous = $current;
        $current->next = $newNode;
        return true;
    }
    // 从链表中删除一个节点
    public function delete($item) {
        $current = $this->find($item);
        if ($current->next != null) {
            $current->previous->next = $current->next;
            $current->next->previous = $current->previous;
            $current->next = null;
            $current->previous = null;
            return true;
        }
    }
    // 显示链表中的元素
    public function display() {
        $current = $this->header;
        if ($current->next == null) {
            echo "链表为空！";
            return;
        }
        while ($current->next != null) {
            echo $current->next->data . "&nbsp;&nbsp;&nbsp";
            $current = $current->next;
        }
    }
    // 反序显示双向链表中的元素
    public function dispReverse() {
        $current = $this->findLast();
        while ($current->previous != null) {
            echo $current->data . "&nbsp;&nbsp;&nbsp";
            $current = $current->previous;
        }
    }
}

// 测试
$linkedList = new DoubleLinkedList('header');
$linkedList->insert('header', 'China');
$linkedList->insert('China', 'USA');
$linkedList->insert('USA','England');
$linkedList->insert('England','Australia');
echo '链表为：';
$linkedList->display();
echo "</br>";
echo '-----删除节点USA-----';
echo "</br>";
$linkedList->delete('USA');
echo '链表为：';
$linkedList->display();

/**
输出：

链表为：China   USA   England   Australia
-----删除节点USA-----
链表为：China   England   Australia

*/

