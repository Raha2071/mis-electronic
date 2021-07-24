<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{
	protected $table = "categories";
	protected $allowedFields = ["title","description","operator"];
	protected $useTimestamps = true;
}
