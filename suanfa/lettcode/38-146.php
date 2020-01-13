<?php
/**
 * Create by phpstorm
 * User:liujinbao
 * Date:2020/1/13
 * Time:2:53 下午
 */


/**
 * 来源：力扣（LeetCode）第146题
 * 链接：https://leetcode-cn.com/problems/lru-cache
 *

运用你所掌握的数据结构，设计和实现一个  LRU (最近最少使用) 缓存机制。它应该支持以下操作： 获取数据 get 和 写入数据 put 。

获取数据 get(key) - 如果密钥 (key) 存在于缓存中，则获取密钥的值（总是正数），否则返回 -1。
写入数据 put(key, value) - 如果密钥不存在，则写入其数据值。当缓存容量达到上限时，它应该在写入新数据之前删除最近最少使用的数据值，从而为新的数据值留出空间。

进阶:

你是否可以在 O(1) 时间复杂度内完成这两种操作？

示例:

LRUCache cache = new LRUCache( 2是缓存容量

cache.put(1, 1);
cache.put(2, 2);
cache.get(1);       // 返回  1
cache.put(3, 3);    // 该操作会使得密钥 2 作废
cache.get(2);       // 返回 -1 (未找到)
cache.put(4, 4);    // 该操作会使得密钥 1 作废
cache.get(1);       // 返回 -1 (未找到)
cache.get(3);       // 返回  3
cache.get(4);       // 返回  4


/**
 * Class LRUCache
 */
class LRUCache {

    private $capacity;
    private $cache = [];
    private $cacheIndex = [];

    /**
     * @param Integer $capacity
     */
    function __construct($capacity) {
        $this->capacity = $capacity;
    }

    /**
     * @param Integer $key
     * @return Integer
     */
    function get($key) {
        if (!in_array($key,$this->cacheIndex)){
            return -1;
        }
        unset($this->cacheIndex[array_search($key,$this->cacheIndex)]);
        $this->cacheIndex[] = $key;
        return $this->cache[$key];
    }

    /**
     * @param Integer $key
     * @param Integer $value
     * @return NULL
     */
    function put($key, $value) {
        if (in_array($key,$this->cacheIndex)){
            unset($this->cacheIndex[array_search($key,$this->cacheIndex)]);
            $this->cacheIndex[] = $key;
        }else{
            //没有容量的情况下，需要删掉第一个然后put
            if ($this->capacity == 0){
                $popValueIndex = array_shift($this->cacheIndex);
                unset($this->cache[$popValueIndex]);
                $this->cacheIndex[] = $key;
            }else{
                $this->cacheIndex[] = $key;
                $this->capacity -= 1;
            }
        }
        $this->cache[$key] = $value;
    }
}

$lruCache = new LRUCache(2);
echo $lruCache->get(2) . '<br/>';
$lruCache->put(2,6);
echo $lruCache->get(1) . '<br/>';
$lruCache->put(1,5);
$lruCache->put(1,2);
echo $lruCache->get(1) . '<br/>';
echo $lruCache->get(2) . '<br/>';