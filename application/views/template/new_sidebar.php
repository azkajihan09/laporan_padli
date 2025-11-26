  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  	<!-- Brand Logo -->
  	<a href="<?php echo site_url('Admin/Dashboard') ?>" class="brand-link">
  		<img src="<?php echo base_url() ?>assets/dist/img/logo-mahkamah-agung.png" alt="Logo PA Amuntai" class="brand-image img-circle elevation-3" style="opacity: .8">
  		<span class="brand-text font-weight-light">SI LAPER</span>
		<br><small>(Sistem Laporan Perkara)</small>
  		
  	</a>

  	<!-- Sidebar -->
  	<div class="sidebar">
  		<!-- Sidebar user (optional) -->
  		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  			<div class="image">
  				<img src="<?php echo base_url() ?>assets/dist/img/Logo PA Amuntai - Trans.png" class="img-circle elevation-2" alt="User Image">
  			</div>
  			<div class="info">
  				<a href="#" class="d-block">PA Amuntai</a>
  			</div>
  		</div>

  		<!-- Sidebar Menu -->
  		<nav class="mt-2">
  			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

  				<!-- Dashboard Menu -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-tachometer-alt"></i>
  						<p>
  							Dashboard
  							<i class="right fas fa-angle-left"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Dashboard/simple') ?>" class="nav-link">
  								<i class="fas fa-chart-line nav-icon"></i>
  								<p>Dashboard Simple</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Dashboard') ?>" class="nav-link">
  								<i class="fas fa-chart-area nav-icon"></i>
  								<p>Dashboard Modern</p>
  							</a>
  						</li>
  					</ul>
  				</li>
  				<!-- Data Gugatan Menu -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-database"></i>
  						<p>
  							DATA PERKARA GUGATAN
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Data_Perkara_Gugatan') ?>" class="nav-link">
  								<i class="fas fa-file-alt nav-icon"></i>
  								<p>Data Perkara Gugatan</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Faktor_perceraian_detail') ?>" class="nav-link">
  								<i class="fas fa-chart-pie nav-icon"></i>
  								<p>FAKTOR PERCERAIAN DETAIL</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Data_Cerai_Gugat') ?>" class="nav-link">
  								<i class="fas fa-heart-broken nav-icon"></i>
  								<p>Data Cerai Gugat</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Statistik_Gugatan') ?>" class="nav-link">
  								<i class="fas fa-chart-pie nav-icon"></i>
  								<p>Statistik Gugatan</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Laporan_Gugatan') ?>" class="nav-link">
  								<i class="fas fa-file-pdf nav-icon"></i>
  								<p>Laporan Gugatan</p>
  							</a>
  						</li>
  					</ul>
  				</li>



  				<!-- Data Perceraian Menu -->
  				<!-- <li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-heart-broken"></i>
						<p>
							DATA PERCERAIAN
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo site_url('Data_Perceraian_hsu') ?>" class="nav-link">
								<i class="fas fa-map-marker-alt nav-icon"></i>
								<p>HULU SUNGAI UTARA</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url('Data_Perceraian_balangan') ?>" class="nav-link">
								<i class="fas fa-map-marker-alt nav-icon"></i>
								<p>BALANGAN</p>
							</a>
						</li>
						
					</ul>
				</li> -->

  				<!-- Akta Cerai Menu -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-certificate"></i>
  						<p>
  							AKTA CERAI
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Penerbitan_akta_cerai') ?>" class="nav-link">
  								<i class="fas fa-file-contract nav-icon"></i>
  								<p>LAPORAN PENERBITAN AKTA CERAI</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Penyerahan_akta_cerai') ?>" class="nav-link">
  								<i class="fas fa-handshake nav-icon"></i>
  								<p>LAPORAN PENYERAHAN AKTA CERAI</p>
  							</a>
  						</li>
  					</ul>
  				</li>

  				<!-- Laporan Putusan Menu -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-gavel"></i>
  						<p>
  							LAPORAN PUTUSAN
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Laporan_putusan') ?>" class="nav-link">
  								<i class="fas fa-clipboard-list nav-icon"></i>
  								<p>LAPORAN HASIL PUTUSAN PERKARA</p>
  							</a>
  						</li>
  					</ul>
  				</li>

  				<!-- Data Permohonan Menu -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-map-marked-alt"></i>
  						<p>
  							DATA PERMOHONAN
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Data_Permohonan') ?>" class="nav-link">
  								<i class="fas fa-chart-bar nav-icon"></i>
  								<p>LAPORAN PERMOHONAN PER WILAYAH</p>
  							</a>
  						</li>
  					</ul>
  				</li>

  				<!-- Delegasi Menu -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-exchange-alt"></i>
  						<p>
  							DELEGASI
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Delegasi') ?>" class="nav-link">
  								<i class="fas fa-arrow-down nav-icon"></i>
  								<p>Delegasi Masuk</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Delegasi_k') ?>" class="nav-link">
  								<i class="fas fa-arrow-up nav-icon"></i>
  								<p>Delegasi Keluar</p>
  							</a>
  						</li>
  					</ul>
  				</li>

  			</ul>
  		</nav>
  		<!-- /.sidebar-menu -->
  	</div>
  	<!-- /.sidebar -->
  </aside>

  <!-- AdminLTE JS diperlukan untuk treeview -->
  <script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>

  <script>
  	$(document).ready(function() {
  		// Untuk parent menu yang memiliki submenu
  		$('a[href="#"]').on('click', function(e) {
  			e.preventDefault();

  			var $parentLi = $(this).parent('li');
  			var $submenu = $(this).next('ul.nav-treeview');

  			if ($submenu.length > 0) {
  				// Toggle submenu
  				if ($parentLi.hasClass('menu-open')) {
  					$parentLi.removeClass('menu-open');
  					$submenu.slideUp(300);
  				} else {
  					// Tutup submenu lain yang terbuka
  					$('.nav-item.menu-open').removeClass('menu-open');
  					$('.nav-treeview').slideUp(300);

  					// Buka submenu ini
  					$parentLi.addClass('menu-open');
  					$submenu.slideDown(300);
  				}
  			}
  		});

  		// Set active menu berdasarkan URL saat ini
  		var currentPath = window.location.pathname;
  		var currentController = currentPath.split('/').pop(); // Ambil controller dari URL

  		// Reset semua active state
  		$('.nav-link').removeClass('active');
  		$('.nav-item').removeClass('menu-open active');

  		// Cek setiap link submenu
  		$('.nav-treeview .nav-link').each(function() {
  			var href = $(this).attr('href');
  			if (href && href !== '#') {
  				// Ambil bagian controller dari href
  				var linkController = href.split('/').pop();

  				// Jika controller cocok dengan URL saat ini
  				if (currentPath.indexOf(linkController) > -1 || currentController === linkController) {
  					// Set active untuk submenu
  					$(this).addClass('active');

  					// Set active dan buka parent menu
  					var $parentItem = $(this).closest('li.nav-item').parent().closest('li.nav-item');
  					$parentItem.addClass('menu-open active');
  					$parentItem.find('> a').addClass('active');

  					// Tampilkan submenu
  					$(this).closest('.nav-treeview').show();
  				}
  			}
  		});
  	});
  </script>

  <!-- CSS tambahan untuk smooth animation -->
  <style>
  	.nav-treeview {
  		display: none;
  	}

  	.nav-item.menu-open>.nav-treeview {
  		display: block;
  	}

  	.nav-sidebar .nav-link {
  		transition: all 0.3s ease;
  	}

  	.nav-sidebar .nav-link:hover {
  		background-color: rgba(255, 255, 255, 0.1);
  	}
  </style>