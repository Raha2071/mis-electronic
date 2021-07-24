<?php
namespace App\Models;

use CodeIgniter\Model;

class InvoicesModel extends Model
{
	protected $table = "invoices";
	protected $allowedFields = ["clientId","status","operator"];
	protected $useTimestamps = true;
}
