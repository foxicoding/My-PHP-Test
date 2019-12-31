<?php
// 节点类
class Node {
    public $data;   // 节点数据
    public $next;   // 下一节点

    public function __construct($data) {
        $this->data = $data;
        $this->next = NULL;
    }
}
// 单链表类
class SingleLinkedList {
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
    // （在节点后）插入新节点
    public function insert($item, $new) {
        $newNode = new Node($new);
        $current = $this->find($item);
        $newNode->next = $current->next;
        $current->next = $newNode;
        return true;
    }

    // 更新节点
    public function update($old, $new) {
//        $current = $this->header;
//        if ($current->next == null) {
//            echo "链表为空！";
//            return;
//        }
//        while ($current->next != null) {
//            if ($current->data == $old) {
//                break;
//            }
//            $current = $current->next;
//        }
//        return $current->data = $new;
        $current = $this->find($old);
        if ($current->next == null){
            echo '链表为空';
            return;
        }
        $current->data = $new;
    }

    // 查找待删除节点的前一个节点
    public function findPrevious($item) {
        $current = $this->header;
        while ($current->next != null && $current->next->data != $item) {
            $current = $current->next;
        }
        return $current;
    }

    // 从链表中删除一个节点
    public function delete($item) {
        $previous = $this->findPrevious($item);
        if ($previous->next != null) {
            $previous->next = $previous->next->next;
        }
    }

    // findPrevious和delete的整合
    public function remove($item) {
        $current = $this->header;
        while ($current->next != null && $current->next->data != $item) {
            $current = $current->next;
        }
        if ($current->next != null) {
            $current->next = $current->next->next;
        }
    }

    // 清空链表
    public function clear() {
        $this->header = null;
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
}

$linkedList = new SingleLinkedList('header');
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
echo "</br>";
echo '-----更新节点England为Japan-----';
echo "</br>";
$linkedList->update('England', 'Japan');
echo '链表为：';
$linkedList->display();
echo "</br>";
echo "-----清空链表-----";
echo "</br>";
$linkedList->clear();
$linkedList->display();

/**

输出：
-----删除节点USA-----
链表为：China   England   Australia
-----更新节点England为Japan-----
链表为：China   Japan   Australia
-----清空链表-----
链表为空！
链表为：China   USA   England   Australia
 *
 */
