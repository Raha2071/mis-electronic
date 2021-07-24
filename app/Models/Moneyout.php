<?php
namespace App\Models;

use CodeIgniter\Model;

class Moneyout extends Model
{
	protected $table = "moneyout";
	protected $allowedFields = ["moneyoutid","amount","motif","operator","created_at"];
	protected $useTimestamps = true;
}
