<?php
cek_session_admin();
$info1 = $info2 = $info3 = $info4 = '';
$admin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM pengawas WHERE level='admin' AND id_pengawas='1'"));
$setting = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM setting WHERE id_setting='1'"));
$setting['alamat'] = str_replace('<br />', '', $setting['alamat']);
$setting['header'] = str_replace('<br />', '', $setting['header']);

$prop = $setting['XProv'];
$kab  = $setting['XKab'];
$kec  = $setting['XKec'];

$sql1 = mysqli_query($koneksi,"select * from inf_lokasi where lokasi_kabupatenkota='$kab' and lokasi_propinsi='$prop' and lokasi_kecamatan='0000' and lokasi_kelurahan='0000'");
$xadm1 = mysqli_fetch_array($sql1);
$xkab= $xadm1['lokasi_nama'];

$sql2 = mysqli_query($koneksi,"select * from inf_lokasi where lokasi_kecamatan='$kec' and lokasi_kabupatenkota='$kab' and lokasi_propinsi='$prop' and lokasi_kelurahan='0000'");
$xadm2 = mysqli_fetch_array($sql2);
$xkec= $xadm2['lokasi_nama'];


$sql3 = mysqli_query($koneksi,"select * from inf_lokasi where lokasi_propinsi='$prop' and lokasi_kecamatan='00' and lokasi_kelurahan='0000' and lokasi_kabupatenkota='00'");
$xadm3 = mysqli_fetch_array($sql3);
$xprop= $xadm3['lokasi_nama'];


