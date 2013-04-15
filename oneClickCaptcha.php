<?php
/**
 * One click captcha Generator
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Kacper Rowinski <kacper.rowinski@gmail.com>
 *
 */
final class oneClickCaptcha
{
	// configuration

	// name of the key in session that oneClickCaptcha should keep
	public $SessionName     = 'oneClickCaptcha';
	// img width
	public $Width 		    = 400;
	// img height
	public $Height 		    = 200;
	// fake cicle amount
	public $CircleAmount    = 3;
	// circle color
	public $CircleColor     = array(255, 255, 255);
	// background color
	public $BackGroundColor = array(0, 0, 0);
	// circle size on img
	public $CircleSize      = 60;

	// an image resource
	private $_img_res 	    = null;
	// an image color resource
	private $_circle_color  = null;
	// other circle
	private $_circle_other  = array();

	public function __construct()
	{
		// start session if is not started already
		if ('' == session_id())
		{
			session_start();
		}
	}

	/**
	 * Validates if clicked circle is correct one.
	 *
	 * @return boolen
	 */
	public function Validate()
	{
		if (
			isset($_REQUEST['position'][0]) and isset($_REQUEST['position'][1]) and is_numeric($_REQUEST['position'][0]) and is_numeric($_REQUEST['position'][1]) and
			isset($_SESSION[$this->SessionName]['position']['x']) and isset($_SESSION[$this->SessionName]['position']['y']) and isset($_SESSION[$this->SessionName]['position']['r'])
		)
		{
			$_SESSION[$this->SessionName]['last_click'] = $_REQUEST['position'];

			$distance = self::_calculateDistance($_REQUEST['position'][0], $_SESSION[$this->SessionName]['position']['x'], $_REQUEST['position'][1], $_SESSION[$this->SessionName]['position']['y']);
			if ($distance < $_SESSION[$this->SessionName]['position']['r'])
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Calcualte distance using pattern to find point in the circle.
	 *
	 * @param int $pMx
	 * @param int $pCx
	 * @param int $pMy
	 * @param int $Cy
	 */
	private static function _calculateDistance($pMx, $pCx, $pMy, $Cy)
	{
		// power of math!
		return round(sqrt(($pMx - $pCx) * ($pMx - $pCx) + ($pMy - $Cy) * ($pMy - $Cy)));
	}

	/**
	 * Generates img
	 */
	public function GenerateCaptchaImg()
	{
		// img res
		$this->_img_res 	 = imagecreatetruecolor($this->Width, $this->Height);

		// img background color
		imagefill($this->_img_res, 0, 0, imagecolorallocatealpha($this->_img_res, $this->BackGroundColor[0], $this->BackGroundColor[1], $this->BackGroundColor[2], 127));

		// generate circle color
		$this->_circle_color = imagecolorallocate($this->_img_res, $this->CircleColor[0], $this->CircleColor[1], $this->CircleColor[2]);

		for ($i = 1; $i <= $this->CircleAmount; ++$i)
		{
			$this->_generateCircle(true);
		}
		$this->_generateCircle(false);

		header('Pragma: public');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Content-type: image/png');

		imagepng($this->_img_res);
		imagedestroy($this->_img_res);
		die;
	}

	/**
	 * Generates circles
	 *
	 * @param boolen $pFake
	 */
	private function _generateCircle($pFake)
	{
		$min = $this->CircleSize / 2;

		// decrease probability of clicking x times same place and hit correct one.
		if (isset($_SESSION[$this->SessionName]['last_click']) and false === $pFake)
		{
			while(true)
			{
				$x = mt_rand($min, $this->Width - $min);
				$y = mt_rand($min, $this->Height - $min);

				if ($min < self::_calculateDistance($_SESSION[$this->SessionName]['last_click'][0], $x, $_SESSION[$this->SessionName]['last_click'][1], $y))
				{
					break;
				}
			}
		}
		else
		{
			$x = mt_rand($min, $this->Width - $min);
			$y = mt_rand($min, $this->Height - $min);
		}

		if (true === $pFake)
		{
			imagearc($this->_img_res, $x, $y, $this->CircleSize, $this->CircleSize, 0, 360, $this->_circle_color);
		}
		// the 'real one' circle, we save to check leater
		else
		{
			// save circle position
			$_SESSION[$this->SessionName]['position'] = array('x' => $x, 'y' => $y, 'r' => $min);

			// "move" circle cut
			$z1 = mt_rand(-340, 0);
			$z1_left = 340 + $z1;

			$z2 = mt_rand(0, 340);
			$z2_left = 340 - $z2;

			$z2 += $z1_left;
			$z1 -= $z2_left;

			imagearc($this->_img_res, $x, $y, $this->CircleSize, $this->CircleSize, $z1, $z2, $this->_circle_color);
		}
	}
}