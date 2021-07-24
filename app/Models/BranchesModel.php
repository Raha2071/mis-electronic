<?php
namespace App\Models;

use CodeIgniter\Model;

class BranchesModel extends Model
{
	protected $table = "branches";
	protected $allowedFields = ["name","email","phone","location","operator","status"];
	protected $useTimestamps = true;
}
