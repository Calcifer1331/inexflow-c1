<?= $this->extend('Item/new') ?>

<?= $this->section('new_form') ?>

<form action="/products" method="POST" novalidate>
    <div class="mb-3">
        <label for="name" class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Categoría</label>
        <select name="category_id" class="form-select" onchange="activatePrice(this, event)">
            <option value="">-- Seleccione una categoría --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>">
                    <?= $category->displayType() . " | " . $category->name ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="cost" class="form-label">Costo</label>
        <input type="number" name="cost" class="form-control" step="0.01" min="0" placeholder="0.50">
    </div>
    <div class="mb-3">
        <label for="selling_price" class="form-label">Precio de Venta</label>
        <input type="number" name="selling_price" class="form-control" step="0.01" min="0" placeholder="0.75">
    </div>
    <div class="mb-3">
        <label for="stock" class="form-label">Cantidad</label>
        <input type="number" name="stock" class="form-control" step="1" min="1" value="1">
    </div>
    <div class="mb-3">
        <label for="min_stock" class="form-label">Cantidad Mínima (para alertar)</label>
        <input type="number" name="min_stock" class="form-control" step="1" min="1" value="1">
    </div>
    <div class="mb-3">
        <label for="measure_unit" class="form-label">Unidad de Medida</label>
        <input type="text" name="measure_unit" class="form-control" placeholder="unidad, kg, lb, etc" value="unidad">
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-success">Registrar</button>
    </div>
</form>
<?= $this->endSection() ?>