<?php

class Helper {

    public static function slugify($str) {
		// replace non letter or digits by -
		if($str !== mb_convert_encoding( mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32') )
		$str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
		$str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
		$str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
		$str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
		$str = preg_replace(array('`[^a-z0-9]`i','`[-]+`'), '-', $str);
		$str = strtolower( trim($str, '-') );

		if (empty($str))
		{
			return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
		}
		   
		return $str;
	}

	public static function uploadImage($image, $folder, $filename = '', $type = 'upload'){


		if($folder == 'images'){
			$month_year = date('FY').'/';
		} else {
			$month_year = '';
		}

		$upload_folder = 'content/uploads/' . $folder . '/'.$month_year;

		if ( getimagesize($image) ){

			// if the folder doesn't exist then create it.
			if (!file_exists($upload_folder)) {
				mkdir($upload_folder, 0777, true);
			}

			if($type =='upload'){

				$filename =  $image->getClientOriginalName();

				// if the file exists give it a unique name
				while (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename;
				}


				$uploadSuccess = $image->move($upload_folder, $filename);

				if(strpos($filename, '.gif') > 0){
					$new_filename = str_replace('.gif', '-animation.gif', $filename);
					copy($upload_folder . $filename, $upload_folder . $new_filename);
				}

			} else if($type = 'url'){
				
				$file = file_get_contents($image);

				if(strpos($image, '.gif') > 0){
					$extension = '-animation.gif';
				} else {
					$extension = '.jpg';
				}

				$filename = $filename . $extension;

				if (file_exists($upload_folder.$filename)) {
					$filename =  uniqid() . '-' . $filename . $extension;
				}

			    if(strpos($image, '.gif') > 0){
					file_put_contents($upload_folder.$filename, $file);
					$filename = str_replace('-animation.gif', '.gif', $filename);
				}

			    file_put_contents($upload_folder.$filename, $file);

			}
		   
		
			$settings = Setting::first();

			$img = Image::make($upload_folder . $filename);

			if($folder == 'images'){
				$img->resize(700, null, true);
			} else if($folder == 'avatars'){
				$img->resize(200, 200, false);
			}

			if($settings->enable_watermark && $folder == 'images'){
				$img->insert($settings->watermark_image, $settings->watermark_offset_x, $settings->watermark_offset_y, $settings->watermark_position);
				$img->save($upload_folder . $filename);
			} else {
				$img->save($upload_folder . $filename);
			}

			return $month_year . '/' . $filename;

		} else {
			return false;
		}
	}

}