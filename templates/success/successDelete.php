<?php include __DIR__ . '/../header.php'; ?>
<?php header('Refresh:3; URL=/'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="alert alert-success" role="alert">
                    Payroll has been deleted successfully
                </div>
                <p style="display: block; color: #ffffff; margin-bottom: 15px;">You will be redirected to the main page in <span id="counter">3</span></p>
            </div>
            <a href="/" style="padding-left: 15px"><span id="cancel-add">Home</span></a>
        </div>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>