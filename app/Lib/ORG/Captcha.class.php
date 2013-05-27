<?php
class Captcha {
	public $width  = 80;
	public $height = 30;
	public $glbVerifySeed = "abcdefghjkmnpqrstuvwxyz";
	public $strLength = 5;
	public $session_var = 'authcode';
	public $backgroundColor = array(255, 255, 255);
	public $colors = array(
			array(27,78,181), // blue
			array(22,163,35), // green
			array(214,36,7),  // red
			array(78,78,78),
	);
	public $PolluteNum = 100;
	public $Yperiod    = 11;
	public $Yamplitude = 12;
	public $Xperiod    = 13;
	public $Xamplitude = 1;

	public $maxRotation = 0;
	public $scale = 2;

	public $imageFormat = 'png';
	public $im;

	public function __construct($config = array()) {
		if(intval($config['width'])>120) $this->width = $config['width'];
		if(intval($config['height'])>50) $this->height = $config['height'];
		if($this->width > 150 || $this->height>50) {
			$this->scale = 1;
		}
		//$this->PolluteNum = intval($this->width*$this->height/20);
		$this->PolluteNum = 0;
	}

	public function CreateImage() {

		$ini = microtime(true);
		$this->ImageAllocate();
		$text = $this->GetCaptchaText(); 
		$this->WriteText($text);
		session('authcode',strtoupper($text));
		//$_SESSION[$this->session_var] = strtoupper($text);
		if($this->height>30) {
			$this->WaveImage();
		}
		$this->ReduceImage();
		$this->Pollute();
		$this->Line();
		$this->WriteImage();
		$this->Cleanup();
	}


	protected function ImageAllocate() {
		if (!empty($this->im)) {
			imagedestroy($this->im);
		}

		$this->im = imagecreatetruecolor($this->width*$this->scale, $this->height*$this->scale);

		$this->GdBgColor = imagecolorallocate($this->im,
				$this->backgroundColor[0],
				$this->backgroundColor[1],
				$this->backgroundColor[2]
		);
		imagefilledrectangle($this->im, 0, 0, $this->width*$this->scale, $this->height*$this->scale, $this->GdBgColor);

		$color           = $this->colors[mt_rand(0, sizeof($this->colors)-1)];
		$this->GdFgColor = imagecolorallocate($this->im, $color[0], $color[1], $color[2]);
	}

	protected function GetCaptchaText() {
		$bgnIdx = 0;
		$endIdx = strlen($this->glbVerifySeed)-1;
		$code = "";
		for($i=0; $i<$this->strLength; $i++) {
			$curPos = rand($bgnIdx, $endIdx);
			$code .= substr($this->glbVerifySeed, $curPos, 1);
		}
		return $code;
	}

	protected function WriteText($text) {
		$fontcfg = array(
				'spacing' => 0,
				'minSize' => $this->height/2+2,
				'maxSize' => $this->height/2+4,
				'font' => realpath(dirname(__FILE__)).'/'.'MONACO.TTF'
		);

		$x      = 10*$this->scale;
		$y      = round(($this->height*27/40)*$this->scale);
		$length = strlen($text);
		for ($i=0; $i<$length; $i++) {
			$degree   = rand($this->maxRotation*-1, $this->maxRotation);
			$fontsize = rand($fontcfg['minSize'], $fontcfg['maxSize'])*$this->scale;
			$letter   = substr($text, $i, 1);
				
			$coords = imagettftext($this->im, $fontsize, $degree,
					$x, $y,
					$this->GdFgColor, $fontcfg['font'], $letter);

			$x += ($coords[2]-$x) + ($fontcfg['spacing']*$this->scale);
		}

	}

	protected function WaveImage() {
		$xp = $this->scale*$this->Xperiod*rand(1,3);
		$k = rand(0, 100);
		for ($i = 0; $i < ($this->width*$this->scale); $i++) {
			imagecopy($this->im, $this->im,
			$i-1, sin($k+$i/$xp) * ($this->scale*$this->Xamplitude),
			$i, 0, 1, $this->height*$this->scale);
		}

		$k = rand(0, 100);
		$yp = $this->scale*$this->Yperiod*rand(1,2);
		for ($i = 0; $i < ($this->height*$this->scale); $i++) {
			imagecopy($this->im, $this->im,
			sin($k+$i/$yp) * ($this->scale*$this->Yamplitude), $i-1,
			0, $i, $this->width*$this->scale, 1);
		}
	}

	// 缩小图片
	protected function ReduceImage() {
		$imResampled = imagecreatetruecolor($this->width, $this->height);
		imagecopyresampled($imResampled, $this->im,
		0, 0, 0, 0,
		$this->width, $this->height,
		$this->width*$this->scale, $this->height*$this->scale
		);
		imagedestroy($this->im);
		$this->im = $imResampled;
	}

	// 输出图片
	protected function WriteImage() {
		if ($this->imageFormat == 'png' && function_exists('imagepng')) {
			header("Content-type: image/png");
			imagepng($this->im);
		} else {
			header("Content-type: image/jpeg");
			imagejpeg($this->im, null, 90);
		}
	}

	// 画出杂点
	protected function Pollute() {
		$imgWidth = imagesx($this->im);
		$imgHeight = imagesy($this->im);
		for($j=0; $j<$this->PolluteNum; $j++) {
			$x = rand(0, $imgWidth);
			$y = rand(0, $imgHeight);
			imagesetpixel($this->im, $x, $y, $this->GdFgColor);
		}
	}

	// 画出一条线
	protected function Line() {
		$imgWidth = imagesx($this->im);
		$imgHeight = imagesy($this->im);
		$y = ceil($imgHeight/2);
		$border = floor($imgHeight/20);
		for($j=10; $j<($imgWidth-10); $j++) {
			$x = $j;
			$y = rand(-1,1)+$y;
			for($i=-1; $i<($border-1); $i++) {
				imagesetpixel($this->im, $x, $y+$i, $this->GdFgColor);
			}
		}
	}

	protected function Cleanup() {
		imagedestroy($this->im);
	}
}
?>