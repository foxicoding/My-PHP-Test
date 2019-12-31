<?php


/**
 * ljb
 */

/**
 * 来源：力扣 第206题
 * 链接：https://leetcode-cn.com/problems/reverse-linked-list
 * 反转一个单链表。

    示例:
    输入: 1->2->3->4->5->NULL
    输出: 5->4->3->2->1->NULL
    进阶:
    你可以迭代或递归地反转链表。你能否用两种方法解决这道题？

 */

/**
 * @param $head
 * @return null
 */
function reverseList($head) {
    $pre = NULL;
    $cur = $head;
    while ($cur != NULL){
        $cur->next = $pre;
        $pre = $cur;
        $cur = $cur->next;
    }
    return $pre;
}



