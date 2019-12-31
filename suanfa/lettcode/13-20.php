<?php



/**
 * author:ljb
 */

/**
 * 来源：力扣 第20题
 * 链接：https://leetcode-cn.com/problems/valid-parentheses
 *
 * 给定一个只包括 '('，')'，'{'，'}'，'['，']' 的字符串，判断字符串是否有效。

 有效字符串需满足：
 左括号必须用相同类型的右括号闭合。
 左括号必须以正确的顺序闭合。
 *
 *
 */


/**
 * 用一个栈结构
 * @param $s
 * @return bool
 */
function isValid($s) {
    if (empty($s)){
        return true;
    }
    $allow = [
        ')' => '(',
        ']' => '[',
        '}' => '{',
    ];
    $stack = new SplStack();
    $length = strlen($s);
    for ($i = 0; $i < $length; $i++){
        if ($stack->isEmpty()){
            $stack->push($s[$i]);
            continue;
        }
        if ($stack->top() == $allow[$s[$i]]){
            $stack->pop();
            continue;
        }
        $stack->push($s[$i]);
    }
    return $stack->isEmpty();
}

$s = '()';
var_dump(isValid($s));

