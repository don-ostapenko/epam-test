<?php include __DIR__ . '/../header.php'; ?>
    <div class="container">
        <div class="row">
            <div id="overlay-add">
                <form action="/<?= $payroll->getId() ?>/edit" id="modal-add" method="post">
                    <h3 class="mb-3">Edit a payroll</h3>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="name">Name*</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter name" value="<?= $_POST['name'] ?? $payroll->getName() ?>">
                    </div>
                    <div class="form-group">
                        <label for="department">Department*</label>
                        <select id="department" name="department" class="form-control">
                            <option <?php if ($payroll->getDepartment() == 'Mobile phones'): ?> selected <?php endif; ?> >Mobile phones</option>
                            <option <?php if ($payroll->getDepartment() == 'TV sets'): ?> selected <?php endif; ?> >TV sets</option>
                            <option <?php if ($payroll->getDepartment() == 'Computers'): ?> selected <?php endif; ?> >Computers</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount*</label>
                        <input type="text" name="amount" class="form-control" id="amount" placeholder="Enter amount" value="<?= $_POST['amount'] ?? $payroll->getAmount() ?>">
                    </div>
                    <div style="display: flex; padding-top: 10px;">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="/"><span id="cancel-add">Cancel</span></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>
