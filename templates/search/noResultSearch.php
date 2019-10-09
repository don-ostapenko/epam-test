<?php include __DIR__ . '/../header.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex flex-row-reverse mb-4">
                    <a href="/create" class="ml-3"><button class="btn btn-primary">Create</button></a>
                    <form action="/search" method="post">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search by name" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary"><i class="far fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Основная таблица -->
                <table class="table table-striped table-dark" id="table">
                    <thead>
                    <tr>
                        <th scope="col" class="noneSort no-sort">Name</th>
                        <th scope="col">Department</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Salary</th>
                        <th scope="col" class="noneSort no-sort" style="width: 5%!important;"></th>
                        <th scope="col" class="noneSort no-sort" style="width: 5%!important;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <td>No result</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tbody>
                </table>
            </div>
            <a href="/" style="padding-left: 15px"><span id="cancel-add">Home</span></a>
        </div>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>
