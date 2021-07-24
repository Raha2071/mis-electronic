<?php namespace App\Controllers;

use App\Models\InvoicesModel;
use App\Models\SellingModel;
use App\Models\UserModel;
use App\Models\BranchesModel;
use App\Models\CategoriesModel;
use App\Models\MainStoreModel;
use App\Models\ClientModel;

class Home extends BaseController
{
	private $data = array();
	private $log_status = "Soma_logged_in";

	public function _preset()
	{
		$this->session->set("return_url", current_url());
		if ($this->session->get($this->log_status) == null) {
			header("location: " . base_url(''));
			die();
		} else if ($this->session->get('t_lock_status') != null) {
			header("location: " . base_url(''));
			die();
		}
	}

	public function dashboard()
	{
		$this->_preset();
		$data = array();
		$cMdl = new ClientModel();
		$eMdl = new UserModel();
		$bMdl = new BranchesModel();
		$pMdl = new MainStoreModel();
		$data['title'] = "Dashboard";
		$data['clients'] = $cMdl->select("count(id) as clients")->get()->getRowArray();
		$data['employees'] = $eMdl->select("count(id) as employees")->get()->getRowArray();
		$data['products'] = $pMdl->select("count(id) as products")->get()->getRowArray();
		// $data['branches'] = $bMdl->select("count(id) as branches")->get()->getRowArray();
		$data['items'] = $pMdl->select("id,name,purchasedPrice,sellingPrice,quantity,usedQuantity")
			->get()->getResultArray();
		$data['content'] = view("dashboard", $data);
		return view('layout', $data);
	}

	public function branches()
	{
		$this->_preset();
		$mdl = new BranchesModel();
		$data = array();
		$data['title'] = "branches-info";
		$data['branches'] = $mdl->select('*')->get()->getResultArray();
		$data['content'] = view("branches", $data);
		return view('layout', $data);
	}


	public function categories()
	{
		$this->_preset();
		$mdl = new CategoriesModel();
		$data = array();
		$data['title'] = "Categories";
		$data['branches'] = $mdl->select("categories.*,u.names as operator")
			->join("users u", "u.id=categories.operator")->get()->getResultArray();
		$data['content'] = view("categories", $data);
		return view('layout', $data);
	}

	public function employees()
	{
		$this->_preset();
		// $mdl = new BranchesModel();
		$eMdl = new UserModel();
		$data = array();
		$data['title'] = "Employees";
		// $data['branches'] = $mdl->select('*')->get()->getResultArray();
		// $data['employees'] = $eMdl->select('users.*,b.name as branche')->join("branches b", "users.brancheId=b.id", "LEFT")->get()->getResultArray();
		$data['employees']= $eMdl->select('users.*')->get()->getResultArray();
		$data['content'] = view("employees", $data);
		return view('layout', $data);
	}

	public function index()
	{
		$data = array();
		$data["email"] = $this->session->getFlashdata("email");
		$data["error"] = $this->session->getFlashdata("error");
		return view('login', $data);
	}

	public function logout($msg = null)
	{
		session_destroy();
		$this->session->setFlashdata("error", $msg);
		return redirect()->to(base_url(''));
	}

	function login_pro()
	{
		$model = new UserModel();
		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');
		$validation = \Config\Services::validation();
		$validation->setRule("email", 'email', 'trim|required');
		$validation->setRule("password", 'password', 'required|min_length[6]');
//		if (strtotime(date('d-m-Y')) >= strtotime($this->users)) {
//			return redirect()->to(base_url(""));
//		}
		if ($validation->run() !== FALSE) {
			$this->session->setFlashdata('email', $email);
			if ($this->request->getGet("type", true) == "ajax") {
				echo '{"type":"error","msg":"' . $validation->getError() . '"}';
			} else {
				$this->session->setFlashdata('error', $validation->getError());
				$this->session->setFlashdata('email', $email);
				echo "error";
				die();
				return redirect()->to(base_url(""));
			}
		} else {
			$result = $model->checkUser($email);
			$this->session->setFlashdata('email', $email);
			if ($result != null) {
				if (password_verify($password, $result->password)) {
					if ($result->status == 1 || $result->status == 2) {
						$data = array(
							'shop_name' => $result->names,
							'shop_email' => $result->email,
							'shop_id' => $result->id,
							'shop_privilege' => $result->privilege,
							'shop_status' => $result->status,
							$this->log_status => true
						);
						$this->session->set($data);
						$model->updateLogin($result->id);
						if ($this->request->getGet("type", true) == "ajax") {
							echo '{"type":"success","msg":"login done"}';
						} else {
							return redirect()->to(base_url('dashboard'));
						}
					} else {
						if ($this->request->getGet("type", true) == "ajax") {
							echo '{"type":"error","msg":"Account not active"}';
						} else {
							$this->session->setFlashdata('error', "Account not active");
							return redirect()->to(base_url(""));
						}
					}
				} else {
					if ($this->request->getGet("type", true) == "ajax") {
						echo '{"type":"error","msg":"Password not correct"}';
					} else {
						$this->session->setFlashdata('error', "Password not correct");
						return redirect()->to(base_url(""));
					}
				}
			} else {
				if ($this->request->getGet("type", true) == "ajax") {
					echo '{"type":"error","msg":"User not found"}';
				} else {
					$this->session->setFlashdata('error', "User not found");
					return redirect()->to(base_url(""));
				}
			}
		}
	}

