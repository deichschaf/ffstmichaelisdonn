<?php

/**
 * Created by PhpStorm.
 * User: Jörg-Marten Hoffmann
 * Date: 15.04.2015
 * Time: 06:55
 */

namespace App\Http\Controllers;

use App\Http\Models\CMSHeadImages;
use App\Http\Models\Layout;
use App\Http\Traits\Image;
use App\Http\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\SSH;

/**
 * Class HeadImagesController
 * @package App\Http\Controllers
 */
class HeadImagesController extends GroundController
{
    /**
     * @var string[]
     */
    private $filenames = ['-x-high.png', '-high.png', '-medium.png', '-small.png'];
    /**
     * @var array
     */
    private $size = [];
    /**
     * @var string
     */
    private $path = 'grfx' . DIRECTORY_SEPARATOR . 'rotation' . DIRECTORY_SEPARATOR;

    /**
     * @return string
     */
    public function admin_head_show()
    {
        $data = [];
        $data['title'] = '';
        $ALL = CMSHeadImages::orderBy('pos', 'ASC')->get();
        $data['content'] = $ALL;
        $content = view('headimages.admin_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @return string
     */
    public function adminShow()
    {
        $data = [];
        $data['title'] = '';
        $ALL = CMSHeadImages::orderBy('pos', 'ASC')->get();
        $data['content'] = $ALL;
        $content = view('headimages.admin_overview')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @return string
     */
    public function adminAdd()
    {
        $data = [];
        $data['title'] = '';
        $data['small'] = 0;
        $data['medium'] = 0;
        $data['high'] = 0;
        $data['x-high'] = 0;
        $data['filename'] = '';
        $data['image'] = '';
        $data['id'] = '';
        $content =  view('headimages.adminEdit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function adminEdit($id)
    {
        $data = [];
        $data['title'] = '';
        $data['small'] = 0;
        $data['medium'] = 0;
        $data['high'] = 0;
        $data['x-high'] = 0;
        $data['filename'] = '';
        $data['image'] = '';
        $data['id'] = '';
        $Image = CMSHeadImages::where('id', '=', $id)->get();
        if (count($Image) == 0) {
            return redirect('headimages.overview')->with('error', 'nofound');
        }
        $Image->each(function ($i) use (&$data) {
            $data['filename'] = $i->filename;

            if (is_file(public_path($this->path) . $i->small)) {
                $data['small'] = 1;
                $data['image'] = $i->small;
            }
            if (is_file(public_path($this->path) . $i->medium)) {
                $data['medium'] = 1;
            }
            if (is_file(public_path($this->path) . $i->high)) {
                $data['high'] = 1;
            }
            if (is_file(public_path($this->path) . $i->x_high)) {
                $data['x-high'] = 1;
            }
            $data['id'] = $i->id;
        });
        $content =  view('headimages.adminEdit')->with('data', $data)->render();
        $l = new Layout();
        return $l->layout_admin_content($content, $data['title'], false, false);
    }

    /**
     *
     */
    public function adminDelete()
    {
    }

    /**
     *
     */
    public function adminDeletePost()
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploader(Request $request)
    {
        // getting all of the post data
        $file = array('image' => $request->file('image'));
        // setting up rules
        $validator = ValidationController::ImageValidation($file);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return response()->json(['status' => 'error', 'message' => $validator]);
            //return Redirect::to('upload')->withInput()->withErrors($validator);
        } else {
            // checking file is valid.
            if ($request->file('image')->isValid()) {
                $config = [];
                $data = ImageTrait::UploaderImage('/uploads/', 'image', $config, $request);

                return response()->json(['status' => 'success', 'message' => 'Upload erfolgreich']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Datei ist nicht valide!']);
            }
        }
    }

    /**
     * check beim speichern ob es sich um ein Bild handelt und ob es sich um upload handelt oder speichern von
     * Zusatzinformationen.
     * Speichern und Upload über Ajax!
     */
    public function adminSave(Request $request)
    {
        $data = ImageTrait::UploaderImage('/tmp/', 'image', [], $request);
        $data = $this->generate($data['image']);
        $save = new CMSHeadImages();
        $save->x_high = $data['x-high'];
        $save->high = $data['high'];
        $save->medium = $data['medium'];
        $save->small = $data['small'];
        $save->active = '1';
        $save->save();
        $this->clearPageCache();
        return redirect()->route('admin.headimages');
    }

    /**
     * generate with the imagemagick method the correct rotaton
     */
    private function generate($filename)
    {
        $data = [];
        $impath = env('IMAGEMAGICK_PATH', '');
        $newpath = public_path($this->path);
        $filetype = $this->getfiletype($filename);
        $generatefilename = date('YmdHis') . rand(0, 9999);
        $tempfile = public_path('tmp') . DIRECTORY_SEPARATOR . $filename;

        /***
         * 320 small
         * 640 medium
         * 720 high
         * 1080 x-high
         */

        $small = 320 * 2;
        $medium = 640 * 2;
        $high = 720 * 2;
        $x_high = 1080 * 2;

        $data['x-high'] = '';
        $newfile = $generatefilename . '-x-high.' . $filetype;
        $make = $this->makeImage($tempfile, $newfile, $x_high);
        if ($make === true) {
            $data['x-high'] = $newfile;
        }
        $data['high'] = '';
        $newfile = $generatefilename . '-high.' . $filetype;
        $make = $this->makeImage($tempfile, $newfile, $high);
        if ($make === true) {
            $data['high'] = $newfile;
        }
        $data['medium'] = '';
        $newfile = $generatefilename . '-medium.' . $filetype;
        $make = $this->makeImage($tempfile, $newfile, $medium);
        if ($make === true) {
            $data['medium'] = $newfile;
        }
        $data['small'] = '';
        $newfile = $generatefilename . '-small.' . $filetype;
        $make = $this->makeImage($tempfile, $newfile, $small);
        if ($make === true) {
            $data['small'] = $newfile;
        }
        unlink($tempfile);

        return $data;
    }
    /**
     * @param $tempfile
     * @param $new
     * @param $high
     * @param int $quality
     * @return bool
     */
    private function makeImage($tempfile, $new, $high, $quality = 80): bool
    {
        $impath = env('IMAGEMAGICK_PATH', '');
        $newfile = public_path($this->path) . $new;
        $cmd = $impath . 'convert "' . $tempfile . '" -resize ' . $high . 'x -quality ' . $quality . ' "' . $newfile . '"';
        exec($cmd, $output, $return);

        if (!is_file($newfile)) {
            return false;
        }
        return true;
    }
}
