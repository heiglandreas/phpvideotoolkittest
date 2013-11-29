<?php
/**
 * Copyright (c)2013-2013 heiglandreas
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category 
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2013-2013 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     29.11.13
 * @link      https://github.com/heiglandreas/
 */
require_once 'vendor/autoload.php';


$config = include 'config.php';

$testfile = 'BigBuckBunny_320x180.mp4';
if (! file_exists($testfile)) {
    $url = "http://download.blender.org/peach/bigbuckbunny_movies/BigBuckBunny_320x180.mp4";
    set_time_limit(0);
    $fp = fopen (dirname(__FILE__) . '/' . $testfile, 'w+');//This is the file where we save the    information
    $ch = curl_init(str_replace(" ","%20",$url));//Here is the file we are downloading, replace spaces with %20
    curl_setopt($ch, CURLOPT_TIMEOUT, 50);
    curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch); // get curl response
    curl_close($ch);
    fclose($fp);
}

$ffmpeg = new PHPVideoToolkit\FfmpegParser($config);
echo sprintf('ffmpeg is available: %s', $ffmpeg->isAvailable()?'true':false);
echo sprintf('ffmpeg_version is %s', $ffmpeg->getVersion()['version']);


$parser = new PHPVideoToolkit\MediaParser($config);
$data = $parser->getFileInformation($testfile);
echo '<pre>'.print_r($data, true).'</pre>';
