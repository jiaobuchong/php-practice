<?php
class FileUpload
{
    private $allowType = array('gif', 'jpg', 'jpeg', 'png'); //允许的文件类型
    private $maxsize = 1000000;  //允许上传文件的最大尺寸
    private $israndname = true; //是否随机重命名文件名
    private $originName; // 原文件名称
    private $tmpFileName;  //临时文件
    private $fileType;  //文件类型
    private $fileSize;  //文件大小
    private $newFileName; //新的文件名
    private $errorNum = 0; //错误号
    private $errorMsg = array(); //用来提供错误报告
    private $filepath; //文件上传路径

    /**
     *构造函数，传参时($path, $maxsize, $israndname, $allowType)
     *如: array('filepath'=>'./uploads', 'maxsize'=>'1000000')
     *1、上传路径 2、限制大小 3、是否使用随机文件名 4、允许的上传类型
     *所以按数组来传递参数
     *@param array $options 数组键值为类FileUpload属性名，值为具体的值
     **/
    public function __construct($options = array())
    {
        $arr = array_keys(get_class_vars(get_class($this)));
        foreach ($options as $key => $value)
        {
            $key = strtolower($key);
            if ( !in_array($key, $arr) )
            {
                continue;
            }
            $this->setOption($key, $value); //为对象属性赋值
        }
    }
     /**
      *  为对象属性赋值
      **/
    private function setOption($key, $value)
    {
       $this->$key = $value; 
    }

    private function getError()
    {
        $str = "上传文件<font color='red'>{$this->originName}</font>时出错！";
        switch ($this->errorNum)
        {
            case 4:
                $str .= '没有文件被上传。';
                break;
            case 3:
                $str .= '文件只有部分被上传。';
                break;
            case 2:
                $str .= '上传文件的大小超过了HTML表单中MAX_FILE_SIZE选项指定的值。';
                break;
            case 1:
                $str .= '上传的文件超过了php.ini中upload_max_filesize选项限制的值。';
                break;
            case -1:
                $str .= '不允许的文件扩展名类型。';
                break;
            case -2:
                $str .= "文件过大，上传文件不能超过{$this->maxsize}个字节。";
                break;
            case -3:
                $str .= '上传失败。';
                break;
            case -4:
                $str .= '指定的上传目录不存在或者指定目录没有写的权限。';
                break;
           default: 
               $str .= '未知错误。';
        }
        return $str;
    }

    /**
        * 检查文件上传路径
        *
        **/
    private function checkFilePath()
    {
        if (file_exists($this->filepath) && is_writable($this->filepath)) // 判断上传文件夹是否存在或可写
        {
            return true;
        }
        else
        {
            return false;
        }
    }
  /**
   * 检查文件大小,用户指定的文件大小
   **/
    private function checkFileSize()
    {
        if ($this->fileSize > $this->maxsize)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * 检查文件类型
     **/
    private function checkFileType()
    {
        //如果上传文件的后缀名在所要求的的$this->allowType里
        if (in_array($this->fileType, $this->allowType))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 设置随机文件名称
     **/
    private function proRandName()
    {
        $newFileName = date('YmdHis') . '_' . mt_rand(1000, 9999) . '.' . $this->fileType;
        return $newFileName;
    }

    /**
        * 设置上传后的文件名称
        *
        **/
    private function setNewFileName()
    {
        if ($this->israndname)
        {
           $this->setOption('newFileName', $this->proRandName()); 
        }
        else
        {
            $this->setOption('newFileName', $this->originName);
        }
    }

   
    /**
     * 设置和$_FILES有关的内容
     **/
    private function setFiles($name='', $tmp_name='', $size=0, $error=0)
    {
        //1、如果上传的文件本身出错
        if ($error)
        {
            $this->assignErrorInfo($error);
            return false;
        }

       $flag1 = true;   //对应文件扩展名
       $flag2 = true;   //对应文件大小
       $this->setOption('tmpFileName', $tmp_name);

       //2、检查文件扩展名
        $this->setOption('originName', $name);
         //获取文件后缀名，并将其转化为小写
        $arrStr = explode('.', $name);
        $this->setOption('fileType', end($arrStr));   //后缀名
        
        if (!$this->checkFileType())
        {
            $this->assignErrorInfo(-1);
            $flag1 = false;
        }

        //3、检查文件大小
        $this->setOption('fileSize', $size);
        if (!$this->checkFileSize())
        {
            $this->assignErrorInfo(-2);
            $flag2 = false;
        }

        if ($flag1 && $flag2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * 把文件从临时文件夹拷贝出去
     **/
    private function copyFile()
    {
        //让'./uploads/' 和 './upload' 都能用  
        $filepath = rtrim($this->filepath, '/') . '/';
        $filepath .= $this->newFileName;  //连接文件名
        if (is_uploaded_file($this->tmpFileName))
        {
            //开始移动
            if (@move_uploaded_file($this->tmpFileName, $filepath))
            {
                return true;
            }
            else
            {
                $this->assignErrorInfo(-3);
                return false; 
            }
        }
        else
        {
            //如果不是通过 HTTP POST 上传的
            $this->assignErrorInfo(-3);
            return false;
        }
    }

    /**
     *根据错误号，保存对应的错误信息
     *@param int $num 传一个错误号
     **/
     public function assignErrorInfo($num)
     {
        $this->setOption('errorNum', $num);
        $this->errorMsg[] = $this->getError();
     }

     /**
        * 调用该方法上传文件
        * @parm string $fileField   上传文件的表单名称
        * @return bool              如果上传成功返回true
     **/
    public function uploadFile($fileField)
    {
        //首先检查文件上传路径
        if (!$this->checkFilePath())
        {
            $this->assignErrorInfo(-4);
            return false;   //如果上传路径失败，结束函数
        }
       
        $name = $_FILES[$fileField]['name']; //文件名
        $tmp_name = $_FILES[$fileField]['tmp_name']; //临时文件名
        $size = $_FILES[$fileField]['size'];  //文件大小
        $error = $_FILES[$fileField]['error'];  //错误号

        $flag = array();        //记录每一个文件是否上传成功,目的是在多文件上传的时候，即使一个文件出错其他文件也能继续上传
        if (is_array($name))  //上传多个文件时
        {
            $filenames = array();    //存放上传后文件名的数组
            for ($i = 0; $i < count($name); $i++)
            {
                if ($this->setFiles($name[$i], $tmp_name[$i], $size[$i], $error[$i]))
                {
                    $this->setNewFileName();  //设置上传文件的文件名
                    if ($this->copyFile())    //如果从临时文件移动文件成功
                    {
                        $filenames[] = $this->newFileName;
                        $flag[] = true;
                    }
                    else
                    {
                        $flag[] = false;
                    }
                }
                else
                {
                    $flag[] = false;
                }
            }
            $this->newFileName = $filenames;
        }
        else    //单个文件
        {
            if ($this->setFiles($name, $tmp_name, $size, $error))
            {
                $this->setNewFileName();  //设置上传文件的文件名
                if ($this->copyFile())    //如果从临时文件移动文件成功
                {
                    $flag[] = true;
                }
                else
                {
                    $flag[] = false;
                }
            }
            else
            {
                $flag[] = false;
            }
        }
        return $flag;
    }

    /**
        *  获取上传后文件的文件名
        *
    **/
    public function getNewFileName()
    {
        return $this->newFileName;
    }

    /**
        *  如果上传失败，返回错误信息
        *
    **/
    public function getErrorMsg()
    {
       return $this->errorMsg; 
    }
}
?>