?>
<div class='row'>
	<div class='col-md-12'>
		<div class="box box-solid">
			<!-- Add the bg color to the header using any of the bg-* classes -->
			<div class="box-header with-border">
				<h3 class="box-title"><i class="fas fa-tools fa-2x fa-fw"></i> Pengaturan</h3>
			</div>
			<div class="box-body no-padding ">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Pengaturan Umum</a></li>
						<li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Hapus Data</a></li>
						<li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Backup & Restore</a></li>
						<li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Backup Master Soal</a></li>
						<li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Backup File Pendukung</a></li>

					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1">
							<form id="formpengaturan" action='' method='post' enctype='multipart/form-data'>

								<div class='box-body'>
									<div class='row'>
											<div class='col-md-12'>
											<button type='submit' name='submit1' class='btn btn-flat pull-right btn-success' style='margin-bottom:5px'><i class='fa fa-check'></i> Simpan</button>
											<?= $info1 ?>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-2'>
												<label>Siswa Ganti Password</label>
												<?php 
												if($setting['izin_pass']==1){ $pass1="selected"; }
												else{ $pass2="selected"; }
												?>
												<select name='izin_pass' class='form-control' required='true'>
													<option value='1' <?= $pass1; ?> >AKTIF</option>
													<option value='0' <?= $pass2; ?>>TIDAK</option>
												</select>
												<span><i style="color: red;">Pada Menu Siswa</i></span>
											</div>
											<div class='col-md-2'>
												<label>Siswa Materi</label>
												<?php 
												if($setting['izin_materi']==1){ $pass3="selected"; }
												else{ $pass4="selected"; }
												?>
												<select name='izin_materi' class='form-control' required='true'>
													<option value='1' <?= $pass3; ?> >AKTIF</option>
													<option value='0' <?= $pass4; ?>>TIDAK</option>
												</select>
											</div>
											<div class='col-md-2'>
												<label>Siswa Tugas</label>
												<?php 
												if($setting['izin_tugas']==1){ $pass5="selected"; }
												else{ $pass6="selected"; }
												?>
												<select name='izin_tugas' class='form-control' required='true'>
													<option value='1' <?= $pass5; ?> >AKTIF</option>
													<option value='0' <?= $pass6; ?>>TIDAK</option>
												</select>
											</div>
											<div class='col-md-2'>
												<label>Pengumuman</label>
												<?php 
												if($setting['izin_info']==1){ $pass5="selected"; }
												else{ $pass6="selected"; }
												?>
												<select name='izin_info' class='form-control' required='true'>
													<option value='1' <?= $pass5; ?> >AKTIF</option>
													<option value='0' <?= $pass6; ?>>TIDAK</option>
												</select>
											</div>
											<div class='col-md-3'>
												<label>Fitur Ujian Siswa dan Guru</label>
												<?php 
												if($setting['izin_ujian']==1){ $pass7="selected"; }
												else{ $pass8="selected"; }
												?>
												<select name='izin_ujian' class='form-control' required='true'>
													<option value='1' <?= $pass7; ?> >AKTIF</option>
													<option value='0' <?= $pass8; ?>>TIDAK</option>
												</select>
											</div>

										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-3'>
												<label>Nama Aplikasi</label>
												<input type='text' name='aplikasi' value="<?= $setting['aplikasi'] ?>" class='form-control' required='true' />
											</div>
											<div class='col-md-3'>
												<label>Nama PJJ</label>
												<input type='text' name='pjj' value="<?= $setting['namapjj'] ?>" class='form-control' required='true' />
											</div>
											<div class='col-md-2'>
												<label>Absen Sekolah</label>
												<?php 
												if($setting['izin_absen']==1){ $pass12="selected"; }
												else{ $pass13="selected"; }
												?>
												<select name='izin_absen' class='form-control' required='true'>
													<option value='1' <?= $pass12; ?> >AKTIF</option>
													<option value='0' <?= $pass13; ?>>TIDAK</option>
												</select>
											</div>
											<div class='col-md-2'>
												<label>Absen Mapel</label>
												<?php 
												if($setting['izin_absen_mapel']==1){ $pass9="selected"; }
												else{ $pass10="selected"; }
												?>
												<select name='izin_absen_mapel' class='form-control' required='true'>
													<option value='1' <?= $pass9; ?> >AKTIF</option>
													<option value='0' <?= $pass10; ?>>TIDAK</option>
												</select>
											</div>
											<div class='col-md-2'>
												<label>Foto Absen</label>
												<?php 
												if($setting['izi_foto_absen']==1){ $pass20="selected"; }
												else{ $pass21="selected"; }
												?>
												<select name='izi_foto_absen' class='form-control' required='true'>
													<option value='1' <?= $pass20; ?> >AKTIF</option>
													<option value='0' <?= $pass21; ?>>TIDAK</option>
												</select>
											</div>
											<!-- <div class='col-md-6'>
												<label>Ganti Nama Folder Admin</label>
												<input disabled="disabled" type='text' name='folder_baru' value="<?= $setting['folder_admin'] ?>" class='form-control' required='true' />
												<input type='hidden' name='folder_lama' value="<?= $setting['folder_admin'] ?>" class='form-control' />
												<span><i style="color: red;">Setelah Ganti Nama Folder admin jangan lupa ganti juga nam foldernya (Manual)</i></span>
											</div> -->
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Nama Sekolah</label>
												<input type='text' name='sekolah' value="<?= $setting['sekolah'] ?>" class='form-control' required='true' />
											</div>
											<div class='col-md-4'>
												<label>Kode Sekolah</label>
												<input type='text' name='kode' value="<?= $setting['kode_sekolah'] ?>" class='form-control' required='true' />
											</div>
                      <div class='col-md-2'>
                        <label>Maintenance</label>
                        <?php 
                        if($setting['LoginSiswaMainten']==1){ $pass22="selected"; }
                        else{ $pass23="selected"; }
                        ?>
                        <select name='mainten' class='form-control' required='true'>
                          <option value='1' <?= $pass22; ?> >AKTIF</option>
                          <option value='0' <?= $pass23; ?>>TIDAK</option>
                        </select>
                      </div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Alamat Server / Ip Server</label>
												<input type='text' name='ipserver' value="<?= $setting['ip_server'] ?>" class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>Waktu Server</label>
												<select name='waktu' class='form-control' required='true'>
													<option value="<?= $setting['waktu'] ?>"><?= $setting['waktu'] ?></option>
													<option value='Asia/Jakarta'>Asia/Jakarta</option>
													<option value='Asia/Makassar'>Asia/Makassar</option>
													<option value='Asia/Jayapura'>Asia/Jayapura</option>
												</select>
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-3'>
											<label>Jenjang</label>
											<select name='jenjang' class='form-control' required='true'>
												<option value="<?= $setting['jenjang'] ?>"><?= $setting['jenjang'] ?></option>
												<option value='SD'>SD/MI</option>
												<option value='SMP'>SMP/MTS</option>
												<option value='SMK'>SMK/SMA/MA</option>
												<option value='SUKA'>SUKA-SUKA</option>
											</select>
											</div>
											<div class='col-md-4'>
												<label>TOKEN VALIDASI</label>
										    <div class="input-group">
										      <span class="input-group-btn">
										        <button class="btn btn-primary" type="button"><i class="fa fa-spinner fa-spin"></i> </button>
										      </span>
										      <input name='db_token1' id="isi_token1" value="<?= $setting['db_token1'] ?>" type="text" class="form-control" placeholder="Token Validasi...">
										    </div><!-- /input-group -->
										    <span><i style="color: red;">Samakan saja dengan Tokep Api</i></span>
											</div>
											<!-- <div class='col-md-4'>
											<label>TOKEN API</label>
											<input placeholder="Masukan Token / Kunci Kombinasi huruf dan angka" type='text' name='db_token' value="<?= $setting['db_token'] ?>" class='form-control' />
											<span><i style="color: red;">Token adalah Kunci untunk Kompunikasi Pusat denga Lokal</i></span>
											</div> -->
											<div class='col-md-5'>
												<label>TOKEN API</label>
										    <div class="input-group">
										      <span class="input-group-btn">
										        <button id="acak_token" class="btn btn-primary" type="button"><i class="fa fa-spinner fa-spin"></i> Acak</button>
										      </span>
										      <input name='db_token' id="isi_token" value="<?= $setting['db_token'] ?>" type="text" class="form-control" placeholder="Token Api...">
										    </div><!-- /input-group -->
										    <span><i style="color: red;">Token adalah Kunci untunk Kompunikasi Pusat denga Lokal</i></span>
											</div>
										</div>
									</div>
									<div class='form-group'>
										<label>Kepala Sekolah</label>
										<input type='text' name='kepsek' value="<?= $setting['kepsek'] ?>" class='form-control' />
									</div>
									<div class='form-group'>
										<label>NIP Kepala Sekolah</label>
										<input type='text' name='nip' value="<?= $setting['nip'] ?>" class='form-control' />
									</div>
									<hr>
									<div class='form-group'>
										<label>Proktor /Teknisi</label>
										<input type='text' name='protek' value="<?= $setting['protek'] ?>" class='form-control' />
									</div>
									<div class='form-group'>
										<label>NIP</label>
										<input type='text' name='nip_protek' value="<?= $setting['nip_protek'] ?>" class='form-control' />
									</div>
									<hr>
									<div class='form-group'>
										<label>Alamat</label>
										<textarea name='alamat' class='form-control' rows='3'><?= $setting['alamat'] ?></textarea>
									</div>
									<!-- mryes -->
									<div class='form-group'>
										<div class="row">
											<div class="col-md-12" style="color:red; font-weight: bold;">
												<i>Jika Kota / Kabupaten Tidak ada di Opsi Pilihan, Bisa menggukan Versi 1 Untuk Inputnya ^_^</i> &nbsp;<a class="btn btn-primary" id="kotaversi1"> Aktifkan Kota Versi 1</a>
												<a class="btn btn-danger hilang" id="kotaversi2"> Aktifkan Kota Pilihan</a>
											</div>
										</div>
										<style type="text/css">
											.hilang{
												visibility: hidden;
											}
										</style>
										<script type="text/javascript">
												$(document).ready(function() {
													$("#kotaversi1").click(function(){            
														$('#prop').attr("disabled", "disabled");
														$('#kota').attr("disabled", "disabled");
														$('#kec').attr("disabled", "disabled");
														$('#keb1').attr('disabled', false);
														$('#kec1').attr('disabled', false);
														$('#kotaversi2').removeClass("hilang");
														$('#kotaversi1').addClass("hilang");
													});
													$("#kotaversi2").click(function(){            
														$('#prop').attr("disabled", false);
														$('#kota').attr("disabled", false);
														$('#kec').attr("disabled", false);
														$('#keb1').attr('disabled', "disabled");
														$('#kec1').attr('disabled', "disabled");
														$('#kotaversi1').removeClass("hilang");
														$('#kotaversi2').addClass("hilang");

													});
												});
										</script>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Provinsi</label>
												<!-- <input type='text' name='kota' value="<?= $setting['kota'] ?>" class='form-control' /> -->
												<select class='form-control' name='XProv' id='prop' onchange='ajaxkota(this.value)'>
													<option >Pilih</option>
													
													<?php 
													$queryProvinsi=mysqli_query($koneksi,"SELECT * FROM inf_lokasi where lokasi_kabupatenkota=0 and lokasi_kecamatan=0 and lokasi_kelurahan=0 order by lokasi_nama");
														while ($dataProvinsi=mysqli_fetch_array($queryProvinsi)){
														?> 
														<option <?php if($prop==$dataProvinsi['lokasi_propinsi']){ echo"selected";} ?> value='<?php echo $dataProvinsi['lokasi_propinsi'];?>'>
															<?php echo $dataProvinsi['propinsi'].$dataProvinsi['lokasi_nama'];?></option>
													<?php 	} ?>
											</select>
											</div>
											<div class='col-md-6'>
												<!-- <label>Kecamatan</label> -->
												<!-- <input type='text' name='kecamatan' value="<?= $setting['kecamatan'] ?> " class='form-control' /> -->
													<label>Kota/Kabupaten</label>
													<select class='form-control'name='XKab' id='kota' onchange='ajaxkec(this.value)'>
														<option value='<?= $kab ?>'><?= $xkab ?></option>
													</select>
											
											</div>
										</div>
									</div>
									<!-- /mryes -->
									<div class='form-group'>
										<div class='row'>
												<div class='col-md-4'>
												<!-- <input type='text' name='kecamatan' value="<?= $setting['kecamatan'] ?> " class='form-control' /> -->
														<label>Kecamatan</label>
														<select class='form-control' name='XKec' id='kec' onchange='ajaxkel(this.value)'>
															<option value='<?= $kec ?>'><?= $xkec ?></option>
														</select>
												</div>
										
												<div class='col-md-4'>
													<label>Kota/Kabupaten Versi 1</label>
													<input disabled="disabled" type='text' id="keb1" name='kab1' value="<?= $setting['kota'] ?>" class='form-control' />
												</div>
											
										
												<div class='col-md-4'>
													<label>Kecamatan Versi 1</label>
													<input disabled="disabled" type='text' id="kec1" name='kec1' value="<?= $setting['kecamatan'] ?>" class='form-control' />
												</div>
											</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Telepon</label>
												<input type='text' name='telp' value="<?= $setting['telp'] ?>" class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>Fax</label>
												<input type='text' name='fax' value="<?= $setting['fax'] ?>" class='form-control' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Website</label>
												<input type='text' name='web' value="<?= $setting['web'] ?>" class='form-control' />
											</div>
											<div class='col-md-6'>
												<label>E-mail</label>
												<input type='text' name='email' value="<?= $setting['email'] ?>" class='form-control' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Logo Sekolah (format .png)</label>
												<input type='file' name='logo' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="<?= $homeurl ?>/<?= $setting['logo'] ?>" height='50' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Tanda Tangan (format .png)</label>
												<input type='file' name='ttd' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="
												<?php echo $homeurl.'/dist/img/ttd.png'.'?date='.time(); ?> ?>" height='50' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Logo Instansi (format .png)</label>
												<input type='file' name='instansi' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="
												<?php echo $homeurl.'/dist/img/logo2.png'.'?date='.time(); ?>" height='50' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Background Tampilan Login Admin (format .jpg)</label>
												<input type='file' name='login_admin' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="
												<?php echo $homeurl.'/dist/img/loginadmin.jpg'.'?date='.time(); ?>" height='50' />
											</div>
										</div>
									</div>
									<div class='form-group'>
										<div class='row'>
											<div class='col-md-6'>
												<label>Background Tampilan Login Siswa (format .jpg)</label>
												<input type='file' name='login_siswa' class='form-control' />
											</div>
											<div class='col-md-2'>
												&nbsp;<br />
												<img class='img img-responsive' src="
												<?php echo $homeurl.'/dist/img/loginsiswa.jpg'.'?date='.time(); ?>" height='50' />
											</div>
										</div>
									</div>
									<button type='submit' name='submit1' class='btn btn-flat pull-right btn-success' style='margin-bottom:5px'><i class='fa fa-check'></i> Simpan</button>
									<div class='form-group'>
										<label>Judul Pesan Singkat Halam Login Siswa (50 Kata)</label>
										<input type='text' id="judul_pesan" name='judul_pesan' value="<?= $setting['JudulPesanSingkat'] ?>" class='form-control' />
									</div>
									<div class='form-group'>
										<label>Isi Pesan Singkat Halam Login Siswa (150 Kata) </label>
										<textarea name='isi_pesan' class='form-control' rows='3'><?= $setting['IsiPesanSingkat'] ?></textarea>
									</div>
									<div class='form-group'>
										<label>Header Laporan</label>
										<textarea name='header' class='form-control' rows='3'><?= $setting['header'] ?></textarea>
									</div>

								</div><!-- /.box-body -->

							</form>
						</div>
						
						<div class="tab-pane" id="tab_2">
							<form id='formhapusdata' action='' method='post'>
								<div class='box-body'>
									<?= $info4 ?>
									<div class='form-group'>
										<label>Pilih Data</label>
										<div class='row'>
											<div class='col-md-5'>
												<div class='checkbox'>
													<small class='label bg-aqua'>Pilih Absensi Materi dan Tugas</small><br />
													<label><input type='checkbox' name='data[]' value='absensi' /> Data Absensi Siswa</label><br />
													<label><input type='checkbox' name='data[]' value='absensi_mapel_anggota' /> Data Absensi Mapel Siswa</label><br />
													<label><input type='checkbox' name='data[]' value='absensi_mapel' /> Data Mapel Absensi</label><br />
													<label><input type='checkbox' name='data[]' value='materi2' /> Data Materi</label><br />
													<label><input type='checkbox' name='data[]' value='tugas' /> Data Tugas</label><br />
													<small class='label bg-purple'>Pilih Data Hasil Nilai</small><br />
													<label><input type='checkbox' name='data[]' value='nilai' /> Data Nilai</label><br />

													<label><input type='checkbox' name='data[]' value='jawaban' /> Data Jawaban</label><br />
													
													<small class='label bg-green'>Pilih Data Ujian</small><br />
													<label><input type='checkbox' name='data[]' value='soal' /> Data Soal</label><br />
													<label><input type='checkbox' name='data[]' value='mapel' /> Data Bank Soal</label><br />
													<label><input type='checkbox' name='data[]' value='ujian' /> Data Jadwal Ujian</label><br />
													<label><input type='checkbox' name='data[]' value='berita' /> Data Berita Acara</label><br />
													<label><input type='checkbox' name='data[]' value='pengacak' /> Data Pengacak Soal</label><br />
													<label><input type='checkbox' name='data[]' value='log' /> Data Log Login</label><br />
													<small class='label label-primary'>Pilih Data Mapel</small><br />
													<label><input type='checkbox' name='data[]' value='mata_pelajaran' /> Data Mata Pelajaran</label><br />
													<label><input type='checkbox' name='data[]' value='file_pendukung' /> Data File Pendukung</label><br />
													<small class='label label-danger'>Pilih Data Master</small><br />
													<label><input type='checkbox' name='data[]' value='siswa' /> Data Siswa</label><br />
													<label><input type='checkbox' name='data[]' value='kelas' /> Data Kelas</label><br />
													
													<label><input type='checkbox' name='data[]' value='pk' /> Data Jurusan</label><br />
													<label><input type='checkbox' name='data[]' value='level' /> Data Level</label><br />
													<label><input type='checkbox' name='data[]' value='ruang' /> Data Ruangan</label><br />
													<label><input type='checkbox' name='data[]' value='sesi' /> Data Sesi</label><br />

												</div>
											</div>
											<div class='col-md-7'>
												<button type='submit' name='submit3' class='btn btn-sm bg-maroon'><i class='fa fa-trash-o'></i> Kosongkan</button>
												<div class='form-group'>
													<label>Password Admin</label>
													<input type='password' name='password' class='form-control' required='true' />
												</div>

												<p class='text-danger'><i class='fa fa-warning'></i> <strong>Mohon di ingat!</strong> Data yang telah dikosongkan tidak dapat dikembalikan.</p>

												<p class='text-danger'><strong><i>Catatan</i></strong></p>
												<p class='text'><i class='fa fa-warning'></i>
													Hapus Data Jadwal Ujian , Harus menghapus Data Nilai dan Data Jawaban Terlebih Dahulu 
												</p>
												<p class='text'><i class='fa fa-warning'></i>
													Data Siswa Tidak Akan bisa di hapus apabila Siswa sudah meiliki Nilai Ujian
												</p>
											</div>
										</div>
									</div>
								</div><!-- /.box-body -->
							</form>
						</div>
						
						<div class="tab-pane" id="tab_3">
							<div class='col-md-12 notif'></div>
							<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Backup Data</h3>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<p>Klik Tombol dibawah ini untuk membackup database </p>
										<button id='btnbackup' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Backup Data</button>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
							<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Restore Data</h3>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<form id='formrestore'>
											<p>Klik Tombol dibawah ini untuk merestore database </p>
											<div class='col-md-8'>
												<input class='form-control' name='datafile' type='file' required />
											</div>
											<button name='restore' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Restore Data</button>
										</form>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
						</div>

						<div class="tab-pane" id="tab_4">
							<div class="row">
								<div class='col-md-12 notif_mapel'></div>
								<div class='col-md-12'>
									<div class="panel panel-default">
										<div class="panel-body">
											<label for="mapel" class="col-sm-2">Mapel yang Tersedia</label>
											<div class="col-sm-10">
												<select name="mapel_id" id="mapel_id" class="form-control select2" style="width: 100%;" required>
													<?php $mapelbackup = mysqli_query($koneksi, "SELECT a.id_mapel, b.kode_mapel, b.nama_mapel FROM mapel a INNER JOIN mata_pelajaran b ON a.nama = b.kode_mapel INNER JOIN soal c ON a.id_mapel = c.id_mapel GROUP BY c.id_mapel ASC"); ?>
													<?php while ($mapelb = mysqli_fetch_array($mapelbackup)) : ?>
														<option value="<?= $mapelb['id_mapel'] . ";" . $mapelb['kode_mapel'] ?>"><?= $mapelb['id_mapel'] . " - " . $mapelb['nama_mapel'] ?></option>
													<?php endwhile ?>
												</select>
											</div>
										</div>
										<div class="panel-footer clearfix">
											<div class="pull-right">
												<button id='mastersoal' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Proses</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tab-pane" id="tab_5">
							<div class='container'>
							<div class="row">
							 <h1>Backup dan Download File Pendukung Soal</h1>
							 	<!-- <form id="backup_file">
							   <input  type='submit' name='create' value='Create Zip' />&nbsp;
							   <input type='submit' name='download' value='Download' />
							 	</form> -->
							 	<button id="backup_file" class="btn btn-primary"><i class='fa fa-database'></i> Backup</button>
							 	<button id="down_file" class="btn btn-success"><i class="fa fa-exclamation"></i> Cek File Pendukung</button>
							 	<a href="backup_soal/file_pendukung.zip"><button id="cek" class="btn btn-info" style="display: none;"> <i class="fa fa-download"></i> download file</button></a>
							 <!-- 	<a href='ekspor_soal.php' class='btn btn-sm btn-success'><i class='fa fa-download'></i> <span class='hidden-xs'>Download Data</span></a> -->
							</div>
							<hr>
							<div class="row">
								<div class='col-md-6'>
								<div class='box box-solid'>
									<div class='box-header '>
										<h3 class='box-title'>Upload File Pendukung</h3>
									</div><!-- /.box-header -->
									<div class='box-body'>
										<form id='formdukung'>
											<p>Klik Tombol dibawah ini untuk Upload File Pendukung</p>
											<div class='col-md-8'>
												<input class='form-control' name='dukung' type='file' required />
											</div>
											<button name='dukungfile' class='btn btn-flat btn-success'><i class='fa fa-database'></i> Restore Data</button>
										</form>
									</div><!-- /.box-body -->
								</div><!-- /.box -->
							</div>
							</div>

							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function generate_token(length){
    //edit the token allowed characters
    var a = "CandyRoyalabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split("");
    var b = [];  
    for (var i=0; i<length; i++) {
        var j = (Math.random() * (a.length-1)).toFixed(0);
        b[i] = a[j];
    }
    return b.join("");
}
	$("#acak_token").click(function() {
			
			$token = generate_token(30);
			$("#isi_token").val($token);
			$("#isi_token1").val($token);
			
		});
	$('#formrestore').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		//console.log(data);
		$.ajax({
			type: 'POST',
			url: 'restore.php',
			//url: 'restore_arsip.php',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$("#pesanku").text("Mohon Tunggu Proses Restore ...! 5-10 Menit");
				$('.loader').show();
			},
			success: function(data) {
				$('.loader').hide();
				toastr.success(data);

			}
		});
		return false;
	});
	$('#formpengaturan').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
		//console.log(data);
		$.ajax({
			type: 'POST',
			url: 'simpan_setting.php',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				swal({
					text: 'Proses Penyimpanan ...!',
					timer: 1000,
					onOpen: () => {
						swal.showLoading()
					}
				});
			},
			success: function(data) {
				
				toastr.success("pengaturan berhasil disimpan");
				setInterval(function(){ location.reload(true); }, 1000);

			}
		});
		return false;
	});
	$('#formhapusdata').submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: 'simpan_hapusdata.php',
			data: $(this).serialize(),
			beforeSend: function() {
				$("#pesanku").text("Mohon Tunggu Proses Penghapusan ...!");
				$('.loader').show();
			},
			success: function(data) {
				console.log(data);
				if (data == "ok") {
					$('.loader').hide();
					toastr.success("Data Terpilih telah dikosongkan");
				} else {
					$('.loader').hide();
					toastr.error(data);
				}

			}
		});
		return false;
	});
