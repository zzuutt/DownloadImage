# DownloadImage

Download directly the product image

specify the ID of the image in the link  `image/download/{$ID}`

``
{loop name="picture_info" type="image" product="{$ID}" width="200" height="200" resize_mode="borders"}
  <a href="image/download/{$ID}" class="btn btn-default" role="button">{intl l="Download"}</a>
{/loop}
``