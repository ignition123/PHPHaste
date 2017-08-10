<?php

	namespace Libraries\Lobes\Miscellaneous;

	class Scaleimage
	{
		
		public static function autoresize($image,$image_type,$width,$height,$dir,$mvdir)
		{
			list($source_imagex,$source_imagey) = getimagesize($dir.$image);

			if($image_type == 'image/jpeg')
			{
				$front_new = @imagecreatefromstring(file_get_contents(($dir.$image)));
			}
			else if($image_type == 'image/png')
			{
				$front_new = @imagecreatefromstring(file_get_contents(($dir.$image)));
			}
			else if($image_type == 'image/gif')
			{
				$front_new = @imagecreatefromgif($dir.$image);
			}
			else
			{
				$front_new = @imagecreatefromstring(file_get_contents(($dir.$image)));
			}

			if(($source_imagex/$source_imagey)>($width/$height))
			{
				$outwidth = $width;
				$outheight = ($width*$source_imagey)/$source_imagex;
				$createimage = imagecreatetruecolor($outwidth,$outheight);
				imagecopyresampled($createimage,$front_new,0,0,0,0,$outwidth,$outheight,$source_imagex,$source_imagey);
			}
			if(($source_imagex/$source_imagey)<($width/$height))
			{
				$outwidth = ($width*$source_imagex)/$source_imagey;
				$outheight = $height;
				$createimage = imagecreatetruecolor($outwidth,$outheight);
				imagecopyresampled($createimage,$front_new,0,0,0,0,$outwidth,$outheight,$source_imagex,$source_imagey);
			}
			if(($source_imagex/$source_imagey)==($width/$height))
			{
				$outwidth = $width;
				$outheight = $height;
				$createimage = imagecreatetruecolor($outwidth,$outheight);
				imagecopyresampled($createimage,$front_new,0,0,0,0,$outwidth,$outheight,$source_imagex,$source_imagey);
			}
			if($image_type == 'image/jpeg'){
				if(imagejpeg($createimage,$mvdir.$image,100))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			if($image_type == 'image/png')
			{
				if(imagepng($createimage,$mvdir.$image,9))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			if($image_type == 'image/gif')
			{
				if(imagegif($createimage,$mvdir.$image))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		public static function dimension($image,$image_type,$width,$height,$dir,$mvdir)
		{
			list($source_imagex,$source_imagey) = getimagesize($dir.$image);
			if($image_type == 'image/jpeg')
			{
				$front_new = @imagecreatefromjpeg($dir.$image);
			}
			if($image_type == 'image/png')
			{
				$front_new = @imagecreatefromstring(file_get_contents(($dir.$image)));
			}
			if($image_type == 'image/gif')
			{
				$front_new = @imagecreatefromgif($dir.$image);
			}
			$createimage = imagecreatetruecolor($width,$height);
			imagealphablending($createimage, false);
			imagesavealpha($createimage,true);
			$transparent = imagecolorallocatealpha($createimage, 255, 255, 255, 127);
			imagefilledrectangle($createimage, 0, 0, $width, $height, $transparent);
			imagecopyresampled($createimage,$front_new,0,0,0,0,$width,$height,$source_imagex,$source_imagey);
			if($image_type == 'image/jpeg')
			{
				if(imagejpeg($createimage,$mvdir.$image,100))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			if($image_type == 'image/png')
			{
				if(imagepng($createimage,$mvdir.$image,9))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			if($image_type == 'image/gif')
			{
				if(imagegif($createimage,$mvdir.$image))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		public static function square($image,$image_type,$size,$dir,$mvdir)
		{
			list($width,$height) = getimagesize($dir.$image);
			if($image_type == 'image/jpeg')
			{
				$front_new = @imagecreatefromstring(file_get_contents(($dir.$image)));
			}
			else if($image_type == 'image/png')
			{
				$front_new = @imagecreatefromstring(file_get_contents(($dir.$image)));
			}
			else if($image_type == 'image/gif')
			{
				$front_new = @imagecreatefromgif($dir.$image);
			}
			else
			{
				@imagecreatefromstring(file_get_contents(($dir.$image)));
			}
			if ($width > $height)
			{
				$y = 0;
				$x = ($width - $height) / 2;
				$smallestSide = $height;
			}
			else
			{
				$x = 0;
				$y = ($height - $width) / 2;
				$smallestSide = $width;
			}
			 $createimage = imagecreatetruecolor($size,$size);
			 imagealphablending($createimage, false);
			 imagesavealpha($createimage,true);
			 $transparent = imagecolorallocatealpha($createimage, 255, 255, 255, 127);
			 imagefilledrectangle($createimage, 0, 0, $size, $size, $transparent);
			 imagecopyresampled($createimage,$front_new,0,0,0,0,$size,$size,$smallestSide,$smallestSide);
			if($image_type == 'image/jpeg')
			{
				if(imagejpeg($createimage,$mvdir.$image,100))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			if($image_type == 'image/png')
			{
				if(imagepng($createimage,$mvdir.$image,9))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			if($image_type == 'image/gif')
			{
				if(imagegif($createimage,$mvdir.$image))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
	}
?>