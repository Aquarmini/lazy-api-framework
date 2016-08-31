<?php
require_once "ImageHelper.php";
class ImageUpload extends ImageHelper {

	/**
	 * 上传单图
	 */
	public function uploads($root = "Uploads/", $picName) {

		if (!parent::isValid()) {
			return false;
		}

		if (!is_dir($root)) {
			mkdir($root, 0777, true);
		}

		$objRe = move_uploaded_file($this -> img["tmp_name"], $root . $picName);

		if ($objRe) {
			return true;
		}
		return false;
	}

	/**
	 * 上传多图
	 */
	public function uploadPics($root = "Uploads/", $state = false, $Dw = 450, $Dh = 450) {

		if (!is_dir($root)) {
			mkdir($root, 0777, true);
		}

		$tmp_names = $this -> img["tmp_name"];

		$i = 0;
		$names = false;
		foreach ($tmp_names as $key => $value) {
			if ($this -> img["error"][$key] != 0) {
				continue;
			}

			if (!in_array($this -> img["type"][$key], $this -> img_type)) {
				continue;
			}

			$name = $this -> img["name"][$key];
			$arrPath = pathinfo($name);
			$strFileName = date("YmdHis") . rand(0, 99) . $i . "." . $arrPath["extension"];
			$objRe = move_uploaded_file($value, $root . $strFileName);
			$names[] = $strFileName;
			if ($state) {
				ImageHelper::ImgCompress($root . $strFileName, $Dw, $Dh);
			}
			$i++;
		}

		return $names;
	}

	/**
	 * [uploadData 图片流上传]
	 * @Author   Limx
	 * @Method   直接调用 静态方法
	 * @DateTime 2016-03-16T11:54:45+0800
	 * @param    string                   $root    [上传路径]
	 * @param    [type]                   $picName [图片名-无扩展名]
	 * @return   [type]                            [description]
	 */
	public static function uploadData($root = "Uploads/", $data = "", $picName = "") {

		if (!is_dir($root)) {
			mkdir($root, 0777, true);
		}

		if (empty($picName)) {
			$picName = date("YmdHis") . rand(0, 99);
		}

		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $data, $result)) {
			$type = $result[2];
			$new_file = $root . $picName . ".{$type}";
			if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $data)))) {
				return $picName . ".{$type}";

			}
		}
		return false;

	}

	/**
	 * [uploadData 图片流上传]
	 * @Author   Limx
	 * @Method   直接调用 静态方法
	 * @DateTime 2016-03-16T11:54:45+0800
	 * @param    string                   $root    [上传路径]
	 * @param    [type]                   $picName [图片名-无扩展名]
	 * @return   [type]                            [description]
	 */
	public static function uploadDatas($root = "Uploads/", $data = array(), $picName = "") {

		if (!is_dir($root)) {
			mkdir($root, 0777, true);
		}

		if (empty($picName)) {
			$picName = date("YmdHis") . rand(0, 99);
		}
		
		$returnData=false;
		foreach ($data as $key => $value) {
			if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $value, $result)) {
				$type = $result[2];
				$new_file = $root . $picName . $key . ".{$type}";
				if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $value)))) {
					$returnData[]=$picName . $key . ".{$type}";
				}
			}
		}

		return $returnData;

	}

	public function getPicName() {

		$arrPath = pathinfo($this -> img["name"]);
		$strFileName = date("YmdHis") . rand(0, 99) . "." . $arrPath["extension"];
		return $strFileName;

	}

	public function getDay() {
		$Today = Date("Y-m-d");
		return $Today;
	}

}
?>