<?php

namespace App\Entities;

use CodeIgniter\Entity;

class ApplicationStage extends Entity
{
	protected $datamap = [];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
	const ORG_APPROVAL = 'Organisation Approval';
	const ALLOW_PROCEED = 'Allow to Proceed';
	const PAID = 'Paid';
}
