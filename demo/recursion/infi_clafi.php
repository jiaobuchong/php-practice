<?php
header('Content-Type:text/html;charset=utf-8');
/*
array(
array('id'=>1, 'name'=>'重庆'),
array('id'=>2, 'name'=>'綦江区'),
array('id'=>3, 'name'=>'赶水镇'),
array('id'=>4, 'name'=>'贵州'),
array('id'=>5, 'name'=>'遵义市'),
array('id'=>6, 'name'=>'遵义县'),
array('id'=>7, 'name'=>'南白镇'),
array('id'=>8, 'name'=>'贵阳')
);
其中 綦江区 1是其父地区
递归 将地区的上下级关系 层次打印出来

----无限级分类
为了表示地区之间的上下关系，人为的增加了一个字段
parent
parent 的值是该栏目的父栏目的id

找A栏目的子栏目时：谁的parent值等于A的id，谁就是A的儿子
array(
array('id'=>1, 'name'=>'重庆', 'parent'=>0),
array('id'=>2, 'name'=>'綦江区', 'parent'=>1),
array('id'=>3, 'name'=>'赶水镇', 'parent'=>2),
array('id'=>4, 'name'=>'贵州', 'parent'=>0),
array('id'=>5, 'name'=>'遵义市', 'parent'=>4),
array('id'=>6, 'name'=>'遵义县', 'parent'=>5),
array('id'=>7, 'name'=>'南白镇', 'parent'=>6),
array('id'=>8, 'name'=>'贵阳', 'parent'=>4)
);

顺着这层关系，我们可以分析出
0
  重庆
     綦江区  0-1
         赶水镇  0-1-2
  贵州

无限级分类，牵涉两个应用
0、找指定栏目的子栏目
1、找指定栏目的子孙栏目，即子孙树
2、找指定栏目的父栏目/父父栏目……顶级栏目，即家谱树

*/
$area = array(
array('id'=>1, 'name'=>'重庆', 'parent'=>0),
array('id'=>2, 'name'=>'綦江区', 'parent'=>1),
array('id'=>3, 'name'=>'赶水镇', 'parent'=>2),
array('id'=>4, 'name'=>'贵州', 'parent'=>0),
array('id'=>5, 'name'=>'遵义市', 'parent'=>4),
array('id'=>6, 'name'=>'遵义县', 'parent'=>5),
array('id'=>7, 'name'=>'南白镇', 'parent'=>6),
array('id'=>8, 'name'=>'贵阳', 'parent'=>4),
array('id'=>9, 'name'=>'沙坪坝区', 'parent'=>1)
);

//找子栏目
function findSon($arr, $id = 0)
{
    //id栏目的儿子有哪些呢？
    //answer:数组循环一遍，谁的parent值等于id, 谁就是他儿子
    $sons = array();   //子栏目组

    foreach ($arr as $val)
    {
        if ($val['parent'] == $id)
        {
            $sons[] = $val;
        }
    }
    return $sons;
}
echo '<pre>';
print_r(findSon($area, 1));
echo '</pre>';

//子孙树
/*
在函数中声明的static 变量
1、修饰类的属性与方法 静态方法和属性 
2、static::method()
3、在函数中声明static
*/ 
function subTree($arr, $id = 0, $lev = 1)
{
    static $subs = array();

    foreach ($arr as $val)
    {
        if ($val['parent'] == $id)
        {
            $val['lev'] = $lev;
            $subs[] = $val;
            //或删掉static $subs = array_merge($subs, subTree($arr, $val['id'], $lev+1));
            subTree($arr, $val['id'], $lev+2);   
        }
    }
    return $subs;
}

$tree = subTree($area);
foreach ($tree as $val)
{
    echo str_repeat('&nbsp;&nbsp;', $val['lev']), $val['name'], '<br />';
}

/*
迭代寻找子孙树
用栈来实现
*/
function subTree1($arr, $parent = 0)
{
    $task = array($parent);   //任务表
    $tree = array();    //地区表
    while (!empty($task))
    {
        $flag = false;
        foreach ($arr as $k => $v)
        {
            if ($v['parent'] == $parent)
            {
                $tree[] = $v;
                array_push($task, $v['id']);    //把最新的id压入任务栈
                $parent = $v['id'];      //修改parent的值
                unset($arr[$k]);     //将找到的数组值从数组中抹掉
                $flag = true;     //说明找到了子栏目
            }
        }
        if ($flag == false)
        {
            array_pop($task);
            $parent = end($task);
        }
    }

    return $tree;
}
echo '<pre>';
print_r(subTree1($area));
echo '</pre>';
 
?> 