</script>
<script type="text/javascript">
	$('#backup_file').click(function(e) {
		// alert('asds');
		$data = 1;
		$.ajax({
		type: 'POST',
		url: 'backup_file_pendukung.php',
		data: 'id=' + $data,
		beforeSend: function() {
			$("#pesanku").text("Mohon Tunggu Proses Backup ...!");
			$('.loader').show();
		},
		success: function(data) {
			$('.loader').hide();
			toastr.success(data);
		}
		});
	});
	$('#down_file').click(function(e) {
		$data = 2;
		$.ajax({
			type: 'POST',
			url: 'backup_file_pendukung.php',
			data: 'id=' + $data,
			beforeSend: function() {
				$('.loader').show();
			},
			success: function(data) {
				$('.loader').hide();
			if(data==1){
				$('#cek').show();
			}
			else if(data==100){
				toastr.error("Upsss Terjadi Error");
			}
			else{
				toastr.error(data);
			}
		}
		});
	});
	$('#formdukung').submit(function(e) {
		e.preventDefault();
		var data = new FormData(this);
			//console.log(data);
		$.ajax({
			type: 'POST',
			url: 'backup_file_pendukung.php?restore=yes',
			enctype: 'multipart/form-data',
			data: data,
			cache: false,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$("#pesanku").text("Mohon Tunggu Proses Restore ...! 5-10 Menit");
				$('.loader').show();
			},
			success: function(data) {
			$('.loader').hide();
				if(data==1){
					toastr.success('Berhasil Upload File Pendukung');
				}
				else if(data==100){
					toastr.error("Upsss Terjadi Error");
				}
				else{
					toastr.error(data);
				}
				
			}
			});
		return false;
	});
</script>