<?php
    use lib\controller;
    use app\md;
    include_once("public/md.php");
    class index extends controller{
        public function index(){
            $this->param('g','path');
            $dirs = scandir('source/1.0');
            
            //不会被列入文件目录的文件夹
            $disableDir = [
                '.',                    //当前目录
                '..',                   //上层目录
                '.DS_Store',            //macOS下的系统目录
                'code',                 //代码目录
                'img'                   //图片目录
            ];

            //整理目录结构
            $columns = [];
            foreach($dirs as $k => $dir){
                if(!in_array($dir,$disableDir)){
                    $files = scandir('source/1.0/'.$dir);
                    $fileArr = [];
                    foreach($files as $kk => $file){
                        if(!in_array($file,$disableDir)){
                            $fileArr[] = [
                                'path'  => $dir.'/'.$file,
                                'title' => substr($file,0,strpos($file,'.md'))
                            ];
                        }
                    }

                    $columns[] = [
                        'title'     => $dir,
                        'files'     => $fileArr
                    ];
                }
            }

            $filename = 'source/1.0/'.$this->path;
            if(is_file($filename)){
                $fileData = fopen($filename, "r");
                $content = fread($fileData,filesize($filename));
                $md = new md();
                $html = $md->text($content);
            }else{
                xtError('没有这个文件啊：'.$filename);
            }

            $res = [
                'columns'   => $columns,
                'html'      => $html
            ];

            echo $html;
            return $res;
        }
    }