	public function manipulateBranche()
	{
		$this->_preset();
		$id = $this->request->getPost("branchId");
		$name = $this->request->getPost("name");
		$email = $this->request->getPost("email");
		$phone = $this->request->getPost("phone");
		$location = $this->request->getPost("location");
		$Mdl = new BranchesModel();
		try {
			if ($id == "") {
				$Mdl->save(array(
					"name" => $name,
					"email" => $email,
					"phone" => $phone,
					"location" => $location,
					"status" => 1,
					"operator" => $this->session->get("shop_id"),
				));
			} else {
				$Mdl->save(array(
					"id" => $id,
					"name" => $name,
					"email" => $email,
					"phone" => $phone,
					"location" => $location,
				));
			}

			echo '{"success":"Saved"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function getBranch($id = null)
	{
		$mdl = new BranchesModel();
		$builder = $mdl->select("*")->where('id', $id);
		try {
			$data = $builder->get()->getRowArray();
			echo json_encode($data);
		} catch (\ErrorException $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function manipulateEmployees()
	{
		$this->_preset();
		$id = $this->request->getPost("employeeId");
		// $branch = $this->request->getPost("branch");
		$card = $this->request->getPost("identification");
		$name = $this->request->getPost("name");
		$email = $this->request->getPost("email");
		$phone = $this->request->getPost("phone");
		$address = $this->request->getPost("address");
		$role = $this->request->getPost("role");
		$Mdl = new UserModel();
		try {
			if ($id == "") {
				$Mdl->save(array(
					// "brancheId" => $branch,
					"names" => $name,
					"identification" => $card,
					"email" => $email,
					"phone" => $phone,
					"address" => $address,
					"password" => password_hash("123456", PASSWORD_DEFAULT),
					"privilege" => $role,
					"status" => 1,
					"operator" => $this->session->get("shop_id"),
				));
			} else {
				$Mdl->save(array(
					"id" => $id,
					// "brancheId" => $branch,
					"names" => $name,
					"identification" => $card,
					"email" => $email,
					"phone" => $phone,
					"address" => $address,
					"privilege" => $role,
				));
			}

			echo '{"success":"Saved"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function getEmployee($id = null)
	{
		$mdl = new UserModel();
		$builder = $mdl->select("*")
			->where('id', $id);
		try {
			$data = $builder->get()->getRowArray();
			echo json_encode($data);
		} catch (\ErrorException $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function manipulateCategory()
	{
		$this->_preset();
		$id = $this->request->getPost("categoryId");
		$title = $this->request->getPost("title");
		$desc = $this->request->getPost("description");
		$Mdl = new CategoriesModel();
		try {
			if ($id == "") {
				$Mdl->save(array(
					"title" => $title,
					"description" => $desc,
					"operator" => $this->session->get("shop_id"),
				));
			} else {
				$Mdl->save(array(
					"id" => $id,
					"title" => $title,
					"description" => $desc,
				));
			}

			echo '{"success":"Saved"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}


	public function getCategory($id = null)
	{
		$mdl = new CategoriesModel();
		$builder = $mdl->select("categories.*,u.names as operator")
			->join("users u", "u.id=categories.operator")
			->where('categories.id', $id);
		try {
			$data = $builder->get()->getRowArray();
			echo json_encode($data);
		} catch (\ErrorException $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}


	public function mainstore()
	{
		$this->_preset();
		$mdl = new CategoriesModel();
		$iMdl = new MainStoreModel();
		$data = array();
		$data['title'] = "Categories";
		$data['categories'] = $mdl->select("*")->get()->getResultArray();
		$data['items'] = $iMdl->select("*")
			->orderBy('id','DESC')
			->get()->getResultArray();
		$data['content'] = view("mainStore", $data);
		return view('layout', $data);
	}

	public function getMainItem($id = null)
	{
		$iMdl = new MainStoreModel();
		$builder = $iMdl->select("mainstore.*,")
			->join("categories c", "c.id=mainstore.categoryId")
			->where('mainstore.id', $id);
		try {
			$data = $builder->get()->getRowArray();
			echo json_encode($data);
		} catch (\ErrorException $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function manipulateMainStore()
	{
		$this->_preset();
		$qty = 1;
		$id = $this->request->getPost("itemId");
		$name = $this->request->getPost("title");
		$serial = $this->request->getPost("serial");
		$model = $this->request->getPost("model");
		$category = $this->request->getPost("category");
		$type = $this->request->getPost("type");
		$quantity = $this->request->getPost("quantity");
		$purchased = $this->request->getPost("purchased");
		$selling = $this->request->getPost("selling");
		$desc = $this->request->getPost("desc");
		$lastprice = $this->request->getPost("lastselling");
		
		if ($quantity != "") {
			$qty = $quantity;
		} else {
			$qty = 1;
		}
		$Mdl = new MainStoreModel();
		if($lastprice > $selling){
			return $this->response->setJSON(array("error"=>"le prix de reduction ne doit pas depasser le prix de vente general"));
		}
		else{
			try {
				if ($id == "") {
					$Mdl->save(array(
						"categoryId" => $category,
						"name" => $name,
						"type" => $type,
						"serialNumber" => $serial,
						"model" => $model,
						"quantity" => $qty,
						// "lastprice" =>$lastselling,
						"purchasedPrice" => $purchased,
						"sellingPrice" => $selling,
						"reduction" => $lastprice,
						"description" => $desc,
						"operator" => $this->session->get("shop_id"),
					));
				} else {
					$Mdl->save(array(
						"id" => $id,
						"categoryId" => $category,
						"name" => $name,
						"type" => $type,
						"serialNumber" => $serial,
						"model" => $model,
						"quantity" => $qty,
						"purchasedPrice" => $purchased,
						"sellingPrice" => $selling,
						"reduction" => $lastprice,
						"description" => $desc,
					));
				}

				echo '{"success":"Saved"}';
			} catch (\Exception $e) {
				echo '{"error":' . $e->getMessage() . '}';
			}
		}
	}


	public function clients()
	{
		$this->_preset();
		$data = array();
		$mdl = new ClientModel();
		$iMdl = new MainStoreModel();
		$data['clients'] = $mdl->select("clients.id,clients.name,clients.phone,clients.email,clients.address,clients.street")->get()->getResultArray();
		$data['items'] = $iMdl->select("id,name,sellingPrice")->get()->getResultArray();
		$data['title'] = "Clients";
		$data['content'] = view("clients", $data);
		return view('layout', $data);
	}

	public function get_client($id = null)
	{
		$mdl = new ClientModel();
		$builder = $mdl->select("*")->where('id', $id);
		try {
			$data = $builder->get()->getRowArray();
			echo json_encode($data);
		} catch (\ErrorException $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function manipulate_client()
	{
		$this->_preset();
		$name = $this->request->getPost("name");
		$id = $this->request->getPost("client_Id");
		$phone = $this->request->getPost("phone");
		$email = $this->request->getPost("email");
		$address = $this->request->getPost("address");
		$street = $this->request->getPost("street");
		$cMdl = new ClientModel();
		try {
			if ($id == "") {
				$cMdl->save(array(
					"name" => $name,
					"phone" => $phone,
					"email" => $email,
					"address" => $address,
					"street" => $street,
					"status" => 1,
					"created_by" => $this->session->get("shop_id"),
				));
			} else {
				$cMdl->save(array(
					"id" => $id,
					"name" => $name,
					"phone" => $phone,
					"email" => $email,
					"address" => $address,
					"street" => $street,
				));
			}

			echo '{"success":"saved"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function invoicing($id)
	{
		$this->_preset();
		$data = array();
		$mdl = new ClientModel();
		$iMdl = new MainStoreModel();
		$data['clients'] = $mdl->select("clients.id,clients.name,clients.phone,clients.email,clients.address,clients.street")->where("id", $id)->get()->getRowArray();
		$data['items'] = $iMdl->select("mainstore.id,mainstore.name,mainstore.sellingPrice,c.title")
			->join("categories c", "c.id=mainstore.categoryId")->get()->getResultArray();
		$data['title'] = "Invoice";
		$data['content'] = view("invoicing", $data);
		return view('layout', $data);
	}

	public function manipulate_items()
	{
		$iModel = new InvoicesModel();
		$sModel = new SellingModel();
		$pModel = new MainStoreModel();
		$invoice = $this->request->getPost("invoiceId");
		$client = $this->request->getPost("clientId");
		$product = $this->request->getPost("productId");
		$qty = $this->request->getPost("quantity");
		$productInfo = $pModel->where("id", $product)->get()->getRowArray();
		$amount = $this->request->getPost("prixVente") * $qty;
		$invoiceTbl = 0;
		$checker = $pModel->select("quantity,usedQuantity")->where("id", $product)->get()->getRowArray();
		if (($checker['quantity'] - $checker['usedQuantity']) - $qty < 0) {
			return $this->response->setJSON(array("error" => "Desolé ! La quantité disponlibe est de " . ($checker['quantity'] - $checker['usedQuantity']) . " seulement."));
		}
		if ($this->request->getPost('prixVente') < $productInfo['reduction']) {
			return $this->response->setJSON(array("error" => "Desolé ! Le prix de reduction ne doit pas depasser " .($productInfo['reduction'])." pour ce produit."));
		}
		if($checker['usedQuantity']>=0){
			$useq=$checker['usedQuantity']+$qty;
			$id=$product;
			$info = array(
				"usedQuantity" => $useq);
			$pModel->update($id,$info);
		}
		$qtys = $checker['quantity']-$useq;
		try {
			if ($invoice == '') {
				$information = array(
					"clientId" => $client,
					"operator" => $this->session->get("shop_id"),
					"status" => 0);
				$invoice_id = $iModel->insert($information);
				$records = array(
					"invoiceId" => $invoice_id,
					"productId" => $product,
					"quantity" => $qty,
					"unitPrice" => $this->request->getPost("prixVente"),
					"amount" => $amount,
					"status" => 0);
				$sModel->save($records);
				
				$invoiceTbl = $sModel->select("sellinginfo.*,st.name as produit,st.categoryId,st.sellingPrice as price,ct.title as title")
				->join("mainstore st", "sellinginfo.productId=st.id")
				->join("categories ct","ct.id=st.categoryId")
				->where("sellinginfo.invoiceId", $invoice_id)->get()->getResult();
				return $this->response->setJSON(array("success" => "Added","qtyd"=>$qtys, "invoice" => $invoice_id, "records" => $invoiceTbl));
			} else {
				$records = array(
					"invoiceId" => $invoice,
					"productId" => $product,
					"quantity" => $qty,
					"unitPrice" => $this->request->getPost("prixVente"),
					"amount" => $amount,
					"status" => 0);
				$sModel->save($records);
				$invoiceTbl = $sModel->select("sellinginfo.*,st.name as produit,st.categoryId,st.sellingPrice as price,ct.title as title")
				->join("mainstore st", "sellinginfo.productId=st.id")
				->join("categories ct","ct.id=st.categoryId")
				->where("sellinginfo.invoiceId", $invoice)->get()->getResult();
				return $this->response->setJSON(array("success" => "Added", "qtyd"=>$qtys,"records" => $invoiceTbl));
			}
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}
	public function getSales($id){
		$mdl= new MainStoreModel();
		$item= $mdl->select('model,sellingPrice,quantity,usedQuantity')->where('id',$id);
		try{
			$data= $item->get()->getRowArray();
			echo json_encode($data);
		}
		catch (\ErrorException $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}

	public function saveInvoice()
	{
		$this->_preset();
		$productId = $this->request->getPost("productId");
		$qty = $this->request->getPost("quantity");
		$recordId = $this->request->getPost("recordId");
		$Mdl = new MainStoreModel();
		$sMdl = new SellingModel();
		echo '{"success":"Saved"}';
		// try {
		// 	$i = 0;
		// 	if (is_array($productId) || is_object($productId)):
		// 	foreach ($productId as $id) {
		// 		$usedQ= $Mdl->select("usedQuantity")->where('id',$id)->get()->getRowArray();
		// 		foreach($usedQ as $usedQ){
		// 		$Mdl->save(array(
		// 			"id" => $id,
		// 			"usedQuantity" =>$usedQ + $qty[$i],
		// 		));
		// 	}
		// 		$i++;
		// 	}
		// endif;
		// 	echo '{"success":"Saved"}';
		// } catch (\Exception $e) {
		// 	echo '{"error":' . $e->getMessage() . '}';
		// }
	}

	public function invoiceHistory($client)
	{
		$this->_preset();
		$data = array();
		$mdl = new InvoicesModel();
		$data['histories'] = $mdl->select("invoices.id,invoices.created_at ,invoices.clientId, u.names as operator")
			->join("users u", "u.id=invoices.operator")
			->where("invoices.clientId", $client)
			->orderBy("invoices.id", "DESC")
			->get()->getResultArray();
		$data['title'] = "History";
		$data['content'] = view("invoiceHistory", $data);
		return view('layout', $data);
	}

	public function viewInvoiceHistory($invoice, $client)
	{
		$this->_preset();
		$data = array();
		$mdl = new SellingModel();
		$cMdl = new ClientModel();
		$data['clients'] = $cMdl->select("clients.id,clients.name,clients.phone,clients.email,clients.address,clients.street")->where("id", $client)->get()->getRowArray();
		$data['invoices'] = $mdl->select("sellinginfo.*,st.name as produit,st.sellingPrice as price")
			->join("mainstore st", "sellinginfo.productId=st.id")
			->where("sellinginfo.invoiceId", $invoice)->get()->getResultArray();
		$data['title'] = "History";
		$data['invoiceid']=$invoice;
		$data['content'] = view("viewInvoice", $data);
		return view('layout', $data);
	}

	public function generalReport()
	{
		$this->_preset();
		// $mdl = new BranchesModel();
		$eMdl = new UserModel();
		$data = array();
		$data['title'] = "General Report";
		// $data['branches'] = $mdl->select('*')->get()->getResultArray();
		$data['employees'] = $eMdl->select('users.*')->get()->getResultArray();
		//$data['employees'] = $eMdl->select('users.*,b.name as branche')->join("branches b", "users.brancheId=b.id", "LEFT")->get()->getResultArray();
		$data['content'] = view("generalReport", $data);
		return view('layout', $data);
	}

	public function getGeneralReport()
	{
		$this->_preset();
		$mdl = new SellingModel();
		$fromDate = $this->request->getPost('fromDate');
		$untilDate = $this->request->getPost('untilDate');
		$records = $mdl->select("sellinginfo.*,u.names as operator,i.created_at,p.name as product,p.sellingPrice,p.categoryId,c.title ")
			->join("mainstore p", "p.id=sellinginfo.productId")
			->join("categories c","c.id=p.categoryId")
			->join("invoices i", "i.id=sellinginfo.invoiceId")
			->join("users u", "u.id=i.operator")
			->where("i.created_at >=", $fromDate)
			->where("i.created_at <=", $untilDate)
			->get()->getResultArray();
		if (count($records) == 0) {
			echo '{"error":"No data found"}';
		} else {
			return $this->response->setJSON($records);
		}
	}

	public function productReport()
	{
		$this->_preset();
		$mdl = new MainStoreModel();
		$data = array();
		$data['title'] = "Report By Product";
		$data['items'] = $mdl->select("mainstore.id,mainstore.name,c.title")
			->join("categories c", "c.id=mainstore.categoryId")->get()->getResultArray();
		$data['content'] = view("productReport", $data);
		return view('layout', $data);
	}

	public function getProductReport()
	{
		$this->_preset();
		$mdl = new SellingModel();
		$productId = $this->request->getPost('productId');
		$fromDate = $this->request->getPost('fromDate');
		$untilDate = $this->request->getPost('untilDate');
		$records = $mdl->select("sellinginfo.*,u.names as operator,i.created_at,p.name as product,p.sellingPrice,p.categoryId,c.title ")
			->join("mainstore p", "p.id=sellinginfo.productId")
			->join("categories c","c.id=p.categoryId")
			->join("invoices i", "i.id=sellinginfo.invoiceId")
			->join("users u", "u.id=i.operator")
			->where("i.created_at >=", $fromDate)
			->where("i.created_at <=", $untilDate)
			->where("sellinginfo.productId", $productId)
			->get()->getResultArray();
		if (count($records) == 0) {
			echo '{"error":"No data found"}';
		} else {
			return $this->response->setJSON($records);
		}
	}
	public function profile(){
		$this->_preset();
		$eMdl = new UserModel();
		$data = array();
		$data['title'] = "General Report";
		$data['employees'] = $eMdl->select("*")->where("id",$this->session->get("shop_id"))->get()->getRowArray();
		$data['content'] = view("profil", $data);
		return view('layout', $data);
	}
	public function changePassword(){
		$logger=$this->session->get("shop_id");
		$formPassword = $this->request->getPost('currentPassword');
		$newPassword = $this->request->getPost('newPassword');
		$userModel=new UserModel();
		$password=$userModel->select("password")->where("id",$logger)->get()->getRowArray();
		if(password_verify($formPassword, $password['password'])){
			$data = array(
				"id" => $logger,
				"password" => password_hash($newPassword,PASSWORD_DEFAULT));
			try {
				$userModel->save($data);
				echo '{"success":"saved"}';
			} catch (\Exception $e) {
				echo '{"error":'.$e->getMessage().'}';
			}
		}else{
			echo '{"error":"Invalid Current Password"}';
		}

	}
	public function deleteEmployee(){
		$MdlE= new UserModel();
		$id =  $this->request->getPost("id");
			$data = array("id" => $id);
		try {
			$MdlE->delete($data);
			echo '{"success":"User Deleted"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}

	}
	public function removeItemInvoice($remove){
		$MdlE= new SellingModel();
		$sMdl = new MainStoreModel();
		$information = $MdlE->select("sellinginfo.quantity,sellinginfo.productId,st.usedQuantity,st.quantity as avq")
		->join("mainstore st", "sellinginfo.productId=st.id")
		->where("sellinginfo.id",$remove)
		->get()->getRowArray();
			$id=$information['productId'];
			$info = array(
				"usedQuantity" => $information['usedQuantity']-$information['quantity']
			);
			$disponible=$information['avq']-$information['usedQuantity']+$information['quantity'];
		$data = array("id" => $remove);
		try {
			$sMdl->update($id,$info);
			$MdlE->delete($data);
			echo '{"success":"Supprimer avec success","dispo":"'.$disponible.'","idp":"'.$id.'"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}
	}
	public function removeInvoice($id){
		$MdlE= new SellingModel();
		$iMdl= new InvoicesModel();
		$sMdl = new MainStoreModel();
		$information = $MdlE->select("sellinginfo.quantity,sellinginfo.productId,sellinginfo.invoiceId,st.usedQuantity")
		->join("mainstore st", "sellinginfo.productId=st.id")
		->where("sellinginfo.invoiceId",$id)->get()->getResultarray();
		foreach($information as $item){
			$ids=$item['productId'];
			$info = array(
				"usedQuantity" => $item['usedQuantity']-$item['quantity']);
			$sMdl->update($ids,$info);
		}
		$data = array("invoiceId" => $id);
		$invoice = array("id"=>$id);
		try {
			$MdlE->delete($data);
			$iMdl->delete($invoice);
			echo '{"success":"Facure supprimée avec success"}';
		} catch (\Exception $e) {
			echo '{"error":' . $e->getMessage() . '}';
		}

	}
	public function inventaire(){
		$this->_preset();
		$data = array();
		$data['title'] = "Inventaire General";
		$data['content'] = view("inventaire",$data);
		return view('layout', $data);
	}
	public function getInventory(){
		$mdl = new MainStoreModel();
		$fromDate = $this->request->getPost('fromDate');
		$untilDate = $this->request->getPost('untilDate');
		$data = $mdl->select("mainstore.name as product,mainstore.quantity,mainstore.usedQuantity,mainstore.categoryId,cat.title as category")
			->join("categories cat","mainstore.categoryId=cat.id")
			->where("mainstore.created_at >=", $fromDate)
			->where("mainstore.created_at <=", $untilDate)
			->get()->getResultArray();
		if (count($data) == 0) {
			echo '{"error":"No data found"}';
		} else {
			return $this->response->setJSON($data);
		}
	}

}
