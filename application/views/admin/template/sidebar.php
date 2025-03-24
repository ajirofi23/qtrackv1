<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-text mx-3">QTRACK</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Home -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('HomeController');?>">
        <span><i class="fas fa-home"></i></span>
      <span>Home</span>
    </a>
</li>

<!-- Nav Item - Home -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('AntrianController');?>">
        <span><i class="fas fa-microphone"></i></span>
      <span>Antrian</span>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<?php if($this->session->userdata('roles') === 'admin') : ?>
<!-- Heading -->
<div class="sidebar-heading">
    Management Sistem :
</div>

<!-- Nav Item - Home -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('LoketController');?>">
        <span><i class="fas fa-desktop"></i></span>
      <span>Loket</span>
    </a>
</li>


<!-- Nav Item - Home -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('LayananController');?>">
        <span><i class="fas fa-wrench"></i></span>
      <span>Layanan</span>
    </a>
</li>


<!-- Nav Item - Home -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('UserManagementController');?>">
        <span><i class="fas fa-users"></i></span>
      <span>Users</span>
    </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php endif;?>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>