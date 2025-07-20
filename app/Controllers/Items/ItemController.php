<?php

namespace App\Controllers\Items;

use App\Controllers\BaseController;
use App\Entities\Item;
use App\Models\{ItemModel, CategoryModel};
use App\Validation\ItemValidator;
use Ramsey\Uuid\Uuid;

abstract class ItemController extends BaseController
{
  protected ItemModel $model;
  protected $formValidator;
  protected CategoryModel $categoryModel;

  protected bool $isProducts;
  protected string $currentPage;

  public function __construct(bool $isProducts)
  {
    $this->isProducts = $isProducts;
    $this->currentPage = $isProducts ? "products" : "services";
    $this->model = new ItemModel();
    $this->formValidator = new ItemValidator();
    $this->categoryModel = new CategoryModel();
  }

  // vistas
  public function index()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', $this->currentPage);
    $type = $this->isProducts ? "product" : "service";

    $data = [
      'title' => $this->isProducts ? "Productos" : "Servicios",
      'currentPage' => $this->currentPage,
      'items' => $this->model->findAllWithCategoryAndType(session()->get('business_id'), ($type)),
    ];
    return view('Item/index', $data);
  }

  public function new()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', 'items/new');

    $data = [
      'title' => 'Nuevo Item',
      'categories' => $this->categoryModel->findAllByBusiness(session()->get('business_id')),
    ];
    return view('Item/new', $data);
  }

  public function show($id = null)
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', "items/$id");

    $data = [
      'title' => 'Editar Item',
      'item' => $this->model->find(uuid_to_bytes($id)),
      'categories' => $this->categoryModel->findAllByBusiness(session()->get('business_id')),
    ];
    return view('Item/show', $data);
  }

  // acciones
  public function create()
  {
    if (!$this->validate($this->formValidator->create)) {
      return redirect()->back()->withInput();
    }

    $post = $this->request->getPost();
    $post['id'] = Uuid::uuid4();
    $post['business_id'] = uuid_to_bytes(session()->get('business_id'));

    $this->model->insert(new Item($post));
    return redirect()->to('items/new')->with('success', 'Item creado exitosamente.');
  }

  public function update($id = null)
  {
    if (!$this->validate($this->formValidator->update)) {
      return redirect()->back()->withInput();
    }

    $post = $this->request->getPost();
    $row = [];
    foreach ($post as $key => $value) {
      if ($value && $key !== '_method') $row[$key] = $value;
    }
    if (empty($row)) return redirect()->to('items');

    $this->model->update(uuid_to_bytes($id), new Item($row));
    return redirect()->to('items')->with('success', 'Item actualizado exitosamente.');
  }

  public function delete($id = null)
  {
    if ($this->model->delete(uuid_to_bytes($id))) {
      return redirect()->to($this->currentPage)->with('success', 'Elemento eliminado exitosamente.');
    } else {
      return redirect()->to($this->currentPage)->with('error', 'No se pudo eliminar el elemento.');
    }
  }
}
