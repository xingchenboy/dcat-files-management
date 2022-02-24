<?php

namespace Xingchenboy\DcatFilesManagement;

use Dcat\Admin\Extend\ServiceProvider;

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
