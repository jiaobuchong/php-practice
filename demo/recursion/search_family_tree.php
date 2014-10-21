<?php
header('Content-Type:text/html;charset=utf-8');
$area = array(
array('id'=>1, 'name'=>'重庆', 'parent'=>0),
array('id'=>2, 'name'=>'綦江区', 'parent'=>1),
array('id'=>3, 'name'=>'赶水镇', 'parent'=>2),
array('id'=>4, 'name'=>'贵州', 'parent'=>0),
array('id'=>5, 'name'=>'遵义市', 'parent'=>4),
array('id'=>6, 'name'=>'遵义县', 'parent'=>5),
array('id'=>7, 'name'=>'南白镇', 'parent'=>6),
array('id'=>8, 'name'=>'贵阳', 'parent'=>4)
);
/*
无限级分类之家谱树
应用--->面包屑导航 线索

找南白镇的家谱树 (parent=>6)
遵义县(id=>6, parent=>5)
遵义市(id=>5, parent=>4)
贵州(id=>4, parent=>0)

只要parent != 0
就继续找

*/
function familyTree($arr, $id)
{
    static $tree = array();
    foreach ($arr as $val)
    {
        if ($val['id'] == $id)
        {
            //$tree[] = $val;
            if ($val['parent'] > 0)   //如果到了最顶层的家谱树
            {
                //$tree = array_merge($tree, familyTree($arr, $val['parent']));
                familyTree($arr, $val['parent']);
            }
            $tree[] = $val;
            break;  //找到了就结束foreach循环
        }
    }
    return $tree;
}
echo '<pre>';
print_r(familyTree($area, 7));
echo '</pre>';

/*使用迭代来查找家谱树*/
function familyTree1($arr, $id)
{
    $tree = array();
    while ($id !== 0){
        foreach ($arr as $val)
        {
            if ($val['id'] == $id)
            {
                $tree[] = $val;
                $id = $val['parent'];
                break;
            }
        }
    }
    return $tree;
} 
echo '<pre>';
print_r(familyTree1($area, 7));
echo '</pre>';
?> 
