<?php

namespace Xingchenboy\DcatFilesManagement;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class DcatFilesManagementServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/index.js',
    ];
	protected $css = [
		'css/index.css',
	];

	public function register()
	{
		//
	}

	public function init()
	{
		parent::init();

	}
}
