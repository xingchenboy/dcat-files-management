<?php

namespace Xingchenboy\DcatFilesManagement\Http\Controllers;

use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Xingchenboy\DcatFilesManagement\DcatFilesManagementServiceProvider;

class DcatFilesManagementController extends Controller
{
    public function index(Content $content,Request $request)
    {
        $path = $request->get('path', '/');
        $view = $request->get('view', 'list');
        $management = new MediaManagement($path);

        return $content
            ->title('文件管理')
            ->description('文件列表')
            ->body(Admin::view("xingchenboy.dcat-files-management::$view", [
                'list'   => $management->ls(),
                'nav'    => $management->navigation(),
                'url'    => $management->urls(),
            ]));
    }

    public function download(Request $request)
    {
        $file = $request->get('file');

        $management = new MediaManagement($file);

        return $management->download();
    }

    public function upload(Request $request)
    {
        $files = $request->file('files');
        $dir = $request->get('dir', '/');

        $management = new MediaManagement($dir);

        try {
            if ($management->upload($files)) {
                admin_toastr(DcatFilesManagementServiceProvider::trans('media.upload_succeeded'));
            }
        } catch (\Exception $e) {
            admin_toastr($e->getMessage(), 'error');
        }

        return back();
    }

    public function delete(Request $request)
    {
        $files = $request->get('files');

        $management = new MediaManagement();

        try {
            if ($management->delete($files)) {
                return response()->json([
                    'status'  => true,
                    'message' => DcatFilesManagementServiceProvider::trans('media.delete_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function move(Request $request)
    {
        $path = $request->get('path');
        $new = $request->get('new');

        $management = new MediaManagement($path);

        try {
            if ($management->move($new)) {
                return response()->json([
                    'status'  => true,
                    'message' => DcatFilesManagementServiceProvider::trans('media.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function newFolder(Request $request)
    {
        $dir = $request->get('dir');
        $name = $request->get('name');

        $management = new MediaManagement($dir);

        try {
            if ($management->newFolder($name)) {
                return response()->json([
                    'status'  => true,
                    'message' => DcatFilesManagementServiceProvider::trans('media.create_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
