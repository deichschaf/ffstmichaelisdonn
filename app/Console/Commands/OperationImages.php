<?php

namespace App\Console\Commands;

use App\Http\Traits\SystemToolsTrait;
use Exception;
use Illuminate\Console\Command;
use RuntimeException;

class OperationImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'operation:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [];
        $data['headline'] = strtoupper('Bevölkerungswarnung');
        $data['footer'] = 'Technikbereitstellung Amtshilfe';
        $data['footer_2'] = 'Wir stellen lediglich das Fahrzeug ohne Personal.';
        $this->buildImage($data);
    }

    private function buildImage($data = [])
    {
        $imagename = 'einsatz_' . date('YMDHi') . '.jpg';
        $cmd = '';
        try {
            $public_source = public_path() . DIRECTORY_SEPARATOR . '__system_image' . DIRECTORY_SEPARATOR;
            $public_store = public_path() . DIRECTORY_SEPARATOR . 'generate_images' . DIRECTORY_SEPARATOR;
            $tmp_folder = storage_path() . DIRECTORY_SEPARATOR . 'generate_images' . DIRECTORY_SEPARATOR;
            if (!is_dir($tmp_folder)) {
                if (!mkdir($tmp_folder, 0777) && !is_dir($tmp_folder)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $tmp_folder));
                }
            }
            if (!is_dir($public_store)) {
                if (!mkdir($public_store, 0777) && !is_dir($public_store)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $public_store));
                }
            }
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $tmp_trenner_top = time() . rand() . '.png';
            $cmd = 'convert -size ' . $this->Config('Image_Maxsize') . 'x90 xc:red -fill red -stroke red ' . $tmp_folder . $tmp_trenner_top;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $tmp_trenner_bottom = time() . rand() . '.png';
            $cmd = 'convert -size ' . $this->Config('Image_Maxsize') . 'x139 xc:red -fill red -stroke red ' . $tmp_folder . $tmp_trenner_bottom;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $temp_overlay_1 = time() . rand() . '.jpg';
            $cmd = 'composite -gravity NorthWest ' . $tmp_folder . $tmp_trenner_top . ' ' . $public_source . 'background.jpg ' . $tmp_folder . $temp_overlay_1;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }


        try {
            $temp_overlay_2 = time() . rand() . '.jpg';
            $cmd = 'composite -gravity SouthWest ' . $tmp_folder . $tmp_trenner_bottom . ' ' . $tmp_folder . $temp_overlay_1 . ' ' . $tmp_folder . $temp_overlay_2;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $temp_file = time() . rand() . '.jpg';
            $cmd = 'composite -gravity NorthEast ' . $public_source . 'Blaulicht.png ' . $tmp_folder . $temp_overlay_2 . ' ' . $tmp_folder . $temp_file;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $temp_file_2 = time() . rand() . '.jpg';
            $cmd = 'composite -gravity NorthWest ' . $public_source . 'Blaulicht.png ' . $tmp_folder . $temp_file . ' ' . $tmp_folder . $temp_file_2;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $maintext = time() . rand() . '.gif';
            $cmd = 'convert -fill black  -font ' . $this->Config('Font') . ' -pointsize ' . $this->Config('Font_Size_Text') . ' -size 320x   caption:"This is a very long caption line." ' . $tmp_folder . $maintext;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $temp_file_3 = time() . rand() . '.jpg';
            $cmd = 'composite -gravity West ' . $tmp_folder . $maintext . ' ' . $tmp_folder . $temp_file_2 . ' ' . $tmp_folder . $temp_file_3;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $footer = time() . rand() . '.png';
            $cmd = 'convert -fill black  -font ' . $this->Config('Font') . ' -pointsize ' . $this->Config('Font_Size_Footer') . ' -size ' . $this->Config('Image_Maxsize') . 'x   caption:"' . $data['footer'] . '" ' . $tmp_folder . $footer;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $footer_2 = time() . rand() . '.png';
            $cmd = 'convert -fill black  -font ' . $this->Config('Font') . ' -pointsize ' . $this->Config('Font_Size_Footer') . ' -size ' . $this->Config('Image_Maxsize') . 'x   caption:"' . $data['footer_2'] . '" ' . $tmp_folder . $footer_2;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $temp_file_4 = time() . rand() . '.jpg';
            $cmd = 'composite -gravity South ' . $tmp_folder . $footer . ' ' . $tmp_folder . $temp_file_3 . ' ' . $tmp_folder . $temp_file_4;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            $temp_file_5 = time() . rand() . '.jpg';
            $cmd = 'composite -gravity South ' . $tmp_folder . $footer_2 . ' ' . $tmp_folder . $temp_file_4 . ' ' . $tmp_folder . $temp_file_5;
            $out = SystemToolsTrait::Console($cmd);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        try {
            unlink($tmp_folder . $tmp_trenner_top);
            unlink($tmp_folder . $tmp_trenner_bottom);
            unlink($tmp_folder . $temp_overlay_1);
            unlink($tmp_folder . $temp_overlay_2);
            unlink($tmp_folder . $temp_file);
            unlink($tmp_folder . $temp_file_2);
            unlink($tmp_folder . $temp_file_3);
            unlink($tmp_folder . $temp_file_4);
            unlink($tmp_folder . $footer);
            unlink($tmp_folder . $footer_2);
            unlink($tmp_folder . $maintext);
            #unlink($tmp_folder.$temp_file_2);
            #unlink($temp_file_2);
        } catch (Exception $e) {
            echo '<pre>';
            echo __LINE__ . ': ' . $e->getCode() . ' -> ' . $e->getMessage();
            echo '</pre>';
            exit();
        }

        return $imagename;
    }

    private function Config($type = 'Font')
    {
        $config = [];
        $config['Font'] = 'Helvetica';
        $config['Font_Size_Headline'] = 50;
        $config['Font_Size_Text'] = 25;
        $config['Font_Size_Footer'] = 25;
        $config['Image_Maxsize'] = '' . $this->Config('Image_Maxsize') . '';
        $config['headline_size'] = 120;
        return $config[$type];
    }
}
