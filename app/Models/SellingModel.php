<?php
namespace App\Models;

use CodeIgniter\Model;

class SellingModel extends Model
{
	protected $table = "sellinginfo";
	protected $allowedFields = ["invoiceId","productId","quantity","unitPrice","amount","status"];
	protected $useTimestamps = false;
}
