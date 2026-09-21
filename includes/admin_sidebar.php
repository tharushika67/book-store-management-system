<?php
$adminBase = "";

if (strpos($_SERVER['PHP_SELF'], "/admin/") !== false) {
    $adminBase = "../";
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="col-lg-2 col-md-3 bg-dark text-white p-3
            sticky-lg-top"
     style="height:100vh;">

    <h4 class="text-center fw-bold border-bottom pb-3 mb-4">
        Admin Panel
    </h4>

    <div class="list-group list-group-flush">

        <a href="<?php echo $adminBase; ?>admin/dashboard.php"
            class="list-group-item list-group-item-action border-secondary
            <?php echo ($currentPage == 'dashboard.php') ? 'active' : 'bg-dark text-white'; ?>">
             <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="<?php echo $adminBase; ?>admin/view_books.php"
            class="list-group-item list-group-item-action border-secondary
            <?php echo ($currentPage == 'view_books.php') ? 'active' : 'bg-dark text-white'; ?>">
             <i class="bi bi-book"></i> View Books
        </a>

        <a href="<?php echo $adminBase; ?>admin/add_book.php"
            class="list-group-item list-group-item-action border-secondary
            <?php echo ($currentPage == 'add_book.php') ? 'active' : 'bg-dark text-white'; ?>">
             <i class="bi bi-plus-circle"></i> Add Book
        </a>

        <a href="<?php echo $adminBase; ?>admin/manage_orders.php"
            class="list-group-item list-group-item-action border-secondary
            <?php echo ($currentPage == 'manage_orders.php') ? 'active' : 'bg-dark text-white'; ?>">
             <i class="bi bi-cart-check"></i> Manage Orders
        </a>

        <a href="<?php echo $adminBase; ?>auth/logout.php"
            class="list-group-item list-group-item-action bg-dark text-danger border-secondary">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>

    </div>

</div>