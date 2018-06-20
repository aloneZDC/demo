<?php
	/**
	 *fopen(filename, mode)   打开文件  
	 *fwrite(handle, string)  写入文件
	 *fclose(handle)          关闭文件
	 *unset(var)              删除
	 *file_get_contents(filename)			获取一个文件的内容
	 *file_put_contents(filename, data)		将内容写入文件
	 *'w'    fopen->mode  	  		 写入内容
	 *'a'	 fopen->mode  	  		 追加内容 				  
	 *\n     fwrite->string   		 内容换行(需使用双引号，单引号不起作用)
	 *PHP_EOL   "string".PHP_EOL     内容换行               
	 *FILE_APPEND  file_put_contents(filename,text,FILE_APPEND)  追加内容
	*/

	function demo(){
		$test="./test.txt";
		$fp=fopen($test,'w');
		$text="成功写入 \n";
		fwrite($fp,$text);
		fclose($fp);
	}
	//demo();

	function demo2(){
		$test="./test.txt";
		$fp=fopen($test,'a');
		$text="<?php echo 123; ?>";
		fwrite($fp,$text);
		fclose($fp);
	}
	//demo2();

	function demo3(){
		$test='./test.txt';
		$demo='./demo.txt';
		$text=file_get_contents($test);
		file_put_contents($demo,$text);//file_put_contents($demo,'123456',FILE_APPEND) 追加内容
	}
	//demo3();

?>



