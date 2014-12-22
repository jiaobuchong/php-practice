<?php
class FileUpload
{
    private $filepath; //文件上传路径
    private $allowType = array('gif', 'jpg', 'jpeg', 'png'); //允许的文件类型
    private $maxsize = 1000000;  //允许上传文件的最大尺寸
    private $israndname = true; //是否随机重命名文件名
    private $originName; // 原文件名称
    private $tmpFileName;  //临时文件
    private $fileType;  //文件类型
    private $fileSize;  //文件大小
    private $newFileName; //新的文件名
    private $errorNum = 0; //错误号
    private $errorMsg = ''; //用来提供错误报告

    /**
     *用于对上传文件初始化
     *1、上传路径 2、允许路径 3、限制大小 4、是否使用随机文件名 
     *用户不用按位置传参数, 在new对象时构造函数中后面参数给值，前面不用给
     *所以按数组来传递参数
     **/
    public function __construct($options = array())
    {
        //get_class_vars() 返回类的属性
        //如array('filepath'=>'./uploads', 'maxsize'=>'1000000')
        //array_keys(), 返回数组的键值
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
                $str .= '不允许的类型。';
                break;
            case -2:
                $str .= "文件过大，上传文件不能超过{$this->maxsize}个字节。";
                break;
            case -3:
                $str .= '上传失败。';
                break;
            case -4:
                $str .= '建立存放上传目录失败，请重新指定上传目录。';
                break;
            case -5:
                $str .= '必须指定上传文件的路径。';
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
        //如果没有指定文件名
        if (empty($this->filepath)) // 判断路径是否为空
        {
            $this->setOption('errorNum', -5);
            return false;
        }

        //如果指定的文件名不存在，或不可写
        if (!file_exists($this->filepath) || !is_writable($this->filepath))
        {
            //如果不成功
            if (!@mkdir($this->filepath, 0755))
            {
                $this->setOption('errorNum', -4);
                return false;
            }
        }
        return true;
    }
  /**
   * 检查文件大小
   **/
    private function checkFileSize()
    {
        if ($this->fileSize > $this->maxsize)
        {
            $this->setOption('errorNum', '-2');
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
            $this->setOption('errorNum', -1);
            return false;
        }
    }

    /**
     * 设置随机文件名称
     **/
    private function proRandName()
    {
        $newFileName = date('YmdHis') . rand(1000, 9999) . '.' . $this->fileType;
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
       //检查文件类型优先
        $this->setOption('originName', $name);
         //获取文件后缀名，并将其转化为小写
        $arrStr = explode('.', $name);
        $this->setOption('fileType', strtolower($arrStr[count($arrStr) - 1]));   //后缀名
        
        //检查文件类型
        if (!$this->checkFileType())
        {
            return false;
        }

        $this->setOption('errorNum', $error);
        if ($error)
        {
            return false;
        }
       
        $this->setOption('tmpFileName', $tmp_name);
        $this->setOption('fileSize', $size);
        return true;
    }

    /**
     * 把文件从临时文件夹拷贝出去
     **/
    private function copyFile()
    {
        if (!$this->errorNum)  //检查错误号,如果为0
        {
            //让'./uploads/' 和 './upload' 都能用  
            $filepath = rtrim($this->filepath, '/') . '/';
            $filepath .= $this->newFileName;  //连接文件名
            if (is_uploaded_file($this->tmpFileName))
            {
                if (@move_uploaded_file($this->tmpFileName, $filepath))
                {
                    return true;
                }
                else
                {
                    $this->setOption('errorNum', -3);
                    return false; 
                }
            }
            else
            {
                //如果不是通过 HTTP POST 上传的
                return false;
            }

        }
        else
        {
            return false;
        }
    }
     /**
        * 调用该方法上传文件
        * @parm string $fileField   上传文件的表单名称
        * @return bool              如果上传成功返回true
     **/
    public function uploadFile($fileField)
    {
        $flag = true;   //记录成功和失败
        //检查文件上传路径
        if (!$this->checkFilePath())
        {
            $this->errorMsg = $this->getError();
            return false;   //如果上传路径失败，结束函数
        }

        $name = $_FILES[$fileField]['name']; //文件名
        $tmp_name = $_FILES[$fileField]['tmp_name']; //临时文件名
        $size = $_FILES[$fileField]['size'];  //文件大小
        $error = $_FILES[$fileField]['error'];  //错误号

        if ($this->setFiles($name, $tmp_name, $size, $error)) //成功
        {
            //检查文件大小 
            if ($this->checkFileSize()) 
            {
                //文件大小没问题
                $this->setNewFileName();  //设置上传文件的文件名
                if ($this->copyFile())
                {
                    return true;
                }
                else
                {
                    $flag = false;
                }
            }
            else
            {
                //有问题
                $flag = false;
            }
        }
        else
        {
            $flag = false;
        }

        //将错误信息赋值给FileUpload类的$this->errorMsg 属性
        if(!$flag)   //如果出错
        {
            $this->errorMsg = $this->getError();
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
