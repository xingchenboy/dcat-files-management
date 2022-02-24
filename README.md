# Dcat-admin-extension 文件管理

## 环境
 - PHP >= 7.1.0
 - Dcat-admin ^2.0


## 安装

### composer 安装

```
composer require xingchenboy/dcat-files-management
```

### 安装扩展

在 `开发工具->扩展` 安装本扩展

### 设置路由
`use Illuminate\Support\Facades\Route;`

`Route::get('media', [DcatFilesManagementController::class, 'index'])->name('media-index');`

`Route::get('media/download', [DcatFilesManagementController::class, 'download'])->name('media-download');`

`Route::delete('media/delete',  [DcatFilesManagementController::class, 'delete'])->name('media-delete');`

`Route::put('media/move',  [DcatFilesManagementController::class, 'move'])->name('media-move');`

`Route::post('media/upload',  [DcatFilesManagementController::class, 'upload'])->name('media-upload');`

`Route::post('media/folder',  [DcatFilesManagementController::class, 'newFolder'])->name('media-new-folder');`

### 访问
在 `菜单` 里添加 路径为 media 进行访问

## 开源协议

*  本扩展遵循 `Apache2` 开源协议发布，提供个人及商业免费使用。 


## 版权

*  该系统所属版权归 xingchenboy(https://github.com/xingchenboy) 所有。
