<?php
/*************************************************************************************/
/*      Plugin for Thelia 2                                                          */
/*                                                                                   */
/*      Copyright (c) Zzuutt                                                         */
/*      email : zzuutt34@free.fr                                                     */
/*      web :                                                                        */
/*                                                                                   */
/*************************************************************************************/
namespace DownloadImage\Controller;

use DownloadImage\DownloadImage;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Model\ProductImage;
use Thelia\Model\ProductImageQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Exception\InvalidArgumentException;
use Thelia\Core\Translation\Translator;
use Thelia\Log\Tlog;

/**
 * Class ImageController
 * @author zzuutt34 <zzuutt34@free.fr>
 */
class ImageController extends BaseFrontController
{

    public function downloadImage($image_id)
    {
        $image = ProductImageQuery::create()->findPk($image_id);
        if($image) {
          Tlog::getInstance()->debug("Download Image id:".$image_id." file:".$image);
          $file = $image->getFile();
          switch(strrchr(basename($file), "." )) {
            case ".png": $type = "image/png"; break;
            case ".gif": $type = "image/gif"; break;
            case ".JPG": $type = "image/jpeg"; break;
            case ".jpg": $type = "image/jpeg"; break;
            default: $type = ""; break;
          }
          Tlog::getInstance()->debug("Download Image file:".$file." type:".$type);
          if($type!=""){
            $source_filepath = sprintf(
                "%s%s/%s/%s",
                THELIA_ROOT,
                ConfigQuery::read('images_library_path', 'local'.DS.'media'.DS.'images'),
                "product",
                $file
            );
          Tlog::getInstance()->debug("Download Image source_filepath:".$source_filepath);
          Tlog::getInstance()->debug("Download Image filesize:".filesize($source_filepath));
          
          header("Content-disposition: attachment; filename=\"".$file."\"");
          header("Content-Type: $type" );
          header("Content-Transfer-Encoding: binary" );
          header("Content-Length: ".filesize($source_filepath));
          header("Pragma: no-cache" );
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public" );
          header("Expires: 0" );
          readfile($source_filepath);
          }
          else {
            throw new InvalidArgumentException(
                Translator::getInstance()->trans("Reference not found", [], DownloadImage::MESSAGE_DOMAIN)
            );
          
          }
        }
    }

}
