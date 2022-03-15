<?php  
return [
	[
		'label' => 'Dashboard',
		'route' => '',
		'icon' => 'fa-home'
	],
	[
		'label' => 'Phòng ban',
		'route' => 'department',
		'icon' => 'fa-table',
		'items' => [
			[
				'label' => 'Thêm mới',
				'route' => 'department.create'
            ],
            [
				'label' => 'Danh sách',
				'route' => 'department.index'
			]
		]
	],
	[
		'label' => 'Nhân viên',
		'route' => 'employee',
		'icon' => 'fa-lightbulb',
		'items' => [
			[
				'label' => 'Thêm mới',
				'route' => 'employee.create'
            ],
            [
				'label' => 'Danh sách',
				'route' => 'employee.index'
			]
		]
	]
];
?>