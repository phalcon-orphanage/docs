<h1>Class <strong>Phalcon\\Image\\Adapter\\Gd</strong></h1>

<p><em>extends</em> abstract class <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p><em>implements</em> <a href="/en/3.2/api/Phalcon_Image_AdapterInterface">Phalcon\Image\AdapterInterface</a></p>

<p><a href="https://github.com/phalcon/cphalcon/blob/master/phalcon/image/adapter/gd.zep" class="btn btn-default btn-sm" mark="crwd-mark">Source on GitHub</a></p>

<h2>Methods</h2>

<p>public static  <strong>check</strong> ()</p>

<p>...</p>

<p>public  <strong>__construct</strong> (<em>mixed</em> $file, [<em>mixed</em> $width], [<em>mixed</em> $height])</p>

<p>...</p>

<p>protected  <strong>_resize</strong> (*mixed* $width, *mixed* $height)</p>

<p>...</p>

<p>protected  <strong>_crop</strong> (*mixed* $width, *mixed* $height, *mixed* $offsetX, *mixed* $offsetY)</p>

<p>...</p>

<p>protected  <strong>_rotate</strong> (*mixed* $degrees)</p>

<p>...</p>

<p>protected  <strong>_flip</strong> (*mixed* $direction)</p>

<p>...</p>

<p>protected  <strong>_sharpen</strong> (*mixed* $amount)</p>

<p>...</p>

<p>protected  <strong>_reflection</strong> (*mixed* $height, *mixed* $opacity, *mixed* $fadeIn)</p>

<p>...</p>

<p>protected  <strong>_watermark</strong> (<a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a> $watermark, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity)</p>

<p>...</p>

<p>protected  <strong>_text</strong> (*mixed* $text, *mixed* $offsetX, *mixed* $offsetY, *mixed* $opacity, *mixed* $r, *mixed* $g, *mixed* $b, *mixed* $size, *mixed* $fontfile)</p>

<p>...</p>

<p>protected  <strong>_mask</strong> (<a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a> $mask)</p>

<p>...</p>

<p>protected  <strong>_background</strong> (*mixed* $r, *mixed* $g, *mixed* $b, *mixed* $opacity)</p>

<p>...</p>

<p>protected  <strong>_blur</strong> (*mixed* $radius)</p>

<p>...</p>

<p>protected  <strong>_pixelate</strong> (*mixed* $amount)</p>

<p>...</p>

<p>protected  <strong>_save</strong> (*mixed* $file, *mixed* $quality)</p>

<p>...</p>

<p>protected  <strong>_render</strong> (*mixed* $ext, *mixed* $quality)</p>

<p>...</p>

<p>protected  <strong>_create</strong> (*mixed* $width, *mixed* $height)</p>

<p>...</p>

<p>public  <strong>__destruct</strong> ()</p>

<p>...</p>

<p>public  <strong>getImage</strong> () inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>...</p>

<p>public  <strong>getRealpath</strong> () inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>...</p>

<p>public  <strong>getWidth</strong> () inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Image width</p>

<p>public  <strong>getHeight</strong> () inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Image height</p>

<p>public  <strong>getType</strong> () inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Image type
Driver dependent</p>

<p>public  <strong>getMime</strong> () inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Image mime type</p>

<p>public  <strong>resize</strong> ([<em>mixed</em> $width], [<em>mixed</em> $height], [<em>mixed</em> $master]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Resize the image to the given size</p>

<p>public  <strong>liquidRescale</strong> (<em>mixed</em> $width, <em>mixed</em> $height, [<em>mixed</em> $deltaX], [<em>mixed</em> $rigidity]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>This method scales the images using liquid rescaling method. Only support Imagick</p>

<p>public  <strong>crop</strong> (<em>mixed</em> $width, <em>mixed</em> $height, [<em>mixed</em> $offsetX], [<em>mixed</em> $offsetY]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Crop an image to the given size</p>

<p>public  <strong>rotate</strong> (<em>mixed</em> $degrees) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Rotate the image by a given amount</p>

<p>public  <strong>flip</strong> (<em>mixed</em> $direction) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Flip the image along the horizontal or vertical axis</p>

<p>public  <strong>sharpen</strong> (<em>mixed</em> $amount) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Sharpen the image by a given amount</p>

<p>public  <strong>reflection</strong> (<em>mixed</em> $height, [<em>mixed</em> $opacity], [<em>mixed</em> $fadeIn]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Add a reflection to an image</p>

<p>public  <strong>watermark</strong> (<a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a> $watermark, [<em>mixed</em> $offsetX], [<em>mixed</em> $offsetY], [<em>mixed</em> $opacity]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Add a watermark to an image with the specified opacity</p>

<p>public  <strong>text</strong> (<em>mixed</em> $text, [<em>mixed</em> $offsetX], [<em>mixed</em> $offsetY], [<em>mixed</em> $opacity], [<em>mixed</em> $color], [<em>mixed</em> $size], [<em>mixed</em> $fontfile]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Add a text to an image with a specified opacity</p>

<p>public  <strong>mask</strong> (<a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a> $watermark) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Composite one image onto another</p>

<p>public  <strong>background</strong> (<em>mixed</em> $color, [<em>mixed</em> $opacity]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Set the background color of an image</p>

<p>public  <strong>blur</strong> (<em>mixed</em> $radius) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Blur image</p>

<p>public  <strong>pixelate</strong> (<em>mixed</em> $amount) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Pixelate image</p>

<p>public  <strong>save</strong> ([<em>mixed</em> $file], [<em>mixed</em> $quality]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Save the image</p>

<p>public  <strong>render</strong> ([<em>mixed</em> $ext], [<em>mixed</em> $quality]) inherited from <a href="/en/3.2/api/Phalcon_Image_Adapter">Phalcon\Image\Adapter</a></p>

<p>Render the image and return the binary string</p>
