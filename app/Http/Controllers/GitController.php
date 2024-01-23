<?php

namespace App\Http\Controllers;

/**
 * Class GitController
 * @package App\Http\Controllers
 */
class GitController extends GroundController
{
    /**
     *
     */
    public const MAJOR = 1;
    /**
     *
     */
    public const MINOR = 2;
    /**
     *
     */
    public const PATCH = 3;

    /**
     * @return array|string
     */
    public static function getStaticGit()
    {
        if (!function_exists('exec')) {
            return 'Git can not be read!';
        }
        $data = [];
        $data['self::getGitTag()'] = self::getGitTag();
        $data['self::getGitVersion()'] = self::getGitVersion();
        $data['self::getGitHead()'] = self::getGitHead();
        $data['self::getVersion()'] = self::getVersion();
        return $data;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public static function getStaticGitTag()
    {
        if (!function_exists('exec')) {
            return 'Git can not be read!';
        }
        $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

        $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
        $commitDate->setTimezone(new \DateTimeZone('Europe/Berlin'));

        return sprintf('v%s.%s.%s-dev.%s (%s)', self::MAJOR, self::MINOR, self::PATCH, $commitHash, $commitDate->format('Y-m-d H:i:s'));
    }

    /**
     * @return array|string
     */
    public static function getStaticGitVersion()
    {
        if (!function_exists('exec')) {
            return 'Git can not be read!';
        }
        exec('git describe --always', $version_mini_hash);
        exec('git rev-list HEAD | wc -l', $version_number);
        exec('git log -1', $line);
        $version['short'] = "v1." . trim($version_number[0]) . "." . $version_mini_hash[0];
        $version['full'] = "v1." . trim($version_number[0]) . ".$version_mini_hash[0] (" . str_replace('commit ', '', $line[0]) . ")";
        return $version;
    }

    /**
     * @return string
     */
    public static function getStaticGitHead()
    {
        if (!function_exists('file_get_contents')) {
            return 'Git can not be read!';
        }
        try {
            $filename = base_path() . '/.git/refs/heads/master';
            if (is_file($filename)) {
                $HEAD_hash = file_get_contents($filename);
            } else {
                $filename = base_path() . '/.git/refs/heads/main';
                if (is_file($filename)) {
                    $HEAD_hash = file_get_contents($filename);
                } else {
                    return 'Git can not be read!';
                }
            }
            // or branch x
        } catch (\Exception $e) {
            return 'Git can not be read!';
        }
        $files = glob(base_path() . '/.git/refs/tags/*');
        foreach (array_reverse($files) as $file) {
            $contents = file_get_contents($file);
            if ($HEAD_hash === $contents) {
                return 'Current tag is ' . basename($file);
            }
        }

        return 'No matching tag';
    }

    /**
     * @return false|string
     */
    public static function getStaticVersion()
    {
        if (!function_exists('exec')) {
            return 'Git can not be read!';
        }
        $hash = exec("git rev-list --tags --max-count=1");
        return exec("git describe --tags $hash");
    }

    public static function GitUploadByShellScript()
    {
        return exec("/bin/bash " . base_path() . DIRECTORY_SEPARATOR . "gitinstall.sh");
    }

    /***
    function execPrint($command) {
    $result = array();
    exec($command, $result);
    print("<pre>");
    foreach ($result as $line) {
    print($line . "\n");
    }
    print("</pre>");
    }
    // Print the exec output inside of a pre element
    execPrint("git pull https://user:password@bitbucket.org/user/repo.git master");
    execPrint("git status");
     */
}
