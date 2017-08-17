<?php

namespace Supernano\Scripts;

use Composer\Script\Event;

class Skeleton
{

    const GIT_PATH = './.git';
    const PATH = './skeleton';
    const TEMP = './skeleton.temp';
    const VENDOR = './vendor';
    const SCRIPTS = './scripts';
    const DIR_CHMOD = 0775;
    const FILE_CHMOD = 0664;

    public static function makeTemp(Event $event)
    {
        self::cleanTemp();
        @mkdir(self::PATH);
        @chmod(self::PATH, self::DIR_CHMOD);
        $replaces = self::getReplaces($event);
        self::copyWithReplace(self::PATH, self::TEMP, $replaces);
    }


    public static function cleanAll()
    {
        self::cleanTemp();
        self::cleanPath();
        self::cleanGit();
        @unlink('composer.lock');
        self::removeDirectory(self::VENDOR);
        self::removeDirectory(self::SCRIPTS);
    }


    public static function showMessage(Event $event)
    {
        $event->getIO()->write("\n\nDone.\n");
        $event->getIO()->write("
Next steps:
 * Add dev domain to c:\\Windows\\System32\\drivers\\etc\\hosts or /etc/hosts
 * Add VirtualHost to Apache configuration or server to Nginx
 * Check composer.json
 * Run 'composer update'

");
    }


    private static function getReplaces(Event $event)
    {
        $replaces = [
            '{{projectName}}' => 'website',
            '{{projectCode}}' => 'website',
        ];

        $event->getIO()->write('Installing new project "'.$event->getComposer()->getPackage()->getName().'"...' . "\n");
        $event->getIO()->write("Basic configuration.\n\n");

        $code = basename(getcwd());
        $replaces['{{projectCode}}'] = $event->getIO()->ask("Site code, unique alphanumeric code [".$code."]: ", $code);

        $code = $replaces['{{projectCode}}'];
        $replaces['{{projectName}}'] = $event->getIO()->ask("Site name, human readable text [".$code." web site]: ", $code." web site");

        $url = "http://www.".$code.".com";
        $replaces['{{siteURL}}'] = $event->getIO()->ask("Site URL [".$url."]: ", $url);

        $extendedReplaces = $replaces;
        foreach ($replaces as $name => $value) {
            $extendedReplaces[strtr($name, ['{{' => '{{ ', '}}' => ' }}'])] = $value;
        }
        return $extendedReplaces;
    }


    private static function copyWithReplace($src, $dst, $replaces)
    {
        $dir = opendir($src);
        @mkdir($dst);
        @chmod($dst, self::DIR_CHMOD);
        while (false !== ($file = readdir($dir))) {
            if ($file != '.' && $file != '..') {
                if (is_dir($src . '/' . $file)) {
                    self::copyWithReplace($src . '/' . $file, $dst . '/' . $file, $replaces);
                } else {
                    file_put_contents(
                        $dst . '/' . $file,
                        strtr(
                            file_get_contents($src . '/' . $file),
                            $replaces
                        )
                    );
                    @chmod($dst . '/' . $file, self::FILE_CHMOD);
                }
            }
        }
        closedir($dir);
    }


    public static function moveTemp(Event $event)
    {

        $dest = realpath(__DIR__ . '/..');

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(self::TEMP, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($files as $file) {
            if ($file->isDir()){
                $dirName = $dest . DIRECTORY_SEPARATOR . $files->getSubPathName();
                $event->getIO()->write("Directory: " . $dirName);
                @mkdir($dirName, self::DIR_CHMOD);
            } else {
                $fileName = $dest . DIRECTORY_SEPARATOR . $files->getSubPathName();
                $event->getIO()->write('  File: ' . $file->getRealPath() . ' -> ' .$fileName);
                @copy($file, $fileName);
                @chmod($fileName, self::FILE_CHMOD);
            }
        }

    }


    public static function cleanTemp()
    {
        self::removeDirectory(self::TEMP);
    }


    public static function cleanPath()
    {
        self::removeDirectory(self::PATH);
    }


    public static function cleanGit()
    {
        self::removeDirectory(self::GIT_PATH);
    }


    private static function removeDirectory($dir)
    {
        if (is_dir($dir)) {
            $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($dir);
        } elseif (file_exists($dir)) {
            unlink($dir);
        }
    }
}
