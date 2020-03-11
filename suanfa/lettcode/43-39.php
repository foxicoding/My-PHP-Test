<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/3/11
 * Time:5:19 下午
 */


class Solution
{
    protected $result = [];

    /**
     * @param Integer[] $candidates
     * @param Integer $target
     * @return Integer[][]
     */
    function combinationSum($candidates, $target)
    {
        if ($target <= 0) {
            return [];
        }
        sort($candidates);
        $this->combine($candidates, $target, [], 0);
        return $this->result;
    }

    private function combine($nums, $target, $list, $start)
    {
        if ($target < 0) {
            return;
        }
        if ($target == 0) {
            $this->result[] = $list;
            return;
        }
        var_dump('------' . $target);
        for ($i = $start; $i < count($nums); $i++) {
            var_dump($i);
            //由于数字是排好序的，所以可以进行剪枝
            if ($target - $nums[$i] < 0) {
                var_dump($target - $nums[$i] . '///////');
                break;
            }
            $list[] = $nums[$i];
            //数字可重复使用
            var_dump($target);
            $this->combine($nums, $target - $nums[$i], $list, $i);
            //回溯
            array_pop($list);
            var_dump('++++++++' . $target);
            var_dump($list);
        }
    }
}

$nums = [2,3,5];
$target = 8;
$s = new Solution();
var_dump($s->combinationSum($nums,$target));