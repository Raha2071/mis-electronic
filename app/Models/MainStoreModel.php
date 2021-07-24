<?php
namespace App\Models;

use CodeIgniter\Model;

class MainStoreModel extends Model
{
	protected $table = "mainstore";
	protected $allowedFields = ["name","type","serialNumber","model","categoryId","reduction","quantity","usedQuantity","purchasedPrice","sellingPrice","description","operator"];
	protected $useTimestamps = true;
}
