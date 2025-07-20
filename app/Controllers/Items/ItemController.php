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
  /**
   * @var 'product'| 'service' $itemType
   */
  protected string $itemType;

  public function __construct(bool $isProducts, string $currentPage, string $itemType)
  {
    $this->isProducts = $isProducts;
    $this->currentPage = $currentPage;
    $this->itemType = $itemType;
    $this->model = new ItemModel();
    $this->formValidator = new ItemValidator();
    $this->categoryModel = new CategoryModel();
  }

  // vistas
  public function index()
  {
    echo $this->request->getUri()->getSegment(1);
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', $this->currentPage);

    $data = [
      'title' => $this->isProducts ? "Productos" : "Servicios",
      'currentPage' => $this->currentPage,
      'items' => $this->model->findAllWithCategoryAndType(session()->get('business_id'), $this->itemType),
    ];
    return view('Item/index', $data);
  }

  public function new()
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', $this->currentPage);

    $data = [
      'title' => 'Nuevo ' . ($this->isProducts ? 'Producto' : 'Servicio'),
      'categories' => $this->categoryModel->findAllByBusiness(session()->get('business_id')),
    ];
    return view('Item/' . ($this->isProducts ? "Product" : "Service") . '/new', $data);
  }

  public function show($id = null)
  {
    if (!session()->get('business_id')) return redirect()->to('business/new');
    $redirect = check_user('businessman');
    if ($redirect !== null) return redirect()->to($redirect);
    else session()->set('current_page', "{$this->currentPage}/$id");

    $data = [
      'title' => 'Editar ' . ($this->isProducts ? 'Producto' : 'Servicio'),
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

    $data = [
      'id'          => Uuid::uuid4(),
      'business_id' => uuid_to_bytes(session()->get('business_id')),
      'type'        => $this->isProducts ? 'product' : 'service',
      'name'        => $post['name'],
      'selling_price' => floatval($post['selling_price']),
      'cost'        => floatval($post['cost']),
      'category_id' => $post['category_id'],
    ];

    if ($this->isProducts) {
      $data += [
        'stock'         => intval($post['stock']),
        'min_stock'         => intval($post['min_stock']),
        'measure_unit'  => $post['measure_unit'],
      ];
    };

    $this->model->insert(new Item($data));

    return redirect()->to("{$this->currentPage}/new")->with('success', 'Elemento creado exitosamente.');
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
    if (empty($row)) return redirect()->to($this->currentPage);

    $this->model->update(uuid_to_bytes($id), new Item($row));
    return redirect()->to($this->currentPage)->with('success', 'Elemento actualizado exitosamente.');
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
