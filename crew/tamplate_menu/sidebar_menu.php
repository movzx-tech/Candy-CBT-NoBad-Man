<section class='sidebar' style="background-color: #fff">
				<!-- <div class='user-panel'>
					<div class='pull-left image'>
						<?php
						if ($pengawas['level'] == 'admin') :
							echo " <img src='$homeurl/dist/img/avatar-6.png' class='img-circle' style='border:3px solid white; max-width:60px' alt='+'>";
						elseif ($pengawas['level'] == 'guru') :
							if ($pengawas['foto'] <> '') {
								echo " <img src='$homeurl/foto/fotoguru/$pengawas[foto]' class='img-circle' style='border:2px solid yellow; max-width:60px' alt='+'>";
							} else {
								echo " <img src='$homeurl/dist/img/avatar-6.png' class='img-circle' style='border:2px solid yellow; max-width:60px' alt='+'>";
							}
						endif
						?>
					</div>
					<div class='pull-left info' style='left:65px'>
						<p><?= $pengawas['nama']; ?></p>
						<a href='#'><i class='fa fa-circle text-green'></i> <?= $pengawas['level']; ?></a>
					</div>

				</div> -->
				<!-- <hr style="margin:0px"> -->
				<!-- <div class="user-panel" style="text-align:center">
					<span>APLIKASI UJIAN</span><br>
					<span>BERBASIS KOMPUTER</span>
				</div> -->
				<!-- <hr style="margin:0px"> -->
				<ul class=' sidebar-menu tree data-widget=' tree>
					<?php 
						if($setting['jenjang'] =='SMK' ){
							$sty="background-color: #1fc8db;background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);color: white;opacity: 0.95;";
						}
						elseif($setting['jenjang'] =='SMP'){
							$sty="background-color: #060151; color: white;";
						}
						elseif($setting['jenjang'] =='SD'){
							$sty="background-color: #c74230; color: white;";
						}
						else{
							$sty="background-color: #00a896; color: white;";
						}
					?>

					<li class="header" style="<?= $sty; ?> "><b><center> MENU UTAMA </center></b></li>
					<li><a href='?'><i style="color: #36b8e8;" class="fas fa-home fa-2x fa-fw    "></i> <span>Beranda</span></a></li>
					<?php if ($setting['server'] == 'lokal') : ?>
						<li class=' treeview'>
							<a href='#'>
								<i class="fas fa-sync-alt fa-2x fa-fw    "></i>
								<span>Sinkron Data</span>
								<span class='pull-right-container'>
									<i class='fa fa-angle-down pull-right'></i>
								</span>
							</a>
							<ul class='treeview-menu'>
								<!-- <li><a href='?pg=sinkrondapo'><i class='fa fa-upload'></i> <span>Sinkron Dapodik</span><span class='pull-right-container'><small class='label pull-right bg-green'>new</small></span></a></li> -->
								<li><a href='?pg=sinkron'><i class='fas fa-dot-circle fa-fw'></i> <span> Sinkron Pusat</span></a></li>
								<li><a href='?pg=sinkronset'><i class='fas fa-dot-circle fa-fw'></i> <span> Sinkron Setting</span></a></li>

							</ul>
						</li>
					<?php endif; ?>
					<?php if ($pengawas['level'] == 'admin') : ?>
						<?php if ($setting['server'] == 'pusat') : ?>
							<li class=' treeview'>
								<a href='#'>
									
									<img src="icon/database.svg" width="30" height="25">
									<span>Data Master</span>
									<span class='pull-right-container'>
										<i class='fa fa-angle-down pull-right'></i>
									</span>
								</a>
								<ul class='treeview-menu'>
									<li><a href='?pg=importmaster'><i class='fa fa-upload'></i> <span>Import Data Master</span><span class='pull-right-container'><small class='label pull-right bg-green'>new</small></span></a></li>
									<li><a href='?pg=matapelajaran'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Mata Pelajaran</span></a></li>
									<li><a href='?pg=jenisujian'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Jenis Ujian</span></a></li>

									<?php if ($setting['jenjang'] == 'SMK') : ?>
										<li><a href='?pg=pk'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Jurusan</span></a></li>
									<?php endif ?>

									<li><a href='?pg=kelas'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Kelas</span></a></li>
									<li><a href='?pg=ruang'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Ruangan</span></a></li>
									<li><a href='?pg=level'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Level</span></a></li>
									<li><a href='?pg=sesi'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Sesi</span></a></li>
									<li><a href='?pg=dataserver'><img src="icon/folder1.svg" width="20" height="17"> <span> Data Server</span></a></li>
								</ul>
							</li>
						<?php endif ?>
						<li class='treeview'>
							<a href='?pg=siswa'>
								<img src="icon/user.svg" width="30" height="25">
								<span>Peserta</span>
							</a>
						</li>
						<!-- mryes sekolah -->
						<li class='treeview'>
							<a href='#'>
								
								<img src="icon/todo_list.svg" width="30" height="30">
								<span> Data Info</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=siswa_tidak_ujian'><i class='fas fa-dot-circle fa-fw'></i> <span> Siswa Tidak Ikut Ujain</span></a></li>
								<li><a href='?pg=siswa_sesi'><i class='fas fa-dot-circle fa-fw'></i> <span> Siswa Per Sesi</span></a></li>
								<li><a href='?pg=siswa_ruang'><i class='fas fa-dot-circle fa-fw'></i> <span> Siswa Per Ruang</span></a></li>
								<li><a href='?pg=siswa_kelas'><i class='fas fa-dot-circle fa-fw'></i> <span> Siswa Per Kelas</span></a></li>
								<li><a href='?pg=siswa_jurusan'><i class='fas fa-dot-circle fa-fw'></i> <span> Siswa Per Jurusan</span></a></li>
							</ul>
						</li>
						<!-- mryes sekolah -->

						<li>
							<a href='?pg=banksoal'>
								
								<img src="icon/folder.svg" width="30" height="25"> 
								<span> Bank Soal</span></a>
						</li>
						<li class='treeview'>
							<a href='#'>
								
								<img src="icon/test.svg" width="30" height="30">
								<span> E-Learning</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=token_telegram'><img src="icon/telegram.svg" width="30" height="20"> <span> Token Telegram</span></a></li>
                <?php if($setting['izin_materi']==1){ ?>
								<li><a href='?pg=materi_pb'><img src="icon/book3.svg" width="30" height="20"> </i> <span> Materi Pembelajaran</span></a></li>
                <?php } if($setting['izin_tugas']==1){ ?>
								<li><a href='?pg=tugas_pb'><img src="icon/book.svg" width="30" height="20"><span> Tugas Tersetruktur</span></a></li>
                <?php } ?>
							</ul>
						</li>


						<li><a href='?pg=jadwal'>
							
							<img src="icon/time.svg" width="30" height="30">
							<span> Jadwal Ujian</span></a></li>
						<li class='treeview'>
							<a href='#'>
								
								<img src="icon/ubk.svg" width="30" height="30">
								<span> UBK</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=status2'>
									<img src="icon/computer.svg" width="20" height="17"> 
									<span> Status Peserta</span></a></li>
								<li><a href='?pg=reset'>
									<!-- <i class='fas fa-dot-circle fa-fw'></i> --> 
									<img src="icon/reset.svg" width="20" height="17"> 
									<span> Reset Login</span></a></li>
								<li><a href='?pg=token'><img src="icon/renew.svg" width="20" height="17">  <span> Rilis Token</span></a></li>
								<li><a href='?pg=pengacak'><img src="icon/random.svg" width="20" height="17"> <span> Pengacak Soal PG</span></a></li>
								<li><a href='?pg=block'><img src="icon/lock.svg" width="20" height="17"> <span> Atur Block Peserta</span></a></li>
								<li><a href='?pg=susulan'><img src="icon/warning.svg" width="20" height="17"> <span> Belum Ujian</span></a></li>
								<li><a href='?pg=filemanager2'><img src="icon/photo.svg" width="20" height="17"> <span> File manager Foto</span></a></li>
								<li><a href='?pg=filemanager'><img src="icon/upload.svg" width="20" height="17"> <span> File manager</span></a></li>
							</ul>
						</li>
						<?php if($setting['izin_absen']==1){ ?>
						<li class='treeview'>
							<a href='#'>
								<img src="icon/time2.svg" width="35" height="35"> 
								<span> Absen Sekolah Siswa </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=absen_tahun'><i class='fas fa-dot-circle fa-fw'></i> <span> Atur Tahun</span></a></li>
								<li><a href='?pg=absen_jam'><i class='fas fa-dot-circle fa-fw'></i> <span> Atur Jam Absen</span></a></li>
								<li><a href='?pg=absen_total'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Total</span></a></li>
								<li><a href='?pg=absen_detail'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Detail</span></a></li>
							</ul>
						</li>
            <?php }if($setting['izin_absen_mapel']==1){ ?>
            <li class='treeview'>
              <a href='#'>
                <img src="icon/time2.svg" width="35" height="35"> 
                <span> Absen Mapel Siswa </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
              <ul class='treeview-menu'>
                
                <li><a href='?pg=absen_permapel'><i class='fas fa-dot-circle fa-fw'></i> <span> Daftar Mapel Absen</span></a></li>
                <li><a href='?pg=absen_permapel_detail'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Mapel Detail</span></a></li>
                <li><a href='?pg=absen_siswamapel'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Manual Mapel</span></a></li>
                <li><a href='?pg=absen_izin'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Mapel Izin Mapel</span></a></li>
              </ul>
            </li>
            <?php } ?>
						<li class='treeview'>
							<a href='#'>
								<img src="icon/checklist.svg" width="35" height="35"> 
								<span> Nilai </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=nilai2'><img src="icon/result.svg" width="20" height="20"> <span> Hasil Nilai</span></a></li>
								<li><a href='?pg=nilai_mapel'><img src="icon/exam.svg" width="20" height="20"> <span> Hasil Nilai Per Mapel</span></a></li>
								<li><a href='?pg=semuanilai'><img src="icon/contract.svg" width="20" height="20"> <span>Semua Nilai</span></a></li>
								<li><a href='?pg=dataujian'><img src="icon/checklist2.svg" width="20" height="20"> <span>Data Nilai Ujian</span></a></li>
								<li><a href='?pg=nilai3'><img src="icon/file.svg" width="20" height="20"> <span> History Nilai / Jawaban</span></a></li>
							</ul>
						</li>
						<li class='treeview'>
							<a href='#'>
								
								<img src="icon/print.svg" width="30" height="30"> 
								<span> Cetak </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=absen'><img src="icon/agreement.svg" width="20" height="20"> <span> Daftar Hadir</span></a></li>
								<li><a href='?pg=kartu'><img src="icon/debit-card.svg" width="20" height="20"> <span> Cetak Kartu</span></a></li>
								<li><a href='?pg=dena'><img src="icon/computer.svg" width="20" height="20"> <span> Dena Lokasi</span></a></li>
								<li><a href='?pg=berita'><img src="icon/news.svg" width="20" height="20">  <span> Berita Acara</span></a></li>
								<li><a href='?pg=laporan'><img src="icon/printing.svg" width="20" height="20"> <span>Cetak Format Nilai</span></a></li>
								<li><a href='?pg=leger'><img src="icon/printing.svg" width="20" height="20"> <span>Cetak Leger Nilai</span></a></li>
							</ul>
						</li>
						<!-- <li class="treeview">
							<li class='treeview'><a href='prober.php' target='blank'><img src='../dist/img/svg/statistics.svg' width='30'> <span>Penggunaan System</span></a></li>
						</li> -->
						<!-- <li class='treeview'><a href='?pg=anso'><i class="fas fa-chart-line fa-2x fa-fw"></i> <span>Analisa Soal</span></a></li> -->
						<?php endif ?>
						
					<?php if ($pengawas['level'] == 'admin') : ?>
						<li class='treeview'>
							<a href='#'>
								<!-- <i class="fas fa-chart-line fa-2x fa-fw"></i> -->
								<img src="icon/stats.svg" width="30" height="30"> 
								<span> Analisa</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=anso'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Per Soal</span></a></li>
								<li><a href='?pg=anso_nilai'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Mapel</span></a></li>
								<li><a href='?pg=anso_ranking'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Ranking</span></a></li>
								<li><a href='?pg=anso_perbaikan'><i class='fas fa-dot-circle fa-fw'></i> <span>Perbaikan Nilai</span></a></li>
							</ul>
						</li>
						<!-- <li class='treeview'><a href='?pg=pengumuman'><i class="fas fa-bullhorn   fa-2x fa-fw"></i> <span> Pengumuman</span></a></li> -->
						<li class='treeview'>
							<a href='#'>
								<!-- <i class="fas fa-users-cog   fa-2x fa-fw"></i>  -->
								<img src="icon/team.svg" width="30" height="30">  
								<span>Manajemen User</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=pengawas'><i class='fas fa-dot-circle fa-fw'></i> <span>Data Administrator</span></a></li>
								<li><a href='?pg=guru'><i class='fas fa-dot-circle fa-fw'></i> <span>Data Guru</span></a></li>
							</ul>
						</li>
						
					<?php endif ?>

					<!-- menu Untuk guru -->
					<?php if ($pengawas['level'] == 'guru') : ?>
						<?php if($setting['izin_absen']==1){ ?>
						<li class='treeview'>
							<a href='#'>
								<img src="icon/time2.svg" width="35" height="35"> 
								<span> Absen Sekolah Siswa </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=absen_total'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Sekolah Total</span></a></li>
								<li><a href='?pg=absen_detail'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Sekolah Detail</span></a></li>
							</ul>
						</li>
						<?php }if($setting['izin_absen_mapel']==1){ ?>
						<li class='treeview'>
							<a href='#'>
								<img src="icon/time2.svg" width="35" height="35"> 
								<span> Absen Mapel Siswa </span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								
								<li><a href='?pg=absen_permapel'><i class='fas fa-dot-circle fa-fw'></i> <span> Daftar Absen Mapel  </span></a></li>
								<li><a href='?pg=absen_permapel_detail'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Mapel Detail</span></a></li>
                <li><a href='?pg=absen_siswamapel'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Manual Mapel</span></a></li>
                <li><a href='?pg=absen_izin'><i class='fas fa-dot-circle fa-fw'></i> <span> Absen Mapel Izin</span></a></li>
							</ul>
						</li>
						<?php }?>
						<?php if($setting['izin_ujian']==1){ ?>
						
						<li class='treeview'>
							<a href='#'>
								<!-- <i class="fas fa-chart-line fa-2x fa-fw"></i> -->
								<img src="icon/stats.svg" width="30" height="30"> 
								<span> Analisa</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=anso'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Per Soal</span></a></li>
								<li><a href='?pg=anso_nilai'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Mapel</span></a></li>
								<li><a href='?pg=anso_ranking'><i class='fas fa-dot-circle fa-fw'></i> <span>Analisa Nilai Ranking</span></a></li>
								<li><a href='?pg=anso_perbaikan'><i class='fas fa-dot-circle fa-fw'></i> <span>Perbaikan Nilai</span></a></li>
							</ul>
						</li>
						<?php }else{ } ?>
						<li class='treeview'><a href='?pg=siswa'><img src="icon/user.svg" width="30" height="25"> <span>Peserta Ujian</span></a></li>
						<li><a href='?pg=editguru'><i class="fas fa-users-cog   fa-2x fa-fw"></i> <span>Profil Saya</span></a></li>
						
						<li class='treeview'>
							<a href='#'>
								<!-- <i class="fas fa-user-secret fa-2x fa-fw"></i> -->
								<img src="icon/todo_list.svg" width="30" height="30">
								<span> E-Learning</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<?php if($setting['izin_materi']==1){ ?>
								<li><a href='?pg=token_telegram'><img src="icon/telegram.svg" width="30" height="20"> <span> Token Telegram</span></a></li>
								<li><a href='?pg=materi_pb'><img src="icon/book3.svg" width="30" height="20"> <span> Materi Pembelajaran</span></a></li>
								<?php } if($setting['izin_tugas']==1){ ?>
								<li><a href='?pg=tugas_pb'><img src="icon/book.svg" width="30" height="20"> <span> Tugas Tersetruktur</span></a></li>
								<?php }?>
							</ul>
						</li>
						<?php if($setting['izin_ujian']==1){ ?>
						<li><a href='?pg=banksoal'><img src="icon/folder.svg" width="30" height="25"> <span>Bank Soal</span></a></li>
						<!-- mryes -->
						<li><a href='?pg=jadwal'><img src="icon/time.svg" width="30" height="30"> <span> Jadwal Ujian</span></a></li>
					
						<!-- menu di guru UBK -->
						<li class='treeview'>
							<a href='#'><img src="icon/ubk.svg" width="30" height="30"><span> UBK</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=status2'><img src="icon/computer.svg" width="20" height="17"> <span> Status Peserta</span></a></li>
								<li><a href='?pg=reset'><img src="icon/reset.svg" width="20" height="17">  <span> Reset Login</span></a></li>
								<li><a href='?pg=token'><img src="icon/renew.svg" width="20" height="17"> <span> Token Ujian</span></a></li>
							</ul>
						</li>
						<?php }else{ } ?>
						<?php endif ?>
						<?php if ($pengawas['level'] == 'peng') : ?>
						<li class='treeview'>
							<a href='#'><img src="icon/ubk.svg" width="30" height="30"><span> UBK</span><span class='pull-right-container'> <i class='fa fa-angle-down pull-right'></i> </span></a>
							<ul class='treeview-menu'>
								<li><a href='?pg=reset'><img src="icon/reset.svg" width="20" height="17">  <span> Reset Login</span></a></li>
								<li><a href='?pg=token'><img src="icon/renew.svg" width="20" height="17"> <span> Token Ujian</span></a></li>
							</ul>
						</li>
						<?php endif ?>
						<!-- mryes -->
					<?php if ($pengawas['level'] == 'guru') : ?>
							<?php if($setting['izin_ujian']==1){ ?>
								<li><a href='?pg=nilai2'><img src="icon/result.svg" width="30" height="30"> <span>Hasil Nilai</span></a></li>
							<?php }else{ } ?>
					<?php endif ?>
					
					<hr style="margin:0px">
					<?php
					if ($setting['jenjang'] == 'SMK') {
						$jenjang = 'SMK/SMA/MA';
					} elseif ($setting['jenjang'] == 'SMP') {
						$jenjang = 'SMP/MTS';
					} else {
						$jenjang = 'SD/MI';
					}
					?>
				</ul><!-- /.sidebar-menu -->
			</section>