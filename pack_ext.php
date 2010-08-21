<?php

$vars = array (
    '###DATE###'        => 'August 2010',
    '###VERSION###'     => '0.9.7',
    '###DESC###'        => 'Mobile Joomla!',
    '###AUTHOR###'      => 'Mobile Joomla!',
    '###COPYRIGHT###'   => '(C) 2008-2010 MobileJoomla!',
    '###EMAIL###'       => 'hello@mobilejoomla.com',
    '###URL###'         => 'http://www.mobilejoomla.com',
    '###LICENSE###'     => 'http://www.gnu.org/licenses/gpl-2.0.htm GNU/GPL'
);

function scan_files ($dir)
{
    global $vars;

    $files = scandir ($dir);

    foreach ($files as $file)
    {
        $path = $dir . $file;
        $ext = substr ($file, -4);

        if ($file == '.' || $file == '..')
            continue;

        if (is_dir ($path))
            scan_files ($path . '/');

        if ($ext == '.php' || $ext == '.xml' || $ext == '.xm_')
        {
            file_put_contents ($path, str_replace (array_keys ($vars), array_values ($vars), file_get_contents ($path)));
        }
    }
}

$r = isset($_GET['r'])  ? (int) $_GET['r'] : FALSE ;
$rcommand = $r ? '-r'.$r  : '';

$output = '';
if("/home/bmllnet/public_html/mj" == exec('pwd'))
{
    $path = 'trunk/mj';
    $mjfile = 'mj.zip';

    if (isset ($_GET['path']))
    {
        $path = preg_replace ('/[^0-9a-zA-Z_\-\/\.]/', '', $_GET['path']);
        $parts = explode ('/', $path);
        $mjfile = str_replace ('.', '_', $parts[count ($parts) - 1]) . '.zip';
    }

    //be careful!!
    $output .= exec('rm -rf /home/bmllnet/public_html/mj/package/*');
    $output .= exec('svn export --force --non-interactive '.$rcommand.' file:///home/bmllnet/svn/' . $path . '  ./package');
    
    if (isset ($_GET['build']))
    {
        scan_files ('package/');
    }
    
    chdir ('package');
    $output .= exec('zip -r9 -b . '. $mjfile .' *');

    if(!is_file($mjfile))
    {
       die("file not found: $mjfile");
    }
    else
    {
       header("Cache-Control: public");
       header("Content-Description: File Transfer");
       header("Content-Disposition: attachment; filename=$mjfile");
       header("Content-Type: application/zip");
       header("Content-Transfer-Encoding: binary");
       readfile($mjfile);
       
       unlink($mjfile);
    }
 }
 else
 {
    echo 'sth was wrong';
 }
 
?>
