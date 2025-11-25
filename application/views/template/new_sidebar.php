  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
  	<!-- Brand Logo -->
  	<a href="<?php echo site_url('Admin/Dashboard') ?>" class="brand-link">
  		<img src="<?php echo base_url() ?>assets/dist/img/logo-mahkamah-agung.png" alt="Logo PA Amuntai" class="brand-image img-circle elevation-3" style="opacity: .8">
  		<span class="brand-text font-weight-light">LAPORAN PERKARA</span>
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

  				<li class="nav-item">
  					<a href="<?php echo site_url('Dashboard') ?>" class="nav-link">
  						<i class="nav-icon fas fa-chart-area"></i>
  						<p>
  							Dashboard
  							<i class="right fas fa-angle-left"></i>
  						</p>
  					</a>
  				</li>

  				<!-- <li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-table"></i>
  						<p>
  							Laporan lipa 1
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Lipa1') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>Laporan LIPA 1</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('perkara_banding') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>Perkara Banding</p>
  							</a>
  						</li>


  					</ul>
  				</li> -->
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-folder"></i>
  						<p>
  							DELEGASI
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item active">
  							<a href="<?php echo site_url('Delegasi') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>Delegasi Masuk</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Delegasi_k') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>Delegasi Keluar</p>
  							</a>
  						</li>
  					</ul>
  				</li>
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-folder"></i>
  						<p>
  							DATA PERCERAIAN
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Data_Perceraian_hsu') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>HULU SUNGAI UTARA
  								</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Data_Perceraian_balangan') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>BALANGAN
  								</p>
  							</a>
  						</li>

  					</ul>
  				</li>

  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-folder"></i>
  						<p>
  							AKTA CERAI
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Penerbitan_akta_cerai') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>LAPORAN PENERBITAN AKTA CERAI
  								</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Penyerahan_akta_cerai') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>LAPORAN PENYERAHAN AKTA CERAI
  								</p>
  							</a>
  						</li>

  					</ul>
  				</li>
  				<li class="nav-item">
  					<a href="#" class="nav-link">
  						<i class="nav-icon fas fa-folder"></i>
  						<p>
  							PERKARA
  							<i class="fas fa-angle-left right"></i>
  						</p>
  					</a>
  					<ul class="nav nav-treeview">
  						<li class="nav-item">
  							<a href="<?php echo site_url('Lipa1') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>LAPORAN KEADAAN PERKARA</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Perkara_Banding') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>PERKARA BANDING</p>
  							</a>
  						</li>
  						<li class="nav-item">
  							<a href="<?php echo site_url('Perkara_Putusan') ?>" class="nav-link">
  								<i class="far fa-circle nav-icon"></i>
  								<p>PERKARA PUTUSAN</p>
  							</a>
  						</li>
  					</ul>


  			</ul>
  			</li>
  			</ul>
  		</nav>
  		<!-- /.sidebar-menu -->
  	</div>
  	<!-- /.sidebar -->
  </aside>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
  	$(document).ready(function() {
  		$('.nav-link').on('click', function() {
  			$('.nav-link').removeClass('active');
  			$(this).addClass('active');


  		});
  	});

  	$(document).ready(function() {
  		$('.nav-link').on('click', function() {
  			$('.nav-item').removeClass('active'); // Menghapus kelas 'active' dari semua item
  			$(this).parent().addClass('active'); // Menambahkan kelas 'active' ke item yang diklik
  		});
  	});
  </script>
