<?php
namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
	protected $table = "clients";
	protected $allowedFields = ["name","phone","email","address","street","status","activeInvoice","created_by"];
	protected $useTimestamps = true;
}
