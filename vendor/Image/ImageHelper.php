<?php 

class ImageHelper{

	protected $img;
	protected $img_type = array(
        'image/gif',
        'image/jpg',
        'image/jpeg',
        'image/bmp',
        'image/pjpeg',
        'image/x-png',
        'image/png',
    );

    /**
     * [__construct 构造函数]
     * @Author   Limx
     * @Method   直接调用
     * @DateTime 2015-12-29T09:22:46+0800
     * @param    [type]                   $pic [description]
     */
	public function __construct($pic){
		$this->img=$pic;
     
	}

	/**
	 * [isValid 判断图片的有效性]
	 * @Author   Limx
	 * @Method   直接调用
	 * @DateTime 2015-12-29T09:10:42+0800
	 * @return   boolean                  [description]
	 */
	protected function isValid(){
		$error=$this->img["error"];

		if($error=="0"){
			if(in_array($this->img["type"],$this->img_type)){
				return true;
			}
		}
		return false;
	}

	public static function ImgCompress($Image, $Dw = 450, $Dh = 450, $Type = 2,$ex="_x"){
		IF (! File_Exists($Image)) {
	        Return False;
	    } // 如果需要生成缩略图,则将原图拷贝一下重新给$Image赋值
	    IF ($Type != 1) {
	        Copy($Image, Str_Replace(".", $ex.".", $Image));
	        $Image = Str_Replace(".", $ex.".", $Image);
	    } // 取得文件的类型,根据不同的类型建立不同的对象
	    $ImgInfo = GetImageSize($Image);
	    Switch ($ImgInfo[2]) {
	        Case 1:
	            $Img = @ImageCreateFromGIF($Image);
	            Break;
	        Case 2:
	            $Img = @ImageCreateFromJPEG($Image);
	            Break;
	        Case 3:
	            $Img = @ImageCreateFromPNG($Image);
	            Break;
	    } // 如果对象没有创建成功,则说明非图片文件
	    IF (Empty($Img)) { // 如果是生成缩略图的时候出错,则需要删掉已经复制的文件
	        IF ($Type != 1) {
	            Unlink($Image);
	        }
	        Return False;
	    } // 如果是执行调整尺寸操作则
	    IF ($Type == 1) {
	        $w = ImagesX($Img);
	        $h = ImagesY($Img);
	        $width = $w;
	        $height = $h;
	        IF ($width > $Dw) {
	            $Par = $Dw / $width;
	            $width = $Dw;
	            $height = $height * $Par;
	            IF ($height > $Dh) {
	                $Par = $Dh / $height;
	                $height = $Dh;
	                $width = $width * $Par;
	            }
	        } ElseIF ($height > $Dh) {
	            $Par = $Dh / $height;
	            $height = $Dh;
	            $width = $width * $Par;
	            IF ($width > $Dw) {
	                $Par = $Dw / $width;
	                $width = $Dw;
	                $height = $height * $Par;
	            }
	        } else {
	            $width = $width;
	            $height = $height;
	        }
	        $nImg = ImageCreateTrueColor($width, $height); // 新建一个真彩色画布
	        ImageCopyReSampled($nImg, $Img, 0, 0, 0, 0, $width, $height, $w, $h); // 重采样拷贝部分图像并调整大小
	        ImageJpeg($nImg, $Image); // 以JPEG格式将图像输出到浏览器或文件
	        Return True; // 如果是执行生成缩略图操作则
	    } else {
	        $w = ImagesX($Img);
	        $h = ImagesY($Img);
	        $width = $w;
	        $height = $h;
	        $nImg = ImageCreateTrueColor($Dw, $Dh);
	        IF ($h / $w > $Dh / $Dw) { // 高比较大
	            $width = $Dw;
	            $height = $h * $Dw / $w;
	            $IntNH = $height - $Dh;
	            ImageCopyReSampled($nImg, $Img, 0, - $IntNH / 1.8, 0, 0, $Dw, $height, $w, $h);
	        } else { // 宽比较大
	            $height = $Dh;
	            $width = $w * $Dh / $h;
	            $IntNW = $width - $Dw;
	            ImageCopyReSampled($nImg, $Img, - $IntNW / 1.8, 0, 0, 0, $width, $Dh, $w, $h);
	        }
	        ImageJpeg($nImg, $Image);
	        Return True;
	    }
	}

}


?>